<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('savings.index') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gold leading-tight tracking-tight uppercase">
                    {{ __('Withdraw Funds') }}
                </h2>
                <p class="text-xs text-emerald-500/60 mt-1 font-bold uppercase tracking-widest">Access your savings instantly with direct withdrawal</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-[#0B1A14] overflow-hidden shadow-2xl border border-emerald-900/50 sm:rounded-[2.5rem]">
                <div class="p-8 md:p-12">
                    <!-- Balance Context Card -->
                    <div class="bg-gradient-to-br from-[#0B1A14] to-emerald-900/30 rounded-3xl p-8 mb-10 text-white relative overflow-hidden border border-emerald-500/20 shadow-xl group">
                        <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                            <i class="fas fa-money-bill-transfer text-9xl"></i>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-500 mb-2">Available for Withdrawal</p>
                        <h3 class="text-5xl font-black tracking-tighter text-gold">₦{{ number_format($balance, 2) }}</h3>
                    </div>

                    <form id="withdrawForm" action="{{ route('savings.store.withdrawal') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <div class="flex items-center gap-5 mb-10 border-b border-emerald-900/30 pb-10">
                             <div class="w-16 h-16 rounded-[1.5rem] bg-red-900/20 border border-red-500/20 text-red-500 flex items-center justify-center text-3xl shadow-inner">
                                <i class="fas fa-hand-holding-dollar"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-white uppercase tracking-tight">Withdrawal Request</h3>
                                <p class="text-xs text-emerald-600/70 font-bold uppercase tracking-widest mt-1">Funds will be deducted from your savings ledger.</p>
                            </div>
                        </div>

                        <div class="space-y-8">
                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                    <i class="fas fa-naira-sign mr-3"></i>Amount to Withdraw
                                </label>
                                <div class="relative group">
                                    <div class="absolute left-7 top-1/2 -translate-y-1/2 text-emerald-600/70 font-black text-2xl transition-colors group-focus-within:text-gold">₦</div>
                                    <input id="amount" type="text" name="amount" value="{{ old('amount') }}" 
                                        inputmode="numeric"
                                        oninput="
                                            let val = this.value.replace(/[^0-9.]/g, '');
                                            if (val.split('.').length > 2) val = val.replace(/\.+$/, '');
                                            let parts = val.split('.');
                                            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                            this.value = parts.join('.');
                                        "
                                        onblur="
                                            let val = this.value.replace(/,/g, '');
                                            if (val && !isNaN(val)) {
                                                this.value = parseFloat(val).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                            }
                                        "
                                        class="w-full pl-16 pr-8 py-6 bg-[#0E211A] border border-emerald-900/50 rounded-3xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-black text-3xl tracking-tighter transition-all focus:outline-none placeholder-emerald-900/40" 
                                        placeholder="0,000.00" required>
                                </div>
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                    <i class="fas fa-comment-alt mr-3"></i>Reason / Notes (Optional)
                                </label>
                                <textarea name="notes" id="notes" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-emerald-100 font-medium resize-none shadow-inner focus:outline-none placeholder-emerald-900/40" rows="2" placeholder="Tell us more about this withdrawal..."></textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>

                            <!-- Bank Account Details Section -->
                            <div class="p-8 bg-[#0E211A] rounded-3xl border border-emerald-900/50 space-y-6 shadow-inner">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-university text-gold text-lg"></i>
                                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-white">Your Bank Details</h4>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Bank Name -->
                                    <div>
                                        <label for="bank_name" class="block text-[9px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Bank Name</label>
                                        <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}" 
                                            class="w-full px-5 py-4 bg-[#0B1A14] border border-emerald-900/30 rounded-xl focus:ring-2 focus:ring-gold/20 focus:border-gold/30 transition-all text-emerald-100 font-bold text-sm focus:outline-none" 
                                            placeholder="e.g. Access Bank" required>
                                        <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                                    </div>

                                    <!-- Account Number -->
                                    <div>
                                        <label for="account_number" class="block text-[9px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Account Number</label>
                                        <input type="text" name="account_number" id="account_number" value="{{ old('account_number') }}" 
                                            class="w-full px-5 py-4 bg-[#0B1A14] border border-emerald-900/30 rounded-xl focus:ring-2 focus:ring-gold/20 focus:border-gold/30 transition-all text-emerald-100 font-bold text-sm focus:outline-none" 
                                            placeholder="10-digit number" required maxlength="10">
                                        <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Account Name -->
                                <div>
                                    <label for="account_name" class="block text-[9px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Account Name</label>
                                    <input type="text" name="account_name" id="account_name" value="{{ old('account_name') }}" 
                                        class="w-full px-5 py-4 bg-[#0B1A14] border border-emerald-900/30 rounded-xl focus:ring-2 focus:ring-gold/20 focus:border-gold/30 transition-all text-emerald-100 font-bold text-sm focus:outline-none" 
                                        placeholder="Full name on account" required>
                                    <x-input-error :messages="$errors->get('account_name')" class="mt-2" />
                                </div>
                            </div>

                            <div class="p-6 bg-gold/5 border-l-4 border-gold rounded-r-2xl">
                                <p class="text-[10px] text-gold font-black uppercase tracking-widest leading-relaxed">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Manual Verification:</strong> Requests will be reviewed by admin. Accurate details prevent delays.
                                </p>
                            </div>

                            <div class="pt-6">
                                <button type="submit" 
                                    class="w-full bg-gradient-to-r from-red-600 to-red-800 hover:from-red-500 hover:to-red-700 text-white px-8 py-6 rounded-[2rem] font-black uppercase tracking-[0.25em] shadow-2xl shadow-red-900/50 hover:shadow-red-500/30 hover:-translate-y-1.5 transition-all flex items-center justify-center gap-4 active:scale-95 text-[11px]"
                                    onclick="return confirm('Confirm withdrawal request?')">
                                    <i class="fas fa-check-double mb-0.5"></i>
                                    {{ __('Confirm Withdrawal') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('withdrawForm').addEventListener('submit', function() {
            const amountInput = document.getElementById('amount');
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    </script>
</x-app-layout>
