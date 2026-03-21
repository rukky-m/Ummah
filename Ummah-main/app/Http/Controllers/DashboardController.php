<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Saving;
use App\Models\CashbookTransaction;
use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\FinanceService;

class DashboardController extends Controller
{
    protected FinanceService $financeService;

    public function __construct(FinanceService $financeService)
    {
        $this->financeService = $financeService;
    }

    public function index()
    {
        $user = Auth::user();
        $announcements = Announcement::active()->latest()->get();

        if ($user->isStaff()) {
            // PRO (Admin 6) only manages announcements, skip heavy stats
            if ($user->canManageAnnouncements()) {
                return view('dashboard', [
                    'data' => [],
                    'globalMonthlySummary' => collect(),
                    'announcements' => $announcements
                ]);
            }

            $data = [
                'total_members' => Member::count(),
                'total_savings' => $this->financeService->getGlobalSavingsBalance(),
                'total_contributions' => $this->financeService->getGlobalTotalContributions(),
                'total_loans_balance' => $this->financeService->getGlobalActiveLoansBalance(),
                'pending_loans' => Loan::where('status', 'pending')->count(),
            ];

            // Cashbook Stats for Current Month
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();
            
            $transactions = CashbookTransaction::whereBetween('transaction_date', [$startOfMonth, $endOfMonth])->get();
            $data['monthly_income'] = $transactions->where('type', 'income')->sum('amount');
            $data['monthly_expense'] = $transactions->where('type', 'expense')->sum('amount');
            
            // Opening Balance (All before this month)
            $prevIncome = CashbookTransaction::where('type', 'income')->where('transaction_date', '<', $startOfMonth)->sum('amount');
            $prevExpense = CashbookTransaction::where('type', 'expense')->where('transaction_date', '<', $startOfMonth)->sum('amount');
            $data['opening_balance'] = $prevIncome - $prevExpense;
            $data['closing_balance'] = $data['opening_balance'] + $data['monthly_income'] - $data['monthly_expense'];
            $data['recent_transactions'] = CashbookTransaction::latest()->take(5)->get();

            // Global Monthly Activity Summary (Contributions)
            $globalMonthlySummary = Saving::where('category', 'Contribution')
                ->where('type', 'deposit')
                ->where('status', 'approved')
                ->get()
                ->groupBy(function($date) {
                    return Carbon::parse($date->transaction_date)->format('F Y');
                })
                ->map(function ($row) {
                    return $row->sum('amount');
                })->sortKeysDesc()->take(6);

            return view('dashboard', compact('data', 'globalMonthlySummary', 'announcements'));
        }

        // Member Dashboard
        $member = $user->member;
        
        if (!$member) {
             return view('dashboard-pending', ['status' => 'No Profile', 'message' => 'Please complete your profile to become a member.']);
        }

        if ($member->status === 'pending') {
            return view('dashboard-pending', [
                'status' => 'Application Pending',
                'message' => 'Your membership application was successfully submitted. We will notify you once the committee reviews it.',
                'application_ref' => $member->application_ref
            ]);
        }

        if ($member->status === 'rejected') {
            return view('dashboard-pending', [
                'status' => 'Application Rejected',
                'message' => 'Unfortunately, your membership application was rejected. Reason: ' . ($member->rejection_reason ?? 'No reason provided.'),
                'is_rejected' => true
            ]);
        }

        $activeLoans = $member->loans()->with('repayments')->whereIn('status', ['approved', 'disbursed'])->get();
        $nextPaymentAmount = 0;
        $totalRemainingBalance = 0;
        $overdueRepayments = [];

        $currentMonth = now()->format('F');
        $currentYear = now()->year;

        foreach ($activeLoans as $loan) {
            $monthlyPayment = $loan->monthlyRepaymentAmount();
            $nextPaymentAmount += $monthlyPayment;
            
            $totalPaid = $loan->repayments->where('status', 'approved')->sum('amount');
            $totalRemainingBalance += max(0, $loan->total_repayment - $totalPaid);

            if (!$loan->isRepaymentDoneForMonth($currentMonth, $currentYear)) {
                $pendingRepayment = $loan->repayments
                    ->where('month', $currentMonth)
                    ->where('year', $currentYear)
                    ->where('status', 'pending')
                    ->first();

                $overdueRepayments[] = [
                    'loan' => $loan,
                    'month' => $currentMonth,
                    'year' => $currentYear,
                    'amount' => $monthlyPayment,
                    'status' => $pendingRepayment ? 'pending' : 'not_submitted',
                ];
            }
        }

        // Recent Activity
        $recentSavings = $member->savings()->latest()->take(5)->get()->map(function($saving) {
            return [
                'type' => $saving->category == 'Contribution' ? 'contribution' : 'saving',
                'description' => ($saving->category == 'Contribution' ? 'Contribution' : ucfirst($saving->type)) . ' ₦' . number_format($saving->amount, 2),
                'date' => $saving->transaction_date,
                'amount' => $saving->amount
            ];
        });

        $recentLoans = $member->loans()->latest()->take(5)->get()->map(function($loan) {
             return [
                'type' => 'loan',
                'description' => "Loan ₦" . number_format($loan->amount, 2) . " (" . ucfirst($loan->status) . ")",
                'date' => $loan->updated_at,
                'amount' => $loan->amount
            ];
        });

        $recentActivity = $recentSavings->concat($recentLoans)->sortByDesc('date')->take(5);

        // Member Balances
        $startOfCurrentMonth = now()->startOfMonth();
        
        // Use FinanceService for balance calculations
        $openingBalance = $this->financeService->getMemberSavingsBalance($member, $startOfCurrentMonth);
        $closingBalance = $this->financeService->getMemberSavingsBalance($member);

        $monthlyContributions = $member->savings()
            ->where('category', 'Contribution')
            ->where('type', 'deposit')
            ->where('status', 'approved')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->transaction_date)->format('F Y');
            })
            ->map(function ($row) {
                return $row->sum('amount');
            })->sortKeysDesc()->take(6);

        $data = [
            'my_savings' => $this->financeService->getMemberSavingsBalance($member),
            'my_contributions' => $this->financeService->getMemberTotalContributions($member),
            'opening_balance' => $openingBalance,
            'closing_balance' => $closingBalance,
            'active_loans_count' => $activeLoans->count(),
            'active_loans_balance' => $this->financeService->getMemberActiveLoansBalance($member),
            'next_payment_amount' => $nextPaymentAmount,
            'next_payment_date' => now()->addMonth()->format('M d, Y'),
            'overdue_repayments' => $overdueRepayments,
            'loans' => $member->loans()->latest()->get(),
        ];

        return view('dashboard', compact('data', 'recentActivity', 'monthlyContributions', 'announcements'));
    }

    public function committeeDashboard()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $stageConfigs = [
            1 => ['title' => 'Manager Review', 'order' => 4, 'icon' => 'fa-user-edit'],
            2 => ['title' => 'Chairman Review', 'order' => 1, 'icon' => 'fa-user-tie'],
            3 => ['title' => 'Finance Secretary', 'order' => 2, 'icon' => 'fa-file-invoice-dollar'],
            4 => ['title' => 'Auditor Review', 'order' => 3, 'icon' => 'fa-search-dollar'],
            5 => ['title' => 'Chairman Final', 'order' => 1, 'icon' => 'fa-check-double'],
            6 => ['title' => 'Treasurer Action', 'order' => 5, 'icon' => 'fa-coins'],
        ];

        $stats = [];
        foreach ($stageConfigs as $stageNum => $config) {
            $admin = \App\Models\User::where('role', 'admin')
                ->where('approval_order', $config['order'])
                ->first();

            // Loans currently at this stage
            $waitingCount = Loan::where('stage', $stageNum)
                ->where(function($q) use ($stageNum) {
                    if ($stageNum == 6) {
                        $q->where('status', 'approved');
                    } else {
                        $q->where('status', 'pending');
                    }
                })
                ->count();

            // Historic approvals at this stage
            $approvedCount = \App\Models\LoanCommitteeApproval::where('stage', $stageNum)
                ->where('status', 'approved')
                ->count();

            // Historic rejections at this stage
            $rejectedCount = \App\Models\LoanCommitteeApproval::where('stage', $stageNum)
                ->where('status', 'rejected')
                ->count();

            $stats[] = [
                'stage' => $stageNum,
                'title' => $config['title'],
                'icon' => $config['icon'],
                'admin' => $admin,
                'waiting' => $waitingCount,
                'approved' => $approvedCount,
                'rejected' => $rejectedCount,
            ];
        }

        // Overall loan statistics
        $totalPending = Loan::where('status', 'pending')->count();
        $totalApproved = Loan::where('status', 'approved')->count();
        $totalRejected = Loan::where('status', 'rejected')->count();
        $totalDisbursed = Loan::where('status', 'disbursed')->count();

        return view('admin.committee_dashboard', compact('stats', 'totalPending', 'totalApproved', 'totalRejected', 'totalDisbursed'));
    }
}
