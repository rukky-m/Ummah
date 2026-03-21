<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanDocument;
use App\Models\LoanGuarantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Services\FinanceService;

class LoanApplicationController extends Controller
{
    protected FinanceService $financeService;

    public function __construct(FinanceService $financeService)
    {
        $this->financeService = $financeService;
    }

    public function index()
    {
        return view('loans.apply.index');
    }

    // Step 1: Loan Details
    public function createStep1()
    {
        $loanData = Session::get('loan_application.step1', []);
        return view('loans.apply.step1', compact('loanData'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:20000|max:3000000',
            'purpose' => 'required|string',
            'other_purpose' => 'nullable|string|required_if:purpose,Other',
            'duration_months' => 'required|integer|in:3,6,12,18',
            'repayment_frequency' => 'required|in:monthly,quarterly',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'account_name' => 'required|string|max:255',
        ]);

        if ($validated['purpose'] === 'Other') {
            $validated['purpose'] = $validated['other_purpose'];
        }
        unset($validated['other_purpose']);

        // Use FinanceService for interest calculations
        $interestRate = $this->financeService->calculateInterestRate($validated['purpose']);
        $totalRepayment = $this->financeService->calculateTotalRepayment($validated['amount'], $interestRate);
        
        $validated['interest_rate'] = $interestRate;
        $validated['total_repayment'] = $totalRepayment;

        Session::put('loan_application.step1', $validated);

        return redirect()->route('loans.apply.step2');
    }

    // Step 2: Guarantors
    public function createStep2()
    {
        if (!Session::has('loan_application.step1')) {
            return redirect()->route('loans.apply.step1');
        }

        $guarantorsData = Session::get('loan_application.step2', []);
        return view('loans.apply.step2', compact('guarantorsData'));
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'guarantor_1_name' => 'required|string|max:255',
            'guarantor_1_relationship' => 'required|string|max:255',
            'guarantor_1_phone' => 'required|string|max:20',
            'guarantor_1_member_id' => 'nullable|string|max:50',
            'guarantor_1_passport' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            
            'guarantor_2_name' => 'required|string|max:255',
            'guarantor_2_relationship' => 'required|string|max:255',
            'guarantor_2_phone' => 'required|string|max:20',
            'guarantor_2_member_id' => 'nullable|string|max:50',
            'guarantor_2_passport' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('guarantor_1_passport')) {
            $validated['guarantor_1_passport_path'] = $request->file('guarantor_1_passport')->store('guarantor_passports', 'public');
        }
        if ($request->hasFile('guarantor_2_passport')) {
            $validated['guarantor_2_passport_path'] = $request->file('guarantor_2_passport')->store('guarantor_passports', 'public');
        }
        
        // Remove the actual file objects from the session array, only store paths
        unset($validated['guarantor_1_passport']);
        unset($validated['guarantor_2_passport']);

        Session::put('loan_application.step2', $validated);

        return redirect()->route('loans.apply.step3');
    }

    // Step 3: Documents and Narration
    public function createStep3()
    {
        if (!Session::has('loan_application.step2')) {
            return redirect()->route('loans.apply.step2');
        }
        return view('loans.apply.step3');
    }

    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            'narration' => 'required|string|min:20',
            'business_plan' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'bank_statement' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'proof_of_income' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'collateral_docs' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $step1 = Session::get('loan_application.step1');
        $step2 = Session::get('loan_application.step2');

        if (!$step1 || !$step2) {
             return redirect()->route('loans.apply.step1');
        }

        $user = Auth::user();
        if (!$user->member) {
            return redirect()->route('dashboard')->with('error', 'You must have a valid Member profile to apply for a loan. Please contact support.');
        }

        // Create Loan
        $loan = Loan::create([
            'member_id' => $user->member->id,
            'amount' => $step1['amount'],
            'purpose' => $step1['purpose'],
            'duration_months' => $step1['duration_months'],
            'repayment_frequency' => $step1['repayment_frequency'],
            'interest_rate' => $step1['interest_rate'],
            'total_repayment' => $step1['total_repayment'],
            'narration' => $validated['narration'],
            'status' => 'pending',
            'application_number' => 'L-' . date('Y') . '-' . rand(1000, 9999),
            'metadata' => [
                'disbursement_account' => [
                    'bank_name' => $step1['bank_name'],
                    'account_number' => $step1['account_number'],
                    'account_name' => $step1['account_name']
                ]
            ],
        ]);

        // Create Guarantors
        LoanGuarantor::create([
            'loan_id' => $loan->id,
            'name' => $step2['guarantor_1_name'],
            'relationship' => $step2['guarantor_1_relationship'],
            'phone' => $step2['guarantor_1_phone'],
            'member_id' => $step2['guarantor_1_member_id'] ?? null,
            'passport_path' => $step2['guarantor_1_passport_path'] ?? null,
        ]);

        LoanGuarantor::create([
            'loan_id' => $loan->id,
            'name' => $step2['guarantor_2_name'],
            'relationship' => $step2['guarantor_2_relationship'],
            'phone' => $step2['guarantor_2_phone'],
            'member_id' => $step2['guarantor_2_member_id'] ?? null,
            'passport_path' => $step2['guarantor_2_passport_path'] ?? null,
        ]);

        // Handle File Uploads
        $documentTypes = ['business_plan', 'bank_statement', 'proof_of_income', 'collateral_docs'];
        foreach ($documentTypes as $type) {
            if ($request->hasFile($type)) {
                $file = $request->file($type);
                $path = $file->store('loan_documents/' . $loan->id, 'public');
                
                LoanDocument::create([
                    'loan_id' => $loan->id,
                    'document_type' => ucwords(str_replace('_', ' ', $type)),
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Clear Session
        Session::forget('loan_application');

        return redirect()->route('loans.apply.success', ['loan' => $loan]);
    }

    public function showSuccess(Loan $loan)
    {
        $user = Auth::user();
        if (!$user->member || $loan->member_id !== $user->member->id) {
            abort(403);
        }
        return view('loans.apply.success', compact('loan'));
    }

    // --- Special Loan Types ---

    public function createMotorcycle()
    {
        $brands = \App\Models\LoanProduct::where('category', 'motorcycle')->active()->get();
        return view('loans.apply.motorcycle', compact('brands'));
    }

    public function storeMotorcycle(Request $request)
    {
        $user = Auth::user();
        if (!$user->member) {
             return redirect()->route('dashboard')->with('error', 'Member profile required.');
        }

        $validated = $request->validate([
            'brand' => 'required|string',
            'quantity' => 'required|integer|min:1',
            // Guarantors (simplified reuse or specific lookup)
            'guarantor_1_name' => 'required|string',
            'guarantor_1_phone' => 'required|string',
            'guarantor_2_name' => 'required|string',
            'guarantor_2_phone' => 'required|string',
        ]);

        // Determine price logic or store as request for valuation
        // We can fetch the price from DB if available, but for now we follow the existing logic of 0/TBD or update it if we want to use the product price.
        // Let's look up the product price if it exists.
        $product = \App\Models\LoanProduct::where('category', 'motorcycle')
                    ->where('name', $validated['brand'])
                    ->first();
        
        $estimatedAmount = $product ? ($product->price * $validated['quantity']) : 0;

        $loan = Loan::create([
            'member_id' => $user->member->id,
            'amount' => $estimatedAmount, 
            'purpose' => 'Motorcycle Purchase: ' . $validated['brand'],
            'duration_months' => 12, // Fixed 12 months as per request
            'repayment_frequency' => 'monthly',
            'interest_rate' => 0, // TBD or fetch from product metadata? Sticking to 0 as TBD.
            'total_repayment' => $estimatedAmount, // TBD
            'narration' => 'Request for ' . $validated['brand'] . ' Motorcycle. Qty: ' . $validated['quantity'],
            'status' => 'pending',
            'type' => 'motorcycle',
            'application_number' => 'M-' . date('Y') . '-' . rand(1000, 9999),
            'metadata' => [
                'brand' => $validated['brand'],
                'quantity' => $validated['quantity'],
                'guarantors' => [
                    ['name' => $validated['guarantor_1_name'], 'phone' => $validated['guarantor_1_phone']],
                    ['name' => $validated['guarantor_2_name'], 'phone' => $validated['guarantor_2_phone']],
                ]
            ]
        ]);

        return redirect()->route('loans.apply.success', ['loan' => $loan]);
    }

    public function createRamadanSallah()
    {
        $commodities = \App\Models\LoanProduct::whereIn('category', ['ramadan', 'sallah'])->active()->get();
        $vendors = \App\Models\Vendor::active()->get();
        return view('loans.apply.ramadan_sallah', compact('commodities', 'vendors'));
    }

    public function storeRamadanSallah(Request $request)
    {
        $user = Auth::user();
        if (!$user->member) {
             return redirect()->route('dashboard')->with('error', 'Member profile required.');
        }

        $validated = $request->validate([
            'package_type' => 'required|in:Ramadan,Sallah',
            'staff_category' => 'required|in:Junior Staff,Senior Staff',
            'amount' => 'required|numeric|min:1000',
            'vendor' => 'required|string',
            'items' => 'nullable|array',
            'items.*' => 'string',
            'quantities' => 'nullable|array',
            'quantities.*' => 'numeric|min:1'
        ]);

        // Process items
        $selectedItems = [];
        if (!empty($validated['items'])) {
            foreach ($validated['items'] as $item) {
                $qty = $validated['quantities'][$item] ?? 1;
                $selectedItems[] = [
                    'name' => $item,
                    'quantity' => $qty
                ];
            }
        }

        $interestRate = 6.0; 
        
        $loan = Loan::create([
            'member_id' => $user->member->id,
            'amount' => $validated['amount'], 
            'purpose' => $validated['package_type'] . ' Package',
            'duration_months' => 4, 
            'repayment_frequency' => 'monthly',
            'interest_rate' => 6, 
            'total_repayment' => $this->financeService->calculateRamadanSallahRepayment($validated['amount']), 
            'narration' => $validated['package_type'] . ' Request. Vendor: ' . $validated['vendor'] . (count($selectedItems) > 0 ? '. Items: ' . count($selectedItems) : ''),
            'status' => 'pending',
            'type' => 'ramadan_sallah',
            'application_number' => 'RS-' . date('Y') . '-' . rand(1000, 9999),
            'metadata' => [
                'package_type' => $validated['package_type'],
                'staff_category' => $validated['staff_category'],
                'vendor' => $validated['vendor'],
                'items' => $selectedItems
            ]
        ]);

        return redirect()->route('loans.apply.success', ['loan' => $loan]);
    }
    public function createAsset()
    {
        $assets = \App\Models\LoanProduct::where('category', 'asset')->active()->with('vendor')->get();
        return view('loans.apply.asset', compact('assets'));
    }

    public function storeAsset(Request $request)
    {
        $user = Auth::user();
        if (!$user->member) {
             return redirect()->route('dashboard')->with('error', 'Member profile required.');
        }

        $validated = $request->validate([
            'asset_id' => 'required|exists:loan_products,id',
            'quantity' => 'required|integer|min:1',
            // Vendor Details (optional overrides if needed, but we prefer linked)
            'vendor_name' => 'nullable|string',
            'vendor_account_number' => 'nullable|string',
            'vendor_bank' => 'nullable|string',
            'vendor_phone' => 'nullable|string',
            // Guarantor
            'guarantor_name' => 'required|string',
            'guarantor_dept' => 'required|string',
            'guarantor_phone' => 'required|string',
        ]);

        $product = \App\Models\LoanProduct::with('vendor')->findOrFail($validated['asset_id']);
        $totalCost = $product->price * $validated['quantity'];
        
        // Use linked vendor info if available
        $vendorName = ($product->vendor instanceof \App\Models\Vendor) ? $product->vendor->name : ($validated['vendor_name'] ?? (is_string($product->vendor) ? $product->vendor : 'Unknown Vendor'));
        $vendorPhone = ($product->vendor instanceof \App\Models\Vendor) ? $product->vendor->phone : ($validated['vendor_phone'] ?? '');
        
        $loan = Loan::create([
            'member_id' => $user->member->id,
            'amount' => $totalCost, 
            'purpose' => 'Asset Purchase: ' . $product->name,
            'duration_months' => 12, // Fixed 12 months as per request
            'repayment_frequency' => 'monthly',
            'interest_rate' => 10, // Assuming standard 10%
            'total_repayment' => $this->financeService->calculateAssetRepayment($totalCost), 
            'narration' => 'Asset Request: ' . $product->name . '. Qty: ' . $validated['quantity'] . '. Vendor: ' . $vendorName,
            'status' => 'pending',
            'type' => 'asset',
            'application_number' => 'A-' . date('Y') . '-' . rand(1000, 9999),
            'metadata' => [
                'item_description' => $product->name,
                'quantity' => $validated['quantity'],
                'asset_id' => $product->id,
                'vendor' => [
                    'name' => $vendorName,
                    'account_number' => $validated['vendor_account_number'] ?? '',
                    'bank' => $validated['vendor_bank'] ?? '',
                    'phone' => $vendorPhone,
                ],
                'guarantor' => [
                    'name' => $validated['guarantor_name'],
                    'dept' => $validated['guarantor_dept'],
                    'phone' => $validated['guarantor_phone'],
                ]
            ]
        ]);

        return redirect()->route('loans.apply.success', ['loan' => $loan]);
    }
}
