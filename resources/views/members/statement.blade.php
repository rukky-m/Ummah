<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Financial Statement') }} - {{ $member->full_name }}
            </h2>
            <button onclick="window.print()" class="bg-army-green text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-green-900 transition-all flex items-center gap-2 print:hidden">
                <i class="fas fa-print"></i>
                Print Statement
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statement Header (Visible in Print) -->
            <div class="hidden print:block mb-8 text-center">
                <h1 class="text-2xl font-black text-army-green uppercase tracking-tighter">NSUK Ummah Multi-Purpose Cooperative Society</h1>
                <p class="text-sm font-bold text-gold uppercase tracking-widest">Official Member Financial Statement</p>
                <div class="mt-4 border-t border-b py-4 grid grid-cols-2 text-left">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-black">Member Name</p>
                        <p class="font-bold">{{ $member->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-black">Account Number</p>
                        <p class="font-bold">{{ $member->account_number ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-gray-50 p-6 rounded-2xl border-b-4 border-army-green">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Contributions</p>
                            <p class="text-2xl font-black text-army-green">₦{{ number_format($member->savings()->where('type', 'deposit')->where('status', 'approved')->sum('amount'), 2) }}</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-2xl border-b-4 border-gold">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Loans Taken</p>
                            <p class="text-2xl font-black text-gray-800">₦{{ number_format($member->loans()->whereIn('status', ['approved', 'active', 'disbursed', 'completed'])->sum('amount'), 2) }}</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-2xl border-b-4 border-blue-600">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Repaid</p>
                            @php
                                $totalRepaid = 0;
                                foreach($member->loans as $loan) {
                                    $totalRepaid += $loan->repayments()->sum('amount');
                                }
                            @endphp
                            <p class="text-2xl font-black text-blue-600">₦{{ number_format($totalRepaid, 2) }}</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-2xl border-b-4 border-red-600">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Outstanding Balance</p>
                            @php
                                $totalLoanWithInterest = $member->loans()->whereIn('status', ['approved', 'active', 'disbursed'])->sum('total_repayment');
                                $outstanding = $totalLoanWithInterest - $totalRepaid;
                            @endphp
                            <p class="text-2xl font-black text-red-600">₦{{ number_format(max(0, $outstanding), 2) }}</p>
                        </div>
                    </div>

                    <h3 class="text-lg font-black text-army-green mb-6 uppercase tracking-tight flex items-center gap-2">
                        <i class="fas fa-list-ul"></i>
                        Monthly Breakdown (Consolidated)
                    </h3>

                    <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Month / Year</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Contributions</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Withdrawals</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Loan Disbursed</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Loan Repaid</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right bg-army-green/5">Net Flow</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($monthlyReport as $month => $data)
                                    <tr class="hover:bg-gray-50/50 transition-all">
                                        <td class="px-6 py-4 font-bold text-gray-700">{{ $month }}</td>
                                        <td class="px-6 py-4 text-right font-black text-army-green">₦{{ number_format($data['contributions'], 2) }}</td>
                                        <td class="px-6 py-4 text-right font-bold text-red-500">₦{{ number_format($data['withdrawals'], 2) }}</td>
                                        <td class="px-6 py-4 text-right font-bold text-blue-600">₦{{ number_format($data['loan_disbursed'], 2) }}</td>
                                        <td class="px-6 py-4 text-right font-bold text-green-600">₦{{ number_format($data['loan_repaid'], 2) }}</td>
                                        <td class="px-6 py-4 text-right font-black bg-army-green/5 {{ $data['net_flow'] >= 0 ? 'text-army-green' : 'text-red-600' }}">
                                            ₦{{ number_format($data['net_flow'], 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">No financial activity recorded in the selected period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Signature Area (Visible in Print) -->
                    <div class="hidden print:grid grid-cols-2 gap-20 mt-20 pt-10 border-t border-dashed">
                        <div class="text-center">
                            <div class="h-20 border-b border-gray-300 mb-2 mx-auto w-48"></div>
                            <p class="text-[10px] font-black uppercase tracking-widest">Cooperative Secretary</p>
                        </div>
                        <div class="text-center">
                            <div class="h-20 border-b border-gray-300 mb-2 mx-auto w-48"></div>
                            <p class="text-[10px] font-black uppercase tracking-widest">Member Signature</p>
                        </div>
                    </div>

                    <div class="mt-8 text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center gap-2 print:hidden">
                        <i class="fas fa-info-circle text-gold"></i>
                        Note: This statement includes all approved financial activities recorded in the system.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { background: white !important; }
            .py-12 { padding-top: 0 !important; padding-bottom: 0 !important; }
            .shadow-sm { shadow: none !important; }
            .bg-white { background: transparent !important; }
            .max-w-7xl { max-width: 100% !important; }
            header, nav, .print\:hidden { display: none !important; }
        }
    </style>
</x-app-layout>
