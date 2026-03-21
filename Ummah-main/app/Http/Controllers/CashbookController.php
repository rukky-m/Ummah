<?php

namespace App\Http\Controllers;

use App\Models\CashbookTransaction;
use App\Models\BankReconciliation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CashbookController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Calculate Opening Balance (All transactions before this month)
        $previousIncome = CashbookTransaction::where('type', 'income')
            ->where('transaction_date', '<', $startOfMonth)
            ->sum('amount');
        $previousExpense = CashbookTransaction::where('type', 'expense')
            ->where('transaction_date', '<', $startOfMonth)
            ->sum('amount');
            
        $openingBalance = $previousIncome - $previousExpense;

        // Current Month Transactions
        $transactions = CashbookTransaction::whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->orderBy('transaction_date')
            ->get();

        $monthlyIncome = $transactions->where('type', 'income')->sum('amount');
        $monthlyExpense = $transactions->where('type', 'expense')->sum('amount');
        
        $closingBalance = $openingBalance + $monthlyIncome - $monthlyExpense;

        return view('cashbook.index', compact(
            'transactions',
            'openingBalance',
            'monthlyIncome',
            'monthlyExpense',
            'closingBalance',
            'year',
            'month'
        ));
    }

    public function create()
    {
        return view('cashbook.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reference_number' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('cashbook_attachments', 'public');
        }

        CashbookTransaction::create([
            'transaction_date' => $validated['transaction_date'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'description' => $validated['description'],
            'reference_number' => $validated['reference_number'],
            'attachment_path' => $path,
        ]);

        return redirect()->route('cashbook.index', [
            'month' => Carbon::parse($validated['transaction_date'])->month,
            'year' => Carbon::parse($validated['transaction_date'])->year,
        ])->with('success', 'Transaction added successfully.');
    }

    public function edit(CashbookTransaction $cashbook)
    {
        return view('cashbook.create', [
            'transaction' => $cashbook,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, CashbookTransaction $cashbook)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reference_number' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($cashbook->attachment_path) {
                Storage::disk('public')->delete($cashbook->attachment_path);
            }
            $validated['attachment_path'] = $request->file('attachment')->store('cashbook_attachments', 'public');
        }

        $cashbook->update($validated);

        return redirect()->route('cashbook.index', [
            'month' => Carbon::parse($validated['transaction_date'])->month,
            'year' => Carbon::parse($validated['transaction_date'])->year,
        ])->with('success', 'Transaction updated successfully.');
    }

    public function destroy(CashbookTransaction $cashbook)
    {
        if ($cashbook->attachment_path) {
            Storage::disk('public')->delete($cashbook->attachment_path);
        }
        $cashbook->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully.');
    }

    public function export(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $transactions = CashbookTransaction::whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->orderBy('transaction_date')
            ->get();

        $fileName = "Cashbook_Report_{$year}_{$month}.csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Type', 'Category', 'Description', 'Amount (NGN)', 'Payment Method', 'Reference']);

            foreach ($transactions as $tx) {
                fputcsv($file, [
                    $tx->transaction_date->format('Y-m-d'),
                    ucfirst($tx->type),
                    $tx->category,
                    $tx->description,
                    $tx->amount,
                    $tx->payment_method,
                    $tx->reference_number
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function monthlyReport(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Calculate Opening Balance
        $previousIncome = CashbookTransaction::where('type', 'income')
            ->where('transaction_date', '<', $startOfMonth)
            ->sum('amount');
        $previousExpense = CashbookTransaction::where('type', 'expense')
            ->where('transaction_date', '<', $startOfMonth)
            ->sum('amount');
            
        $openingBalance = $previousIncome - $previousExpense;

        // Current Month Transactions
        $transactions = CashbookTransaction::whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->orderBy('transaction_date')
            ->get();

        $monthlyIncome = $transactions->where('type', 'income')->sum('amount');
        $monthlyExpense = $transactions->where('type', 'expense')->sum('amount');
        $closingBalance = $openingBalance + $monthlyIncome - $monthlyExpense;

        // Category breakdown
        $incomeByCategory = $transactions->where('type', 'income')->groupBy('category')->map(fn($items) => $items->sum('amount'));
        $expenseByCategory = $transactions->where('type', 'expense')->groupBy('category')->map(fn($items) => $items->sum('amount'));

        // Payment method breakdown
        $paymentMethodBreakdown = $transactions->groupBy('payment_method')->map(fn($items) => $items->sum('amount'));

        return view('cashbook.monthly-report', compact(
            'transactions',
            'openingBalance',
            'monthlyIncome',
            'monthlyExpense',
            'closingBalance',
            'incomeByCategory',
            'expenseByCategory',
            'paymentMethodBreakdown',
            'year',
            'month'
        ));
    }

    public function reconciliationIndex()
    {
        $reconciliations = BankReconciliation::with('reconciledBy')
            ->orderBy('reconciliation_date', 'desc')
            ->paginate(10);

        return view('cashbook.reconciliation.index', compact('reconciliations'));
    }

    public function reconciliationCreate()
    {
        // Get current cashbook balance
        $totalIncome = CashbookTransaction::where('type', 'income')->sum('amount');
        $totalExpense = CashbookTransaction::where('type', 'expense')->sum('amount');
        $cashbookBalance = $totalIncome - $totalExpense;

        // Get recent unreconciled transactions
        $recentTransactions = CashbookTransaction::orderBy('transaction_date', 'desc')
            ->limit(50)
            ->get();

        return view('cashbook.reconciliation.create', compact('cashbookBalance', 'recentTransactions'));
    }

    public function reconciliationStore(Request $request)
    {
        $validated = $request->validate([
            'reconciliation_date' => 'required|date',
            'bank_statement_balance' => 'required|numeric',
            'notes' => 'nullable|string',
            'reconciliation_items' => 'nullable|array',
        ]);

        // Calculate cashbook balance
        $totalIncome = CashbookTransaction::where('type', 'income')
            ->where('transaction_date', '<=', $validated['reconciliation_date'])
            ->sum('amount');
        $totalExpense = CashbookTransaction::where('type', 'expense')
            ->where('transaction_date', '<=', $validated['reconciliation_date'])
            ->sum('amount');
        $cashbookBalance = $totalIncome - $totalExpense;

        $difference = $validated['bank_statement_balance'] - $cashbookBalance;

        BankReconciliation::create([
            'reconciliation_date' => $validated['reconciliation_date'],
            'bank_statement_balance' => $validated['bank_statement_balance'],
            'cashbook_balance' => $cashbookBalance,
            'difference' => $difference,
            'reconciled_by' => Auth::id(),
            'notes' => $validated['notes'],
            'status' => abs($difference) < 0.01 ? 'completed' : 'pending',
            'reconciliation_items' => $validated['reconciliation_items'] ?? [],
        ]);

        return redirect()->route('cashbook.reconciliation.index')
            ->with('success', 'Bank reconciliation completed successfully.');
    }

    public function reconciliationShow($id)
    {
        $reconciliation = BankReconciliation::with('reconciledBy')->findOrFail($id);
        
        return view('cashbook.reconciliation.show', compact('reconciliation'));
    }

    public function importForm()
    {
        return view('cashbook.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        
        $imported = 0;
        $errors = [];
        $skipped = 0;

        if (($handle = fopen($path, 'r')) !== false) {
            // Skip header row
            $header = fgetcsv($handle);
            
            // Validate header
            $expectedHeaders = ['Date', 'Type', 'Category', 'Amount', 'Payment Method', 'Description', 'Reference'];
            if (!$header || count(array_intersect($expectedHeaders, $header)) < 5) {
                return redirect()->back()->withErrors(['file' => 'Invalid file format. Please use the provided template.']);
            }

            $row = 1;
            while (($data = fgetcsv($handle)) !== false) {
                $row++;
                
                // Skip empty rows
                if (empty(array_filter($data))) {
                    $skipped++;
                    continue;
                }

                try {
                    // Map CSV columns
                    $transaction = [
                        'transaction_date' => $data[0] ?? null,
                        'type' => strtolower($data[1] ?? ''),
                        'category' => $data[2] ?? null,
                        'amount' => $data[3] ?? null,
                        'payment_method' => $data[4] ?? null,
                        'description' => $data[5] ?? null,
                        'reference_number' => $data[6] ?? null,
                    ];

                    // Validate required fields
                    if (empty($transaction['transaction_date']) || 
                        empty($transaction['type']) || 
                        empty($transaction['category']) || 
                        empty($transaction['amount']) || 
                        empty($transaction['payment_method'])) {
                        $errors[] = "Row $row: Missing required fields";
                        continue;
                    }

                    // Validate type
                    if (!in_array($transaction['type'], ['income', 'expense'])) {
                        $errors[] = "Row $row: Type must be 'income' or 'expense'";
                        continue;
                    }

                    // Validate amount
                    if (!is_numeric($transaction['amount']) || $transaction['amount'] < 0) {
                        $errors[] = "Row $row: Amount must be a positive number";
                        continue;
                    }

                    // Validate date
                    try {
                        $date = Carbon::parse($transaction['transaction_date']);
                        $transaction['transaction_date'] = $date->format('Y-m-d');
                    } catch (\Exception $e) {
                        $errors[] = "Row $row: Invalid date format";
                        continue;
                    }

                    // Create transaction
                    CashbookTransaction::create($transaction);
                    $imported++;

                } catch (\Exception $e) {
                    $errors[] = "Row $row: " . $e->getMessage();
                }
            }

            fclose($handle);
        }

        $message = "Import completed! $imported transactions imported successfully.";
        if ($skipped > 0) {
            $message .= " $skipped empty rows skipped.";
        }
        if (count($errors) > 0) {
            $message .= " " . count($errors) . " errors occurred.";
        }

        return redirect()->route('cashbook.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    public function downloadTemplate()
    {
        $filename = 'cashbook_import_template.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, ['Date', 'Type', 'Category', 'Amount', 'Payment Method', 'Description', 'Reference']);
            
            // Sample data rows
            fputcsv($file, ['2023-01-15', 'income', 'Membership Due', '5000', 'Bank Transfer', 'January membership dues', 'REF001']);
            fputcsv($file, ['2023-01-20', 'expense', 'Utility Bill', '1500', 'Cash', 'Electricity bill payment', 'BILL-001']);
            fputcsv($file, ['2023-02-01', 'income', 'Donation', '10000', 'POS', 'Donation from member', '']);
            fputcsv($file, ['2023-02-10', 'expense', 'Office Supplies', '2500', 'Bank Transfer', 'Stationery purchase', 'INV-123']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

