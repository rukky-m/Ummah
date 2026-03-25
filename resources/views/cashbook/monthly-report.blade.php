<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Monthly Financial Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto px-4 py-8">
            <!-- Header with Print Button -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Monthly Financial Report</h1>
                    <p class="text-gray-500 mt-1">{{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('cashbook.index', ['month' => $month, 'year' => $year]) }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-bold hover:bg-gray-200 transition flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> 
                        <span>Back to Cashbook</span>
                    </a>
                    <button onclick="window.print()" class="bg-army-green text-white px-6 py-3 rounded-lg shadow-lg hover:bg-green-800 transition flex items-center gap-2">
                        <i class="fas fa-print"></i> 
                        <span>Print Report</span>
                    </button>
                </div>
            </div>

            <!-- Month Navigation -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
                <form action="{{ route('cashbook.monthly-report') }}" method="GET" class="flex flex-col md:flex-row gap-6 items-center justify-center">
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <h2 class="text-xl font-bold text-gray-800">{{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</h2>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <select name="month" id="month" class="appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-army-green" onchange="this.form.submit()">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                </option>
                            @endfor
                        </select>
                        <select name="year" id="year" class="appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-army-green" onchange="this.form.submit()">
                            @for($y = 2020; $y <= now()->year + 1; $y++)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-gray-400">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Opening Balance</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">₦ {{ number_format($openingBalance, 2) }}</h3>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <p class="text-sm font-semibold text-green-600 uppercase tracking-wider">Total Income</p>
                    <h3 class="text-2xl font-bold text-green-700 mt-2">₦ {{ number_format($monthlyIncome, 2) }}</h3>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                    <p class="text-sm font-semibold text-red-600 uppercase tracking-wider">Total Expense</p>
                    <h3 class="text-2xl font-bold text-red-700 mt-2">₦ {{ number_format($monthlyExpense, 2) }}</h3>
                </div>

                <div class="bg-gradient-to-br from-army-green to-green-800 rounded-xl shadow-lg p-6 text-white">
                    <p class="text-sm font-semibold text-green-100 uppercase tracking-wider">Closing Balance</p>
                    <h3 class="text-3xl font-bold text-white mt-2">₦ {{ number_format($closingBalance, 2) }}</h3>
                </div>
            </div>

            <!-- Category Breakdown -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Income by Category -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-arrow-down text-green-600"></i>
                        Income by Category
                    </h3>
                    @if($incomeByCategory->count() > 0)
                        <div class="space-y-3">
                            @foreach($incomeByCategory as $category => $amount)
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ $category }}</span>
                                        <span class="text-sm font-bold text-green-600">₦ {{ number_format($amount, 2) }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $monthlyIncome > 0 ? ($amount / $monthlyIncome * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No income recorded this month</p>
                    @endif
                </div>

                <!-- Expense by Category -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-arrow-up text-red-600"></i>
                        Expense by Category
                    </h3>
                    @if($expenseByCategory->count() > 0)
                        <div class="space-y-3">
                            @foreach($expenseByCategory as $category => $amount)
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700">{{ $category }}</span>
                                        <span class="text-sm font-bold text-red-600">₦ {{ number_format($amount, 2) }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $monthlyExpense > 0 ? ($amount / $monthlyExpense * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No expenses recorded this month</p>
                    @endif
                </div>
            </div>

            <!-- Payment Method Breakdown -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-credit-card text-army-green"></i>
                    Payment Method Distribution
                </h3>
                @if($paymentMethodBreakdown->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($paymentMethodBreakdown as $method => $amount)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-xs text-gray-500 uppercase tracking-wider">{{ $method }}</p>
                                <p class="text-xl font-bold text-gray-800 mt-1">₦ {{ number_format($amount, 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No transactions recorded this month</p>
                @endif
            </div>

            <!-- Transaction Details -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Transaction Details</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $transaction->transaction_date->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center">
                                            @if($transaction->type === 'income')
                                                <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                                            @else
                                                <div class="w-2 h-2 rounded-full bg-red-500 mr-2"></div>
                                            @endif
                                            <span class="text-gray-900 font-medium">{{ $transaction->category }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ Str::limit($transaction->description, 50) ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }} ₦ {{ number_format($transaction->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        No transactions found for this month.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeMonth(offset) {
            const currentMonth = {{ $month }};
            const currentYear = {{ $year }};
            
            let newMonth = currentMonth + offset;
            let newYear = currentYear;
            
            if (newMonth > 12) {
                newMonth = 1;
                newYear++;
            } else if (newMonth < 1) {
                newMonth = 12;
                newYear--;
            }
            
            window.location.href = `{{ route('cashbook.monthly-report') }}?month=${newMonth}&year=${newYear}`;
        }

        // Print styles
        window.addEventListener('beforeprint', function() {
            document.querySelector('.no-print')?.classList.add('hidden');
        });
    </script>

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
