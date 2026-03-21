<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('cashbook.reconciliation.index') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gold leading-tight tracking-tight uppercase">
                    {{ __('Bank Reconciliation') }}
                </h2>
                <p class="text-xs text-emerald-500/60 mt-1 font-bold uppercase tracking-widest">Synchronize Ledger with Official Bank Statement</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#0B1A14] overflow-hidden shadow-2xl border border-emerald-900/50 sm:rounded-[3rem]">
                <form id="reconciliationForm" action="{{ route('cashbook.reconciliation.store') }}" method="POST">
                    @csrf
                    
                    <div class="p-8 md:p-12 space-y-12">
                        <!-- Dual Balance Dashboard -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="p-8 bg-emerald-950/20 border border-emerald-900/50 rounded-[2.5rem] shadow-inner relative overflow-hidden group">
                                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                                    <i class="fas fa-book text-8xl text-emerald-500"></i>
                                </div>
                                <span class="text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.3em] block mb-2">Internal Ledger Balance</span>
                                <h3 class="text-3xl font-black text-white tracking-tighter">₦{{ number_format($cashbookBalance, 2) }}</h3>
                                <div class="mt-4 flex items-center gap-2 text-[10px] font-black text-emerald-500 uppercase tracking-widest">
                                    <i class="fas fa-check-circle text-xs"></i> Verified System Total
                                </div>
                            </div>

                            <div class="p-8 bg-[#0E211A] border border-emerald-500/20 rounded-[2.5rem] shadow-2xl relative overflow-hidden group">
                                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                                    <i class="fas fa-university text-8xl text-gold"></i>
                                </div>
                                <span class="text-[10px] font-black text-gold/70 uppercase tracking-[0.3em] block mb-2">Statement Balance Input</span>
                                <div class="relative mt-2">
                                    <div class="absolute left-0 top-1/2 -translate-y-1/2 text-gold font-black text-2xl">₦</div>
                                    <input type="text" name="bank_statement_balance" id="bank_statement_balance" 
                                        inputmode="numeric"
                                        oninput="
                                            let val = this.value.replace(/[^0-9.]/g, '');
                                            if (val.split('.').length > 2) val = val.replace(/\.+$/, '');
                                            let parts = val.split('.');
                                            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                            this.value = parts.join('.');
                                            calculateDifference();
                                        "
                                        onblur="
                                            let val = this.value.replace(/,/g, '');
                                            if (val && !isNaN(val)) {
                                                this.value = parseFloat(val).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                            }
                                            calculateDifference();
                                        "
                                        class="w-full pl-8 pr-0 bg-transparent border-none focus:ring-0 text-3xl font-black text-white tracking-tighter placeholder-emerald-900/30" 
                                        placeholder="0.00" required>
                                </div>
                                <div class="mt-4 h-0.5 w-full bg-emerald-900/30 rounded-full">
                                    <div id="diff-progress" class="h-full bg-gold w-0 transition-all duration-500"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Discrepancy Alert (Dynamic) -->
                        <div id="difference-display" class="hidden animate-in fade-in slide-in-from-top-4 duration-500">
                            <div class="p-8 rounded-[2rem] border transition-all duration-500 flex flex-col md:flex-row items-center justify-between gap-6" id="diff-status-box">
                                <div class="flex items-center gap-6 text-center md:text-left">
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl shadow-2xl" id="diff-icon-box">
                                        <i class="fas fa-balance-scale" id="diff-icon"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-[10px] font-black uppercase tracking-[0.3em] mb-1 opacity-70" id="diff-label">Variance Detected</h4>
                                        <p class="text-2xl font-black tracking-tight text-white" id="difference-amount"></p>
                                    </div>
                                </div>
                                <p class="text-[11px] font-black uppercase tracking-widest max-w-sm text-center md:text-right leading-relaxed" id="difference-message"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                            <!-- Reconciliation Date -->
                            <div class="space-y-4">
                                <label for="reconciliation_date" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-1">Valuation Date</label>
                                <input type="date" name="reconciliation_date" id="reconciliation_date" required
                                    class="w-full bg-[#0E211A] border border-emerald-900/50 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-black text-xs uppercase tracking-widest transition-all focus:outline-none shadow-inner"
                                    value="{{ old('reconciliation_date', now()->format('Y-m-d')) }}">
                                <x-input-error :messages="$errors->get('reconciliation_date')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2 space-y-4">
                                <label for="notes" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-1">Adjustments & Observations <span class="text-emerald-900">(Optional)</span></label>
                                <textarea name="notes" id="notes" rows="1"
                                    class="w-full bg-[#0E211A] border border-emerald-900/50 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-emerald-100 font-bold text-sm transition-all focus:outline-none shadow-inner placeholder-emerald-900/30 resize-none" 
                                    placeholder="Explain discrepancies or highlight pending settlements...">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Transaction Ledger -->
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <h3 class="font-black text-lg text-white uppercase tracking-tight flex items-center gap-4">
                                    <i class="fas fa-history text-gold text-sm shadow-sm"></i>
                                    Execution History <span class="text-[10px] text-emerald-800 font-black tracking-[0.3em] ml-2">(Last 50 Entries)</span>
                                </h3>
                            </div>
                            <div class="max-h-[30rem] overflow-y-auto rounded-[2rem] border border-emerald-900/50 shadow-2xl custom-scrollbar">
                                <table class="min-w-full text-left">
                                    <thead class="sticky top-0 z-10">
                                        <tr class="bg-emerald-950 border-b border-emerald-900/50">
                                            <th class="px-8 py-5 text-[9px] font-black text-emerald-700 uppercase tracking-[0.3em]">Posting Date</th>
                                            <th class="px-8 py-5 text-[9px] font-black text-emerald-700 uppercase tracking-[0.3em]">Classification</th>
                                            <th class="px-8 py-5 text-[9px] font-black text-emerald-700 uppercase tracking-[0.3em]">Description</th>
                                            <th class="px-8 py-5 text-right text-[9px] font-black text-emerald-700 uppercase tracking-[0.3em]">Value Flow</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-emerald-900/20 bg-[#0E211A]/30">
                                        @foreach($recentTransactions as $transaction)
                                            <tr class="group hover:bg-emerald-900/10 transition-all">
                                                <td class="px-8 py-5 whitespace-nowrap">
                                                    <span class="text-[11px] font-black text-white uppercase tracking-wider group-hover:text-gold transition-colors">{{ $transaction->transaction_date->format('d M, Y') }}</span>
                                                </td>
                                                <td class="px-8 py-5 whitespace-nowrap">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-1.5 h-1.5 rounded-full {{ $transaction->type === 'income' ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.5)]' }}"></div>
                                                        <span class="text-[10px] font-black text-emerald-500/70 uppercase tracking-widest">{{ $transaction->category }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5 text-[11px] text-emerald-100/50 font-bold tracking-tight italic">
                                                    {{ Str::limit($transaction->description, 40) ?: 'N/A' }}
                                                </td>
                                                <td class="px-8 py-5 whitespace-nowrap text-right font-black text-sm tracking-tighter {{ $transaction->type === 'income' ? 'text-emerald-400' : 'text-red-400' }}">
                                                    {{ $transaction->type === 'income' ? '+' : '-' }} ₦{{ number_format($transaction->amount, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col md:flex-row items-center justify-between gap-8 pt-10 border-t border-emerald-900/30">
                            <a href="{{ route('cashbook.reconciliation.index') }}" class="w-full md:w-auto px-10 py-5 bg-emerald-950/30 text-emerald-600 font-black text-[10px] uppercase tracking-[0.3em] rounded-2xl border border-emerald-900/50 hover:bg-[#0E211A] hover:text-emerald-400 transition-all text-center">
                                <i class="fas fa-arrow-left mr-3"></i>
                                Abandon Process
                            </a>
                            <button type="submit" class="w-full md:flex-1 bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-6 rounded-2xl shadow-2xl shadow-emerald-900/50 hover:shadow-emerald-500/40 hover:-translate-y-1.5 transition-all text-[11px] uppercase tracking-[0.3em] flex items-center justify-center gap-4 active:scale-95 group">
                                <i class="fas fa-balance-scale group-hover:rotate-12 transition-transform mb-0.5"></i>
                                Commit Official Reconciliation
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(6, 78, 59, 0.1); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(16, 185, 129, 0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(16, 185, 129, 0.3); }
    </style>

    <script>
        const cashbookBalance = {{ $cashbookBalance }};

        function calculateDifference() {
            const amountInput = document.getElementById('bank_statement_balance');
            const bankBalance = parseFloat(amountInput.value.replace(/,/g, '')) || 0;
            const difference = bankBalance - cashbookBalance;
            
            const displayDiv = document.getElementById('difference-display');
            const amountSpan = document.getElementById('difference-amount');
            const messageP = document.getElementById('difference-message');
            const statusBox = document.getElementById('diff-status-box');
            const iconBox = document.getElementById('diff-icon-box');
            const icon = document.getElementById('diff-icon');
            const progress = document.getElementById('diff-progress');
            const label = document.getElementById('diff-label');
            
            if (bankBalance > 0) {
                displayDiv.classList.remove('hidden');
                
                if (Math.abs(difference) < 0.01) {
                    amountSpan.textContent = '₦0.00 Precision Match';
                    statusBox.className = 'p-8 rounded-[2rem] border border-emerald-500/30 bg-emerald-500/10 flex flex-col md:flex-row items-center justify-between gap-6';
                    iconBox.className = 'w-16 h-16 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-2xl shadow-2xl';
                    icon.className = 'fas fa-check-double';
                    label.textContent = 'Perfect Synchronization';
                    messageP.textContent = 'Ledger and bank statement are in perfect alignment. Proceed to commit.';
                    messageP.className = 'text-[11px] font-black uppercase tracking-widest max-w-sm text-center md:text-right leading-relaxed text-emerald-400';
                    progress.className = 'h-full bg-emerald-500 w-full transition-all duration-1000';
                } else {
                    const diffFormatted = (difference >= 0 ? '+' : '-') + '₦' + Math.abs(difference).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    amountSpan.textContent = diffFormatted;
                    statusBox.className = 'p-8 rounded-[2rem] border border-red-500/30 bg-red-950/10 flex flex-col md:flex-row items-center justify-between gap-6';
                    iconBox.className = 'w-16 h-16 rounded-2xl bg-red-500/20 text-red-400 flex items-center justify-center text-2xl shadow-2xl';
                    icon.className = 'fas fa-exclamation-triangle';
                    label.textContent = 'Variance Detected';
                    messageP.textContent = 'Discrepancy identified between internal ledger and statement. Please verify adjustments.';
                    messageP.className = 'text-[11px] font-black uppercase tracking-widest max-w-sm text-center md:text-right leading-relaxed text-red-400';
                    progress.className = 'h-full bg-red-500 w-1/2 transition-all duration-500';
                }
            } else {
                displayDiv.classList.add('hidden');
                progress.className = 'h-full bg-gold w-0 transition-all duration-500';
            }
        }

        document.getElementById('reconciliationForm').addEventListener('submit', function() {
            const amountInput = document.getElementById('bank_statement_balance');
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    </script>
</x-app-layout>
