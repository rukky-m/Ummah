<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// 1. Public landing page - visible to everyone
Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/bye-laws', function () {
    return view('bye-laws');
})->name('bye-laws');

// 2. Dashboard route - shows stats and overview
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// 2b. Committee Dashboard (Admin only)
Route::get('/committee-dashboard', [DashboardController::class, 'committeeDashboard'])
    ->middleware(['auth', 'admin'])
    ->name('committee.dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/bank-details', [ProfileController::class, 'updateBankDetails'])->name('profile.bank.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Loan Application Wizard Routes
    Route::get('/loans/apply', [App\Http\Controllers\LoanApplicationController::class, 'index'])->name('loans.create'); // Alias for consistent linkage
    Route::get('/loans/apply/step1', [App\Http\Controllers\LoanApplicationController::class, 'createStep1'])->name('loans.apply.step1');
    Route::post('/loans/apply/step1', [App\Http\Controllers\LoanApplicationController::class, 'storeStep1'])->name('loans.apply.step1.store');
    
    Route::get('/loans/apply/step2', [App\Http\Controllers\LoanApplicationController::class, 'createStep2'])->name('loans.apply.step2');
    Route::post('/loans/apply/step2', [App\Http\Controllers\LoanApplicationController::class, 'storeStep2'])->name('loans.apply.step2.store');
    
    Route::get('/loans/apply/step3', [App\Http\Controllers\LoanApplicationController::class, 'createStep3'])->name('loans.apply.step3');
    Route::post('/loans/apply/step3', [App\Http\Controllers\LoanApplicationController::class, 'storeStep3'])->name('loans.apply.step3.store');
    
    Route::get('/loans/apply/success/{loan}', [App\Http\Controllers\LoanApplicationController::class, 'showSuccess'])->name('loans.apply.success');
    
    // Special Loan Types
    Route::get('/loans/apply/motorcycle', [App\Http\Controllers\LoanApplicationController::class, 'createMotorcycle'])->name('loans.apply.motorcycle');
    Route::post('/loans/apply/motorcycle', [App\Http\Controllers\LoanApplicationController::class, 'storeMotorcycle'])->name('loans.apply.store.motorcycle');

    Route::get('/loans/apply/ramadan-sallah', [App\Http\Controllers\LoanApplicationController::class, 'createRamadanSallah'])->name('loans.apply.ramadan_sallah');
    Route::post('/loans/apply/ramadan-sallah', [App\Http\Controllers\LoanApplicationController::class, 'storeRamadanSallah'])->name('loans.apply.store.ramadan_sallah');

    Route::get('/loans/apply/asset', [App\Http\Controllers\LoanApplicationController::class, 'createAsset'])->name('loans.apply.asset');
    Route::post('/loans/apply/asset', [App\Http\Controllers\LoanApplicationController::class, 'storeAsset'])->name('loans.apply.store.asset');

    // Routes accessible by both Members and Staff (Controllers handle detailed permissions)
    Route::resource('members', App\Http\Controllers\MemberController::class)->only(['show']);
    Route::get('/members/{member}/statement', [App\Http\Controllers\MemberController::class, 'statement'])->name('members.statement');
    Route::get('/savings', [App\Http\Controllers\SavingController::class, 'index'])->name('savings.index');
    Route::get('/savings/deposit', [App\Http\Controllers\SavingController::class, 'deposit'])->name('savings.deposit');
    Route::post('/savings/deposit', [App\Http\Controllers\SavingController::class, 'storeDeposit'])->name('savings.store.deposit');
    Route::get('/savings/withdraw', [App\Http\Controllers\SavingController::class, 'withdraw'])->name('savings.withdraw');
    Route::post('/savings/withdraw', [App\Http\Controllers\SavingController::class, 'storeWithdrawal'])->name('savings.store.withdrawal');

    Route::get('/contributions', [App\Http\Controllers\ContributionController::class, 'index'])->name('contributions.index');
    Route::get('/contributions/deposit', [App\Http\Controllers\ContributionController::class, 'deposit'])->name('contributions.deposit');
    Route::post('/contributions/deposit', [App\Http\Controllers\ContributionController::class, 'storeDeposit'])->name('contributions.store.deposit');

    Route::resource('loans', App\Http\Controllers\LoanController::class)->only(['index', 'show']);
    Route::get('/repayments/repay', [App\Http\Controllers\RepaymentController::class, 'create'])->name('repayments.create');
    Route::post('/repayments/repay', [App\Http\Controllers\RepaymentController::class, 'store'])->name('repayments.store.user');

    // Staff and Admin Management Area
    Route::middleware('staff')->group(function () {
        // Members Management (Everyone except PRO)
        Route::middleware('can:manage-members')->group(function () {
            Route::resource('members', App\Http\Controllers\MemberController::class)->except(['show']);
            Route::post('/members/{member}/approve', [App\Http\Controllers\MemberController::class, 'approve'])->name('members.approve');
            Route::post('/members/{member}/reject', [App\Http\Controllers\MemberController::class, 'reject'])->name('members.reject');
        });
        
        // Savings Management (Finance, Auditor, Manager, Treasurer only)
        Route::middleware('can:manage-savings')->group(function () {
            Route::resource('savings', App\Http\Controllers\SavingController::class)->only(['create', 'store', 'show']);
            Route::post('/savings/{saving}/approve', [App\Http\Controllers\SavingController::class, 'approve'])->name('savings.approve');
            Route::post('/savings/{saving}/reject', [App\Http\Controllers\SavingController::class, 'reject'])->name('savings.reject');
        });

        // Contributions (Finance, Manager, Treasurer only)
        Route::middleware('can:manage-contributions')->group(function () {
            Route::get('/contributions/{contribution}', [App\Http\Controllers\ContributionController::class, 'show'])->name('contributions.show');
            Route::post('/contributions/{contribution}/approve', [App\Http\Controllers\ContributionController::class, 'approve'])->name('contributions.approve');
            Route::post('/contributions/{contribution}/reject', [App\Http\Controllers\ContributionController::class, 'reject'])->name('contributions.reject');
        });
        
        // Loans Management (Finance, Auditor, Manager, Treasurer only)
        Route::middleware('can:manage-loans')->group(function () {
            Route::resource('loans', App\Http\Controllers\LoanController::class)->except(['create', 'store', 'index', 'show']);
        });
        
        // Repayments (Finance, Auditor, Manager, Treasurer only)
        Route::middleware('can:manage-repayments')->group(function () {
            Route::get('/repayments', [App\Http\Controllers\RepaymentController::class, 'index'])->name('repayments.index');
            Route::get('/repayments/{repayment}', [App\Http\Controllers\RepaymentController::class, 'show'])->name('repayments.show');
            Route::post('/repayments/{repayment}/approve', [App\Http\Controllers\RepaymentController::class, 'approve'])->name('repayments.approve');
            Route::post('/repayments/{repayment}/reject', [App\Http\Controllers\RepaymentController::class, 'reject'])->name('repayments.reject');
            Route::resource('repayments', App\Http\Controllers\RepaymentController::class)->only(['store']);
        });

        // Admin Only actions within management
        Route::middleware('admin')->group(function () {
            // Cashbook (Finance, Auditor, Manager only)
            Route::middleware('can:view-cashbook')->group(function () {
                Route::get('cashbook/export', [App\Http\Controllers\CashbookController::class, 'export'])->name('cashbook.export');
                Route::get('cashbook/import', [App\Http\Controllers\CashbookController::class, 'importForm'])->name('cashbook.import');
                Route::post('cashbook/import', [App\Http\Controllers\CashbookController::class, 'import'])->name('cashbook.import.process');
                Route::get('cashbook/template', [App\Http\Controllers\CashbookController::class, 'downloadTemplate'])->name('cashbook.template');
                Route::get('cashbook/monthly-report', [App\Http\Controllers\CashbookController::class, 'monthlyReport'])->name('cashbook.monthly-report');
                Route::get('cashbook/reconciliation', [App\Http\Controllers\CashbookController::class, 'reconciliationIndex'])->name('cashbook.reconciliation.index');
                Route::get('cashbook/reconciliation/create', [App\Http\Controllers\CashbookController::class, 'reconciliationCreate'])->name('cashbook.reconciliation.create');
                Route::post('cashbook/reconciliation', [App\Http\Controllers\CashbookController::class, 'reconciliationStore'])->name('cashbook.reconciliation.store');
                Route::get('cashbook/reconciliation/{id}', [App\Http\Controllers\CashbookController::class, 'reconciliationShow'])->name('cashbook.reconciliation.show');
                Route::resource('cashbook', App\Http\Controllers\CashbookController::class);
            });
        });
    });
});

// Annual Report (Public)
Route::get('/annual-report-2025', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.annual-2025');

// Member Registration Wizard (Public)
Route::get('/join', [App\Http\Controllers\MemberRegistrationController::class, 'createStep1'])->name('join.step1');
Route::post('/join/step1', [App\Http\Controllers\MemberRegistrationController::class, 'storeStep1'])->middleware('throttle:registration')->name('join.step1.store');
Route::get('/join/step2', [App\Http\Controllers\MemberRegistrationController::class, 'createStep2'])->name('join.step2');
Route::post('/join/step2', [App\Http\Controllers\MemberRegistrationController::class, 'storeStep2'])->name('join.step2.store');
Route::get('/join/step3', [App\Http\Controllers\MemberRegistrationController::class, 'createStep3'])->name('join.step3');
Route::post('/join/step3', [App\Http\Controllers\MemberRegistrationController::class, 'storeStep3'])->name('join.step3.store');
Route::get('/join/success/{member}', [App\Http\Controllers\MemberRegistrationController::class, 'showSuccess'])->name('join.success');

// Internal Management Routes (Staff and Admin)
Route::middleware(['staff'])->prefix('admin')->name('admin.')->group(function () {
    // Loans (Finance, Auditor, Manager, Treasurer only)
    Route::middleware('can:manage-loans')->group(function () {
        Route::get('/loans', [App\Http\Controllers\AdminLoanController::class, 'index'])->name('loans.index');
        Route::get('/loans/{loan}', [App\Http\Controllers\AdminLoanController::class, 'show'])->name('loans.show');
        Route::post('/loans/{loan}/approve', [App\Http\Controllers\AdminLoanController::class, 'approve'])->name('loans.approve');
        Route::post('/loans/{loan}/reject', [App\Http\Controllers\AdminLoanController::class, 'reject'])->name('loans.reject');
        Route::put('/loans/{loan}/update-items', [App\Http\Controllers\AdminLoanController::class, 'updateItems'])->name('loans.update_items');
        Route::post('/loans/{loan}/upload-assets', [App\Http\Controllers\AdminLoanController::class, 'uploadAssetImages'])->name('loans.upload_assets');
        Route::delete('/loan-documents/{document}/asset-image', [App\Http\Controllers\AdminLoanController::class, 'deleteAssetImage'])->name('loans.delete_asset_image');
        
        // Only admins can perform the final disbursement
        Route::post('/loans/{loan}/disburse', [App\Http\Controllers\AdminLoanController::class, 'disburse'])
            ->middleware('admin')
            ->name('loans.disburse');
    });

    // Loan Products Management
    Route::resource('loan-products', App\Http\Controllers\AdminLoanProductController::class)->except(['create', 'edit', 'show']);
    Route::patch('loan-products/{loanProduct}/toggle', [App\Http\Controllers\AdminLoanProductController::class, 'toggleStatus'])->name('loan-products.toggle');

    // Vendor Management
    Route::resource('vendors', App\Http\Controllers\AdminVendorController::class)->except(['create', 'edit', 'show']);
    Route::patch('vendors/{vendor}/toggle', [App\Http\Controllers\AdminVendorController::class, 'toggleStatus'])->name('vendors.toggle');

    // Announcements Management (PRO only)
    Route::middleware('can:manage-announcements')->group(function () {
        Route::resource('announcements', App\Http\Controllers\AdminAnnouncementController::class)->only(['index', 'store', 'destroy']);
        Route::patch('announcements/{announcement}/toggle', [App\Http\Controllers\AdminAnnouncementController::class, 'toggle'])->name('announcements.toggle');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/complete-profile/step1', [App\Http\Controllers\Auth\GoogleRegistrationController::class, 'createStep1'])->name('complete-profile.step1');
    Route::post('/complete-profile/step1', [App\Http\Controllers\Auth\GoogleRegistrationController::class, 'storeStep1'])->name('complete-profile.step1.store');
    
    Route::get('/complete-profile/step2', [App\Http\Controllers\Auth\GoogleRegistrationController::class, 'createStep2'])->name('complete-profile.step2');
    Route::post('/complete-profile/step2', [App\Http\Controllers\Auth\GoogleRegistrationController::class, 'storeStep2'])->name('complete-profile.step2.store');
    
    Route::get('/complete-profile/step3', [App\Http\Controllers\Auth\GoogleRegistrationController::class, 'createStep3'])->name('complete-profile.step3');
    Route::post('/complete-profile/step3', [App\Http\Controllers\Auth\GoogleRegistrationController::class, 'storeStep3'])->name('complete-profile.step3.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read/{id}', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    // Customer Support Routes (Member)
    Route::get('/support', [App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
    Route::get('/support/create', [App\Http\Controllers\SupportController::class, 'create'])->name('support.create');
    Route::post('/support/store', [App\Http\Controllers\SupportController::class, 'store'])->middleware('throttle:support')->name('support.store');
    Route::get('/support/{ticket}', [App\Http\Controllers\SupportController::class, 'show'])->name('support.show');
    Route::post('/support/{ticket}/message', [App\Http\Controllers\SupportController::class, 'message'])->name('support.message');
});

// Admin Support Routes
Route::middleware(['auth', 'staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/support', [App\Http\Controllers\AdminSupportController::class, 'index'])->name('support.index');
    Route::get('/support/{ticket}', [App\Http\Controllers\AdminSupportController::class, 'show'])->name('support.show');
    Route::post('/support/{ticket}/message', [App\Http\Controllers\AdminSupportController::class, 'message'])->name('support.message');
    Route::patch('/support/{ticket}/status', [App\Http\Controllers\AdminSupportController::class, 'updateStatus'])->name('support.updateStatus');
});

require __DIR__.'/auth.php';
