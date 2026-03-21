<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-white tracking-tight flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-500/70 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]"><i class="fas fa-book-open text-lg"></i></div>
            {{ __('Company Cashbook') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-2xl font-black text-white tracking-tight flex items-center gap-2">
                        Financial Overview
                    </h1>
                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mt-1">Track your inflows and outflows efficiently.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    @if(!auth()->user()->canManageAnnouncements())
                    <a href="{{ route('cashbook.export', ['month' => $month, 'year' => $year]) }}" class="bg-[#0B1A14] text-emerald-500/70 hover:text-emerald-400 border border-emerald-900/50 hover:border-emerald-500/50 px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-sm flex items-center gap-2">
                        <i class="fas fa-file-csv"></i> <span>Export CSV</span>
                    </a>
                    <a href="{{ route('cashbook.import') }}" class="bg-[#0B1A14] text-blue-500/70 hover:text-blue-400 border border-blue-900/50 hover:border-blue-500/50 px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-sm flex items-center gap-2">
                        <i class="fas fa-file-upload"></i> <span>Import</span>
                    </a>
                    <a href="{{ route('cashbook.create') }}" class="bg-[#0B1A14] text-emerald-400 border border-emerald-600/50 hover:border-emerald-400 hover:bg-emerald-900/20 px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] flex items-center gap-2">
                        <i class="fas fa-plus"></i> <span>Add Entry</span>
                    </a>
                    <a href="{{ route('cashbook.monthly-report', ['month' => $month, 'year' => $year]) }}" class="bg-gradient-to-r from-amber-600 to-amber-800 text-white px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:from-amber-500 hover:to-amber-700 transition shadow-[0_0_15px_rgba(245,158,11,0.2)] flex items-center gap-2 active:scale-95 border border-amber-500/50">
                        <i class="fas fa-file-invoice"></i> <span>Monthly Report</span>
                    </a>
                    <a href="{{ route('cashbook.reconciliation.index') }}" class="bg-gradient-to-r from-emerald-600 to-emerald-800 border border-emerald-500/50 text-white px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] transition flex items-center gap-2 active:scale-95">
                        <i class="fas fa-balance-scale"></i> <span>Reconcile Account</span>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Filters and Month Navigation -->
            <div class="bg-[#0E211A] rounded-3xl shadow-[0_0_20px_rgba(16,185,129,0.05)] p-6 border border-emerald-900/50 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900 opacity-50"></div>
                
                <form action="{{ route('cashbook.index') }}" method="GET" class="flex flex-col md:flex-row gap-6 items-center justify-between relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <h2 class="text-xl font-black text-white tracking-tight"><i class="far fa-calendar-alt text-emerald-500 mr-2"></i> {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</h2>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="relative">
                            <select name="month" id="month" class="appearance-none bg-[#0B1A14] border border-emerald-900/50 text-white font-bold py-3 px-5 pr-10 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)] cursor-pointer" onchange="this.form.submit()">
                                @for($m = 1; $m <= 12; $m++)
                                    <option class="bg-[#0B1A14]" value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-emerald-500/70">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="year" id="year" class="appearance-none bg-[#0B1A14] border border-emerald-900/50 text-white font-bold py-3 px-5 pr-10 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)] cursor-pointer" onchange="this.form.submit()">
                                @for($y = 2020; $y <= now()->year + 1; $y++)
                                    <option class="bg-[#0B1A14]" value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-emerald-500/70">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @if(!auth()->user()->canManageAnnouncements())
            <!-- Top Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Opening Balance -->
                <div class="bg-[#0B1A14] rounded-3xl p-6 border-l-4 border-gray-600 border-y border-r border-[#0e211a] ring-1 ring-emerald-900/50 relative overflow-hidden group transition hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(156,163,175,0.1)]">
                    <div class="absolute -right-4 -bottom-4 text-gray-700/20 transform -rotate-12 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-wallet text-8xl"></i>
                    </div>
                    <div class="flex justify-between items-start z-10 relative">
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-widest text-emerald-600/70">Opening Balance</p>
                            <h3 class="text-2xl font-black text-white mt-1">₦ {{ number_format($openingBalance, 2) }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-2xl bg-gray-900 border border-gray-800 text-gray-400 flex items-center justify-center group-hover:bg-gray-800 transition shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]">
                            <i class="fas fa-wallet text-sm"></i>
                        </div>
                    </div>
                </div>

                <!-- Income -->
                <div class="bg-[#0B1A14] rounded-3xl p-6 border-l-4 border-emerald-500 border-y border-r border-[#0e211a] ring-1 ring-emerald-900/50 relative overflow-hidden group transition hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(16,185,129,0.1)]">
                    <div class="absolute -right-4 -bottom-4 text-emerald-900/30 transform -rotate-12 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-arrow-down text-8xl"></i>
                    </div>
                    <div class="flex justify-between items-start z-10 relative">
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-widest text-emerald-600/70">Total Income</p>
                            <h3 class="text-2xl font-black text-emerald-400 drop-shadow-[0_0_10px_rgba(52,211,153,0.3)] mt-1">₦ {{ number_format($monthlyIncome, 2) }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-2xl bg-emerald-900/30 border border-emerald-800/50 text-emerald-500 flex items-center justify-center group-hover:bg-emerald-900/50 transition shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]">
                            <i class="fas fa-arrow-down text-sm"></i>
                        </div>
                    </div>
                </div>

                <!-- Expense -->
                <div class="bg-[#0B1A14] rounded-3xl p-6 border-l-4 border-rose-500 border-y border-r border-[#0e211a] ring-1 ring-emerald-900/50 relative overflow-hidden group transition hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(244,63,94,0.1)]">
                    <div class="absolute -right-4 -bottom-4 text-rose-900/20 transform -rotate-12 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-arrow-up text-8xl"></i>
                    </div>
                    <div class="flex justify-between items-start z-10 relative">
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-widest text-rose-600/70">Total Expense</p>
                            <h3 class="text-2xl font-black text-rose-400 drop-shadow-[0_0_10px_rgba(244,63,94,0.3)] mt-1">₦ {{ number_format($monthlyExpense, 2) }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-2xl bg-rose-900/20 border border-rose-900/50 text-rose-500 flex items-center justify-center group-hover:bg-rose-900/30 transition shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]">
                            <i class="fas fa-arrow-up text-sm"></i>
                        </div>
                    </div>
                </div>

                <!-- Closing Balance -->
                <div class="bg-gradient-to-br from-emerald-600 to-emerald-900 rounded-3xl p-6 text-white relative overflow-hidden group hover:shadow-[0_0_25px_rgba(16,185,129,0.3)] hover:-translate-y-1 transition border-l-4 border-emerald-400 border-y border-r border-emerald-800">
                    <div class="absolute -right-4 -bottom-4 text-emerald-500/20 transform -rotate-12 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-coins text-8xl"></i>
                    </div>
                    <div class="flex justify-between items-start z-10 relative">
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-widest text-emerald-100/70">Closing Balance</p>
                            <h3 class="text-3xl font-black text-white drop-shadow-md mt-1">₦ {{ number_format($closingBalance, 2) }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-2xl bg-[#0B1A14]/30 border border-emerald-400/30 text-emerald-400 flex items-center justify-center shadow-inner">
                            <i class="fas fa-piggy-bank text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(!auth()->user()->canManageAnnouncements())
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Transactions List -->
                <div class="lg:col-span-2 bg-[#0E211A] rounded-3xl overflow-hidden border border-emerald-900/50 shadow-[0_0_20px_rgba(16,185,129,0.05)] relative">
                    <div class="px-8 py-6 border-b border-emerald-900/50 bg-[#0B1A14] flex justify-between items-center relative z-10">
                        <h3 class="text-lg font-black text-white tracking-tight flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse drop-shadow-[0_0_5px_rgba(16,185,129,0.8)]"></span>
                            Recent Transactions
                        </h3>
                        <span class="px-3 py-1.5 bg-emerald-900/30 border border-emerald-500/30 text-emerald-400 text-[9px] font-black uppercase tracking-widest rounded-lg shadow-inner">{{ $transactions->count() }} records</span>
                    </div>

                    <div class="overflow-x-auto relative z-10">
                        <table class="min-w-full divide-y divide-emerald-900/30">
                            <thead class="bg-[#0E211A]/50 backdrop-blur-md">
                                <tr>
                                    <th class="px-8 py-5 text-left text-[10px] font-black tracking-widest text-emerald-600/70 uppercase">Date</th>
                                    <th class="px-8 py-5 text-left text-[10px] font-black tracking-widest text-emerald-600/70 uppercase">Category</th>
                                    <th class="px-8 py-5 text-left text-[10px] font-black tracking-widest text-emerald-600/70 uppercase">Description</th>
                                    <th class="px-8 py-5 text-right text-[10px] font-black tracking-widest text-emerald-600/70 uppercase">Amount</th>
                                    <th class="px-8 py-5 text-center text-[10px] font-black tracking-widest text-emerald-600/70 uppercase">Doc</th>
                                    <th class="px-8 py-5 text-right text-[10px] font-black tracking-widest text-emerald-600/70 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-900/30 bg-transparent">
                                @forelse($transactions as $transaction)
                                    <tr class="hover:bg-[#0B1A14]/80 transition-colors group">
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-white tracking-tight">{{ $transaction->transaction_date->format('d M') }}</span>
                                                <span class="text-xs font-black uppercase tracking-widest text-emerald-600/70 mt-0.5">{{ $transaction->transaction_date->format('Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($transaction->type === 'income')
                                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 drop-shadow-[0_0_5px_rgba(16,185,129,0.8)] mr-2"></div>
                                                @else
                                                    <div class="w-1.5 h-1.5 rounded-full bg-rose-500 drop-shadow-[0_0_5px_rgba(244,63,94,0.8)] mr-2"></div>
                                                @endif
                                                <span class="text-white font-bold tracking-tight">{{ $transaction->category }}</span>
                                                <span class="ml-2 px-2 py-0.5 rounded-md bg-[#0B1A14] border border-emerald-900/50 text-[9px] font-black uppercase tracking-widest text-emerald-600/70">{{ $transaction->payment_method }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-sm text-emerald-100/70 font-semibold truncate max-w-[200px]">
                                            {{ Str::limit($transaction->description, 40) ?: '-' }}
                                            @if($transaction->reference_number)
                                                <div class="text-[9px] font-black uppercase tracking-widest text-emerald-600/50 mt-1">Ref: {{ $transaction->reference_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <span class="text-sm font-black {{ $transaction->type === 'income' ? 'text-emerald-400 drop-shadow-[0_0_5px_rgba(52,211,153,0.3)]' : 'text-rose-400 drop-shadow-[0_0_5px_rgba(244,63,94,0.3)]' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }} ₦ {{ number_format($transaction->amount, 2) }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-center">
                                            @if($transaction->attachment_path)
                                                <a href="{{ Storage::url($transaction->attachment_path) }}" target="_blank" class="w-8 h-8 mx-auto rounded-lg flex items-center justify-center bg-[#0B1A14] text-emerald-500/50 border border-emerald-900/50 hover:bg-emerald-900/30 hover:border-emerald-500/50 hover:text-emerald-400 transition-colors shadow-sm" title="View Receipt">
                                                    <i class="fas fa-file-alt text-xs"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('cashbook.edit', $transaction) }}" class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#0B1A14] text-blue-500/70 border border-transparent hover:border-blue-500/30 hover:bg-blue-900/20 hover:text-blue-400 transition-colors shadow-sm" title="Edit">
                                                    <i class="fas fa-edit text-xs"></i>
                                                </a>
                                                <form action="{{ route('cashbook.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Securely purge this ledger entry?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#0B1A14] text-rose-500/70 border border-transparent hover:border-rose-500/30 hover:bg-rose-900/20 hover:text-rose-400 transition-colors shadow-sm" title="Delete">
                                                        <i class="fas fa-trash-alt text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-8 py-20 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-20 h-20 mx-auto bg-[#0B1A14] border-2 border-emerald-900/50 text-emerald-900/50 rounded-2xl flex items-center justify-center text-4xl mb-6 shadow-inner">
                                                    <i class="fas fa-inbox"></i>
                                                </div>
                                                <h3 class="text-xl font-bold text-white tracking-tight">Ledger Empty</h3>
                                                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50 mt-2">No transactions recorded for this fiscal period.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Analytics Chart -->
                <div class="bg-[#0E211A] rounded-3xl p-8 border border-emerald-900/50 shadow-[0_0_20px_rgba(16,185,129,0.05)] flex flex-col relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900 opacity-50"></div>
                    
                    <h3 class="text-lg font-black text-white tracking-tight mb-8">Financial Flow Analytics</h3>
                    
                    <div class="relative flex-grow min-h-[300px] flex items-center justify-center">
                        <canvas id="cashFlowChart"></canvas>
                        @if($monthlyIncome == 0 && $monthlyExpense == 0)
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-[#0B1A14]/80 backdrop-blur-sm rounded-full m-4 border border-emerald-900/30">
                                <i class="fas fa-chart-pie text-4xl text-emerald-900/50 mb-3"></i>
                                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50">Insufficient Analytics</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8 space-y-4 bg-[#0B1A14] p-5 rounded-2xl border border-emerald-900/50 shadow-inner">
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center text-[10px] font-black uppercase tracking-widest text-emerald-600/70">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 drop-shadow-[0_0_5px_rgba(16,185,129,0.5)]"></span> Income
                            </span>
                            <span class="font-black text-emerald-400 drop-shadow-[0_0_5px_rgba(52,211,153,0.3)]">₦ {{ number_format($monthlyIncome, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center text-[10px] font-black uppercase tracking-widest text-emerald-600/70">
                                <span class="w-2 h-2 rounded-full bg-rose-500 mr-2 drop-shadow-[0_0_5px_rgba(244,63,94,0.5)]"></span> Expense
                            </span>
                            <span class="font-black text-rose-400 drop-shadow-[0_0_5px_rgba(244,63,94,0.3)]">₦ {{ number_format($monthlyExpense, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm pt-4 border-t border-emerald-900/50 mt-4">
                            <span class="font-black text-white text-xs uppercase tracking-widest">Net Flow Radar</span>
                            <span class="font-black text-lg {{ ($monthlyIncome - $monthlyExpense) >= 0 ? 'text-emerald-400 drop-shadow-[0_0_8px_rgba(52,211,153,0.4)]' : 'text-rose-400 drop-shadow-[0_0_8px_rgba(244,63,94,0.4)]' }}">
                                {{ ($monthlyIncome - $monthlyExpense) >= 0 ? '+' : '' }} ₦ {{ number_format($monthlyIncome - $monthlyExpense, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Chart.js setup with dark theme -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            // Theme settings for Chart.js
            Chart.defaults.color = '#047857'; // emerald-600
            Chart.defaults.font.family = 'Inter, sans-serif';
            Chart.defaults.font.weight = 'bold';

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
                
                window.location.href = `{{ route('cashbook.index') }}?month=${newMonth}&year=${newYear}`;
            }

            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('cashFlowChart').getContext('2d');
                const income = {{ $monthlyIncome }};
                const expense = {{ $monthlyExpense }};

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Incoming Funds', 'Outgoing Expenses'],
                        datasets: [{
                            data: [income, expense],
                            backgroundColor: [
                                '#10B981', // emerald-500
                                '#F43F5E'  // rose-500
                            ],
                            borderColor: '#0E211A', // match background
                            borderWidth: 4,
                            hoverOffset: 6,
                            hoverBorderColor: '#0E211A'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, 
                        plugins: {
                            legend: {
                                display: false 
                            },
                            tooltip: {
                                backgroundColor: '#0B1A14',
                                titleColor: '#6ee7b7', // emerald-300
                                bodyColor: '#ffffff',
                                bodyFont: {
                                    weight: 'bold'
                                },
                                borderColor: 'rgba(6, 78, 59, 0.5)', // emerald-900/50
                                borderWidth: 1,
                                padding: 12,
                                cornerRadius: 12,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed !== null) {
                                            label += '₦ ' + new Intl.NumberFormat('en-NG').format(context.parsed);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        cutout: '75%', 
                    }
                });
            });
        </script>
    </div>
</x-app-layout>
