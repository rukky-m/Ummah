<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">
            {{ __('Revenue Architecture') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 dark:bg-gray-900/30">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-hidden bg-white/60 dark:bg-gray-900/40 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-3xl">
                <div class="p-7">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                        <div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
                                <span class="w-2 h-6 bg-emerald-500 rounded-full"></span>
                                Repayment Registry
                            </h3>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">Real-time monitoring and verification of loan amortization flows.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-3">
                            <thead>
                                <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                                    <th class="px-6 pb-2">Entry Date</th>
                                    <th class="px-6 pb-2">Member / Asset</th>
                                    <th class="px-6 pb-2">Accounting Period</th>
                                    <th class="px-6 pb-2">Quantum (₦)</th>
                                    <th class="px-6 pb-2 text-center">Status</th>
                                    <th class="px-6 pb-2 text-right">Verification</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($repayments as $repayment)
                                    <tr class="bg-white/40 dark:bg-gray-800/40 hover:bg-white/60 dark:hover:bg-gray-800/60 backdrop-blur-md transition-all duration-300 group shadow-sm hover:shadow-md">
                                        <td class="px-6 py-5 rounded-l-2xl border-y border-l border-gray-900/5 dark:border-white/5">
                                            <span class="text-xs font-bold text-gray-500">{{ $repayment->created_at->format('d M Y') }}</span>
                                        </td>
                                        <td class="px-6 py-5 border-y border-gray-900/5 dark:border-white/5">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-black text-gray-900 dark:text-white">{{ $repayment->loan->member->full_name }}</span>
                                                <span class="text-[9px] text-emerald-600 dark:text-emerald-400 font-black uppercase tracking-widest mt-0.5">{{ $repayment->loan->application_number }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 border-y border-gray-900/5 dark:border-white/5">
                                            <span class="text-xs font-black text-gray-700 dark:text-gray-300 uppercase tracking-tighter">
                                                {{ $repayment->month }} {{ $repayment->year }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 border-y border-gray-900/5 dark:border-white/5">
                                            <span class="text-sm font-black text-gray-900 dark:text-white">₦{{ number_format($repayment->amount, 0) }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-center border-y border-gray-900/5 dark:border-white/5">
                                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest 
                                                {{ $repayment->status == 'approved' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' : ($repayment->status == 'rejected' ? 'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400' : 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400') }}">
                                                {{ $repayment->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 rounded-r-2xl border-y border-r border-gray-900/5 dark:border-white/5 text-right">
                                            @if($repayment->status == 'pending')
                                                <a href="{{ route('repayments.show', $repayment) }}" 
                                                   class="inline-block bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:shadow-xl hover:-translate-y-0.5 transition-all">
                                                    Verify Entry
                                                </a>
                                            @else
                                                <a href="{{ route('repayments.show', $repayment) }}" 
                                                   class="text-[9px] font-black text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition uppercase tracking-widest italic">
                                                    View Details
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-24 text-center bg-white/20 dark:bg-white/5 backdrop-blur-sm rounded-3xl border border-dashed border-gray-900/5 dark:border-white/10">
                                            <div class="w-20 h-20 bg-gray-50 dark:bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                                <i class="fas fa-receipt text-3xl text-gray-300 dark:text-gray-600"></i>
                                            </div>
                                            <h4 class="text-xl font-black text-gray-900 dark:text-white tracking-tight">Ledger Clean</h4>
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-2 lowercase">No repayment records identified in the current cycle.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
