<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanCommitteeApproval;
use App\Models\LoanDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminLoanController extends Controller
{
    /**
     * Check if a given approval_order has an assigned admin in the system.
     */
    private function stageHasAssignedAdmin(int $order): bool
    {
        return \App\Models\User::where('role', '=', 'admin')
            ->where('approval_order', '=', $order)
            ->exists();
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $myOrder = $user->approval_order;
        $query = Loan::with('member')->latest();

        // Filter by Stage based on Role
        // 1=Chairman, 2=Finance, 3=Auditor, 5=Treasurer, 4=Manager
        // If a stage has no assigned admin, any canManageLoans() admin can act as substitute.

        if ($myOrder == 4) { // Manager
            $query->where('stage', Loan::STAGE_MANAGER_REVIEW);
        } elseif ($myOrder == 1) {
            // Chairman sees Stage 1 (Initial Review) OR Stage 4 (Final Approval)
            $stages = [Loan::STAGE_CHAIRMAN_REVIEW, Loan::STAGE_CHAIRMAN_FINAL];

            // Also pick up any stage that has no assigned admin (substitute mode)
            if (!$this->stageHasAssignedAdmin(2)) $stages[] = Loan::STAGE_FINANCE_REVIEW;
            if (!$this->stageHasAssignedAdmin(3)) $stages[] = Loan::STAGE_AUDITOR_REVIEW;
            if (!$this->stageHasAssignedAdmin(5)) $stages[] = Loan::STAGE_TREASURER_DISBURSE;

            $query->whereIn('stage', array_unique($stages));

        } elseif ($myOrder == 2) { // Finance
            $query->where('stage', Loan::STAGE_FINANCE_REVIEW);
        } elseif ($myOrder == 3) { // Auditor
            $query->where('stage', Loan::STAGE_AUDITOR_REVIEW);
        } elseif ($myOrder == 5) { // Treasurer
            $query->where('stage', Loan::STAGE_TREASURER_DISBURSE);
        } else {
            // Other admins (e.g. PRO) — show nothing unless canManageLoans()
            if (!$user->canManageLoans()) {
                $query->where('id', 0);
            }
        }

        // Status filters
        if ($request->has('status') && $request->status != 'all') {
            // If viewing history tabs (approved/rejected/disbursed), reset stage filter
            // so we can see all historical records, not just the current queue.
            if (in_array($request->status, ['approved', 'rejected', 'disbursed'])) {
                $query = Loan::with('member')->latest();
            }
            $query->where('status', $request->status);
        }
        // Default (no ?status= param): rely solely on the stage filter above.
        // Each admin's stage filter already scopes them to their actionable loans.
        // Note: Treasurer-stage loans have status='approved' (set by Chairman Final),
        // so we must NOT force status='pending' here or the Treasurer sees nothing.

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereNested(function($q) use ($search) {
                $q->where('application_number', 'like', "%$search%")
                  ->orWhereHas('member', function($mq) use ($search) {
                      $mq->where('first_name', 'like', "%$search%")
                         ->orWhere('last_name', 'like', "%$search%");
                  });
            });
        }

        $loans = $query->paginate(10);

        return view('admin.loans.index', compact('loans'));
    }

    public function show(Loan $loan)
    {
        $loan->load(['member', 'guarantors', 'documents', 'committeeApprovals.user']);
        
        // We still need the list of admins to show the sequence visualization
        $admins = \App\Models\User::where('role', '=', 'admin')
            ->whereIn('approval_order', [4, 1, 2, 3, 5]) // Manager, Chair, Fin, Aud, Treas
            ->orderByRaw('CASE 
                WHEN approval_order = 4 THEN 1 
                WHEN approval_order = 1 THEN 2 
                WHEN approval_order = 2 THEN 3 
                WHEN approval_order = 3 THEN 4 
                WHEN approval_order = 5 THEN 5 
                ELSE 6 END')
            ->get();

        // Check if current user has already approved (for history/visuals)
        $myApproval = $loan->committeeApprovals()->where('user_id', Auth::id())->latest()->first();

        return view('admin.loans.show', compact('loan', 'myApproval', 'admins'));
    }

    public function approve(Request $request, Loan $loan)
    {
        $request->validate([
            'comment' => 'nullable|string',
            'signature_image' => 'nullable|file|image|max:2048',
        ]);

        $user = Auth::user();
        $myOrder = $user->approval_order;
        $currentStage = $loan->stage;

        // Validation: Verify it's actually their turn to approve.
        // Exception: if the required stage admin is unassigned, any canManageLoans() admin may substitute.
        $stageToOrder = [
            Loan::STAGE_MANAGER_REVIEW   => 4,
            Loan::STAGE_CHAIRMAN_REVIEW  => 1,
            Loan::STAGE_FINANCE_REVIEW   => 2,
            Loan::STAGE_AUDITOR_REVIEW   => 3,
            Loan::STAGE_CHAIRMAN_FINAL   => 1,
            Loan::STAGE_TREASURER_DISBURSE => 5,
        ];
        $requiredOrder = $stageToOrder[$currentStage] ?? null;
        $stageAdminExists = $requiredOrder
            ? \App\Models\User::where('role', '=', 'admin')->where('approval_order', '=', $requiredOrder)->exists()
            : false;

        $isMyTurn = (
            ($myOrder == 4 && $currentStage == Loan::STAGE_MANAGER_REVIEW) ||
            ($myOrder == 1 && in_array($currentStage, [Loan::STAGE_CHAIRMAN_REVIEW, Loan::STAGE_CHAIRMAN_FINAL])) ||
            ($myOrder == 2 && $currentStage == Loan::STAGE_FINANCE_REVIEW) ||
            ($myOrder == 3 && $currentStage == Loan::STAGE_AUDITOR_REVIEW) ||
            ($myOrder == 5 && $currentStage == Loan::STAGE_TREASURER_DISBURSE)
        );

        // Block only when the right admin exists but this isn't them
        if (!$isMyTurn && $stageAdminExists) {
            return back()->with('error', 'It is not your turn to approve this loan.');
        }

        // If stage admin doesn't exist, allow any canManageLoans() admin as substitute
        if (!$isMyTurn && !$stageAdminExists && !$user->canManageLoans()) {
            return back()->with('error', 'You do not have permission to approve this loan.');
        }

        $signaturePath = null;
        if ($request->hasFile('signature_image')) {
            $signaturePath = $request->file('signature_image')->store('signatures', 'public');
        }

        // Record Approval
        LoanCommitteeApproval::create([
            'loan_id' => $loan->id,
            'user_id' => $user->id,
            'status' => 'approved',
            'comment' => $request->comment,
            'signature_path' => $signaturePath,
            'reviewed_at' => now(),
            'stage' => $currentStage
        ]);

        // Advance Stage
        $nextStage = $currentStage;
        $message = 'Loan approved successfully.';

        switch ($currentStage) {
            case Loan::STAGE_MANAGER_REVIEW:
                $nextStage = Loan::STAGE_CHAIRMAN_REVIEW;
                $message = 'Loan forwarded to Chairman.';
                break;
            case Loan::STAGE_CHAIRMAN_REVIEW:
                $nextStage = Loan::STAGE_FINANCE_REVIEW;
                $message = 'Loan forwarded to Financial Secretary.';
                break;
            case Loan::STAGE_FINANCE_REVIEW:
                $nextStage = Loan::STAGE_AUDITOR_REVIEW;
                $message = 'Loan approved and forwarded to Auditor.';
                break;
            case Loan::STAGE_AUDITOR_REVIEW:
                $nextStage = Loan::STAGE_CHAIRMAN_FINAL;
                $message = 'Loan approved and forwarded to Chairman for final approval.';
                break;
            case Loan::STAGE_CHAIRMAN_FINAL:
                $nextStage = Loan::STAGE_TREASURER_DISBURSE;
                // Mark status as approved (ready for disbursement)
                $loan->update([
                    'status' => 'approved',
                    'approved_at' => now(),
                    'approved_by' => $user->id,
                ]);
                $message = 'Loan finally approved. Forwarded to Treasurer for disbursement.';
                break;
        }

        $loan->update(['stage' => $nextStage]);

        if ($loan->member && $loan->member->user) {
            $loan->member->user->notify(new \App\Notifications\LoanStatusUpdated(
                'Loan Application Update',
                "Your loan application ({$loan->application_number}) has been updated: {$message}"
            ));
        }

        return redirect()->route('admin.loans.index')->with('success', $message);
    }

    public function reject(Request $request, Loan $loan)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        LoanCommitteeApproval::create([
            'loan_id' => $loan->id,
            'user_id' => Auth::id(),
            'status' => 'rejected',
            'comment' => $request->comment,
            'reviewed_at' => now(),
            'stage' => $loan->stage
        ]);

        $loan->update([
            'status' => 'rejected',
            // We don't advance stage, it stops here.
            // Note: We might want to store who rejected it, but history tracks that.
        ]);
        
        // Also update member rejection reason for dashboard visibility
        $loan->member->update([
            'rejection_reason' => $request->comment
        ]);

        if ($loan->member && $loan->member->user) {
            $loan->member->user->notify(new \App\Notifications\LoanStatusUpdated(
                'Loan Application Rejected',
                "Your loan application ({$loan->application_number}) has been rejected. Reason: {$request->comment}"
            ));
        }

        return redirect()->route('admin.loans.index')->with('success', 'Loan rejected successfully.');
    }

    public function disburse(Loan $loan)
    {
        if ($loan->status !== 'approved' || $loan->stage !== Loan::STAGE_TREASURER_DISBURSE) {
            return back()->with('error', 'Loan is not ready for disbursement.');
        }

        // 1. Update Loan Status
        $loan->update([
            'status' => 'disbursed',
            'disbursed_at' => now(),
        ]);
        
        // 2. Create Cashbook Transaction (Outflow)
        \App\Models\CashbookTransaction::create([
            'transaction_date' => now(),
            'type' => 'expense',
            'category' => 'Loan Disbursement',
            'amount' => $loan->amount,
            'payment_method' => 'Bank Transfer', // Default for loans
            'description' => "Disbursement of Loan #{$loan->application_number} to {$loan->member->full_name} ({$loan->member->bank_name} - {$loan->member->account_number})",
            'reference_number' => $loan->application_number,
        ]);

        if ($loan->member && $loan->member->user) {
            $loan->member->user->notify(new \App\Notifications\LoanStatusUpdated(
                'Loan Disbursed',
                "Your loan ({$loan->application_number}) has been fully disbursed. The funds should reach your account shortly."
            ));
        }

        return back()->with('success', 'Loan disbursed successfully. Transaction recorded in Cashbook.');
    }
    
    public function updateItems(Request $request, Loan $loan)
    {
        // Only allow editing if pending
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Cannot edit items for a non-pending loan.');
        }
        
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $newItems = [];
        $newAmount = 0;

        foreach ($validated['items'] as $item) {
            $lineTotal = $item['quantity'] * $item['price'];
            $newAmount += $lineTotal;
            
            $newItems[] = [
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'], // Storing price now explicitly
                'total' => $lineTotal
            ];
        }

        // Update Metadata
        $metadata = $loan->metadata ?? [];
        $metadata['items'] = $newItems;
        
        // Recalculate Repayment
        $rate = $loan->interest_rate ?? 0;
        $newTotalRepayment = $newAmount * (1 + ($rate / 100));

        $loan->update([
            'amount' => $newAmount,
            'total_repayment' => $newTotalRepayment,
            'metadata' => $metadata
        ]);

        return back()->with('success', 'Loan items and amount updated successfully.');
    }
    public function uploadAssetImages(Request $request, Loan $loan)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate a cleaner filename or use storage's default
                $path = $image->store('loans/assets', 'public');
                
                LoanDocument::create([
                    'loan_id' => $loan->id,
                    'document_type' => 'Asset Image',
                    'file_path' => $path,
                    'original_name' => $image->getClientOriginalName(),
                ]);
            }
        }

        return back()->with('success', 'Asset images uploaded successfully.');
    }

    public function deleteAssetImage(LoanDocument $document)
    {
        // Security check: ensure the document is an asset image
        if ($document->document_type !== 'Asset Image') {
            return back()->with('error', 'Cannot delete this document type.');
        }

        // Delete from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Delete from DB
        $document->delete();

        return back()->with('success', 'Asset image deleted.');
    }
}

