<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }

        $query = Member::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('file_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('account_number', 'like', "%{$search}%")
                  ->orWhere('id_number', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $members = $query->paginate(10);

        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }

        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'nullable|string',
            'full_name' => 'required|string',
            'phone' => 'required|string|unique:members',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'gender' => 'required|string',
            'occupation' => 'nullable|string',
            'next_of_kin_name' => 'nullable|string',
            'next_of_kin_phone' => 'nullable|string',
            'account_number' => 'nullable|string|unique:members',
            'file_number' => 'nullable|string|unique:members',
            'id_type' => 'nullable|string',
            'id_number' => 'nullable|string',
            'create_user_account' => 'nullable|boolean',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|string|min:8|required_if:create_user_account,1',
        ]);

        $names = explode(' ', $validated['full_name'], 2);
        $firstName = $names[0];
        $lastName = isset($names[1]) ? $names[1] : '';

        $memberData = array_merge($request->except(['create_user_account', 'email', 'password', 'password_confirmation', 'full_name']), [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'status' => 'active', // Default to active for admin creation
        ]);

        $member = Member::create($memberData);

        if ($request->has('create_user_account') && $request->create_user_account) {
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'member',
            ]);
            $member->update(['user_id' => $user->id]);
        }

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        if (!Auth::user()->isStaff() && $member->user_id !== Auth::id()) {
            abort(403);
        }
        $member->load(['savings', 'loans']);

        // Calculate monthly contributions
        $monthlyContributions = $member->savings
            ->where('type', 'deposit')
            ->where('status', 'approved')
            ->groupBy(function ($date) {
                return \Carbon\Carbon::parse($date->transaction_date)->format('F Y'); // Group by Month Year
            })
            ->map(function ($row) {
                return $row->sum('amount');
            });

        return view('members.show', compact('member', 'monthlyContributions'));
    }

    public function statement(Member $member)
    {
        if (!Auth::user()->isStaff() && $member->user_id !== Auth::id()) {
            abort(403);
        }

        $member->load(['savings', 'loans.repayments']);

        $allTransactions = collect();

        // 1. Contributions & Savings
        foreach ($member->savings as $s) {
            if ($s->status === 'approved') {
                $allTransactions->push([
                    'date' => $s->transaction_date,
                    'type' => $s->type == 'deposit' ? 'Contribution/Saving' : 'Withdrawal',
                    'amount' => $s->amount,
                    'direction' => $s->type == 'deposit' ? 'in' : 'out',
                    'category' => 'savings',
                ]);
            }
        }

        // 2. Loans Disbursed
        foreach ($member->loans as $l) {
            if ($l->status === 'approved' || $l->status === 'active' || $l->status === 'disbursed' || $l->status === 'completed') {
                $allTransactions->push([
                    'date' => $l->approved_at ?: $l->created_at,
                    'type' => 'Loan Disbursement',
                    'amount' => $l->amount,
                    'direction' => 'in', // Money received by member
                    'category' => 'loans',
                ]);

                // 3. Repayments
                foreach ($l->repayments as $r) {
                    $allTransactions->push([
                        'date' => $r->paid_at,
                        'type' => 'Loan Repayment',
                        'amount' => $r->amount,
                        'direction' => 'out', // Money paid back by member
                        'category' => 'repayments',
                    ]);
                }
            }
        }

        // Group by Month
        $monthlyReport = $allTransactions->sortBy('date')->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item['date'])->format('F Y');
        })->map(function ($month) {
            return [
                'contributions' => $month->where('category', 'savings')->where('direction', 'in')->sum('amount'),
                'withdrawals' => $month->where('category', 'savings')->where('direction', 'out')->sum('amount'),
                'loan_disbursed' => $month->where('category', 'loans')->sum('amount'),
                'loan_repaid' => $month->where('category', 'repayments')->sum('amount'),
                'net_flow' => $month->where('direction', 'in')->sum('amount') - $month->where('direction', 'out')->sum('amount'),
                'total_in' => $month->where('direction', 'in')->sum('amount'),
                'total_out' => $month->where('direction', 'out')->sum('amount'),
            ];
        });

        return view('members.statement', compact('member', 'monthlyReport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'nullable|string',
            'full_name' => 'required|string',
            'phone' => ['required', 'string', Rule::unique('members')->ignore($member->id)],
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'gender' => 'required|string',
            'occupation' => 'nullable|string',
            'next_of_kin_name' => 'nullable|string',
            'next_of_kin_phone' => 'nullable|string',
            'account_number' => ['nullable', 'string', Rule::unique('members')->ignore($member->id)],
            'file_number' => ['nullable', 'string', Rule::unique('members')->ignore($member->id)],
            'id_type' => 'nullable|string',
            'id_number' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $names = explode(' ', $validated['full_name'], 2);
        $firstName = $names[0];
        $lastName = isset($names[1]) ? $names[1] : '';

        $memberData = array_merge($request->except(['full_name']), [
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);

        $member->update($memberData);

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function approve(Request $request, Member $member)
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }

        $member->update([
            'status' => 'active',
            'account_number' => $member->account_number ?: 'UMH-' . strtoupper(Str::random(6)),
        ]);

        if ($member->user) {
            $member->user->notify(new \App\Notifications\MemberStatusUpdated(
                'Membership Approved',
                "Congratulations! Your membership has been approved. Your account number is {$member->account_number}."
            ));
        }

        return redirect()->back()->with('success', 'Member approved successfully. They can now log in.');
    }

    public function reject(Request $request, Member $member)
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $member->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        if ($member->user) {
            $member->user->notify(new \App\Notifications\MemberStatusUpdated(
                'Membership Application Rejected',
                "Unfortunately, your membership application was rejected. Reason: {$request->reason}"
            ));
        }

        return redirect()->back()->with('success', 'Member application rejected.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        if (!Auth::user()->isStaff()) {
            abort(403);
        }
        // Check for active loans or savings before deleting?
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}
