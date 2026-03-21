<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reconciliation Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Reconciliation Details</h1>
                        <p class="text-gray-500 text-sm mt-1">{{ $reconciliation->reconciliation_date->format('d F Y') }}</p>
                    </div>
                    <a href="{{ route('cashbook.reconciliation.index') }}" class="text-gray-500 hover:text-army-green transition flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to List</span>
                    </a>
                </div>

                <!-- Status Badge -->
                <div class="mb-6">
                    @if($reconciliation->status === 'completed')
                        <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle"></i> Completed
                        </span>
                    @else
                        <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">
                            <i class="fas fa-exclamation-circle"></i> Pending
                        </span>
                    @endif
                </div>

                <!-- Balance Comparison -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                        <p class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Bank Statement</p>
                        <h3 class="text-2xl font-bold text-blue-700 mt-2">₦ {{ number_format($reconciliation->bank_statement_balance, 2) }}</h3>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-army-green">
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Cashbook Balance</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-2">₦ {{ number_format($reconciliation->cashbook_balance, 2) }}</h3>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 {{ abs($reconciliation->difference) < 0.01 ? 'border-green-500' : 'border-red-500' }}">
                        <p class="text-sm font-semibold {{ abs($reconciliation->difference) < 0.01 ? 'text-green-600' : 'text-red-600' }} uppercase tracking-wider">Difference</p>
                        <h3 class="text-2xl font-bold {{ abs($reconciliation->difference) < 0.01 ? 'text-green-700' : 'text-red-700' }} mt-2">
                            {{ $reconciliation->difference >= 0 ? '+' : '' }} ₦ {{ number_format($reconciliation->difference, 2) }}
                        </h3>
                    </div>
                </div>

                <!-- Reconciliation Information -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-8">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-800">Reconciliation Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Reconciliation Date</p>
                                <p class="text-base font-semibold text-gray-800 mt-1">{{ $reconciliation->reconciliation_date->format('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Reconciled By</p>
                                <p class="text-base font-semibold text-gray-800 mt-1">{{ $reconciliation->reconciledBy->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Created At</p>
                                <p class="text-base font-semibold text-gray-800 mt-1">{{ $reconciliation->created_at->format('d F Y, h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="text-base font-semibold text-gray-800 mt-1">
                                    @if($reconciliation->status === 'completed')
                                        <span class="text-green-600">Completed</span>
                                    @else
                                        <span class="text-yellow-600">Pending Review</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($reconciliation->notes)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-8">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-lg font-bold text-gray-800">Notes</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $reconciliation->notes }}</p>
                        </div>
                    </div>
                @endif

                <!-- Analysis -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-800">Analysis</h3>
                    </div>
                    <div class="p-6">
                        @if(abs($reconciliation->difference) < 0.01)
                            <div class="flex items-start gap-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <i class="fas fa-check-circle text-2xl text-green-600 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-green-800">Perfect Match!</h4>
                                    <p class="text-sm text-green-700 mt-1">The bank statement balance matches the cashbook balance exactly. No discrepancies found.</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <i class="fas fa-exclamation-triangle text-2xl text-yellow-600 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-yellow-800">Discrepancy Detected</h4>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        There is a difference of <strong>₦ {{ number_format(abs($reconciliation->difference), 2) }}</strong> between the bank statement and cashbook.
                                    </p>
                                    <p class="text-sm text-yellow-700 mt-2">
                                        @if($reconciliation->difference > 0)
                                            The bank statement shows more funds than the cashbook. This could indicate unrecorded income or bank interest.
                                        @else
                                            The cashbook shows more funds than the bank statement. This could indicate unrecorded expenses, bank charges, or pending transactions.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex justify-between items-center">
                    <a href="{{ route('cashbook.reconciliation.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back to List
                    </a>
                    <button onclick="window.print()" class="px-6 py-2.5 bg-army-green text-white font-medium rounded-lg shadow-lg hover:bg-green-800 transition">
                        <i class="fas fa-print mr-2"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</x-app-layout>
