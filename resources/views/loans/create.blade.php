<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('loans.index') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Manual Loan Application') }}
                </h2>
                <p class="text-sm text-emerald-500/60 mt-1">Record a loan application on behalf of a member.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0B1A14] overflow-hidden shadow-sm border border-emerald-900/50 sm:rounded-3xl">
                <div class="p-8 md:p-12">
                    <div class="flex items-center gap-4 mb-10 border-b border-emerald-900/30 pb-8">
                        <div class="w-14 h-14 rounded-2xl bg-gold/10 border border-gold/20 text-gold flex items-center justify-center text-2xl shadow-inner">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">Staff Terminal</h3>
                            <p class="text-xs text-emerald-600/70 font-bold">Manual loan entry for organizational record keeping.</p>
                        </div>
                    </div>

                    <form action="{{ route('loans.store') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Member Selection -->
                            <div class="md:col-span-2">
                                <label for="member_id" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-3">Target Member Account</label>
                                <div class="relative">
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-gold font-black pointer-events-none">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <select id="member_id" name="member_id" class="w-full pl-14 pr-8 py-5 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-sm font-bold text-emerald-100 placeholder-emerald-700/50 transition-all cursor-pointer appearance-none" required>
                                        <option value="">Search and select member</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                                {{ $member->full_name }} ({{ $member->account_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 text-emerald-600/70 pointer-events-none">
                                        <i class="fas fa-search text-xs"></i>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                            </div>

                            <!-- Loan Amount -->
                            <div>
                                <label for="amount" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-3">Loan Principal (₦)</label>
                                <div class="relative group">
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-600/70 font-black transition-colors group-focus-within:text-gold">₦</div>
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
                                        class="w-full pl-12 pr-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-lg font-black text-emerald-400 placeholder-emerald-700/50 transition-all focus:outline-none" placeholder="0,000.00" required>
                                </div>
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration_months" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-3">Duration (Months)</label>
                                <div class="relative">
                                    <input id="duration_months" type="number" name="duration_months" value="{{ old('duration_months', 12) }}" 
                                        class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none" required>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-emerald-600/70 uppercase">Tenure</div>
                                </div>
                                <x-input-error :messages="$errors->get('duration_months')" class="mt-2" />
                            </div>

                            <!-- Interest Rate -->
                            <div>
                                <label for="interest_rate" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-3">Interest Rate (%)</label>
                                <div class="relative">
                                    <input id="interest_rate" type="number" step="0.01" name="interest_rate" value="{{ old('interest_rate', 6) }}" 
                                        class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none" required>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 text-emerald-500 font-black">
                                        <i class="fas fa-percentage text-xs"></i>
                                    </div>
                                </div>
                                <p class="mt-2 text-[9px] text-emerald-600/70 font-bold uppercase tracking-wider">Default rate: 6% (10% for Essential Commodity)</p>
                                <x-input-error :messages="$errors->get('interest_rate')" class="mt-2" />
                            </div>

                            <!-- Frequency -->
                            <div>
                                <label for="repayment_frequency" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-3">Repayment Frequency</label>
                                <select id="repayment_frequency" name="repayment_frequency" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-sm font-bold text-emerald-100 transition-all cursor-pointer">
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                </select>
                            </div>

                            <!-- Purpose -->
                            <div class="md:col-span-2">
                                <label for="purpose" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-3">Basis / Purpose of Loan</label>
                                <textarea id="purpose" name="purpose" rows="3" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-3xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-sm font-medium text-emerald-100 placeholder-emerald-700/50 transition-all resize-none shadow-inner focus:outline-none" placeholder="Detailed reason for this loan request...">{{ old('purpose') }}</textarea>
                                <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                            </div>
                        </div>

                        <div class="pt-6 flex items-center justify-end gap-6 border-t border-emerald-900/30">
                            <a href="{{ route('loans.index') }}" class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70 hover:text-emerald-400 transition-all">Discard Application</a>
                            <button type="submit" class="bg-emerald-600 text-white font-black py-4 px-10 rounded-2xl transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] hover:bg-emerald-500 hover:-translate-y-1 flex items-center justify-center gap-3 uppercase tracking-widest text-xs active:scale-95">
                                Submit Record <i class="fas fa-file-medical text-[10px]"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const amountInput = document.getElementById('amount');
            
            form.addEventListener('submit', function() {
                amountInput.value = amountInput.value.replace(/,/g, '');
            });
        });
    </script>
</x-app-layout>
