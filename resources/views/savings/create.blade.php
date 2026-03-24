<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('savings.index') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-white leading-tight uppercase tracking-tight">
                    {{ __('Record Transaction') }}
                </h2>
                <p class="text-xs text-gold/60 font-bold uppercase tracking-widest mt-1">Manual ledger entry for member accounts</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0B1A14] overflow-hidden shadow-sm border border-emerald-900/50 sm:rounded-[2.5rem]">
                <div class="p-8 md:p-12">
                    <!-- Form Header -->
                    <div class="mb-10 border-b border-emerald-900/30 pb-8 flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-900/40 border border-emerald-800/50 text-emerald-400 flex items-center justify-center text-2xl shadow-inner">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">Transaction Details</h3>
                            <p class="text-[10px] text-emerald-600/70 font-black uppercase tracking-[0.2em]">Validated entries only · Ensure balanced ledger</p>
                        </div>
                    </div>

                    <form action="{{ route('savings.store') }}" method="POST" id="transactionForm" class="space-y-8">
                        @csrf
                        
                        <div class="space-y-6">
                            <!-- Member & Date Pair -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Member Selection -->
                                <div class="w-full">
                                    <label for="member_id" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">
                                        <i class="fas fa-user-circle mr-2"></i>Select Member
                                    </label>
                                    <div class="relative group">
                                        <select id="member_id" name="member_id" class="w-full pl-6 pr-12 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 transition-all text-emerald-100 font-bold appearance-none cursor-pointer" required>
                                            <option value="">Choose a member...</option>
                                            @foreach($members as $member)
                                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                                    {{ $member->full_name }} ({{ $member->account_number ?? 'N/A' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-emerald-900 transition-colors group-hover:text-gold">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                                </div>

                                <!-- Transaction Date -->
                                <div class="w-full">
                                    <label for="transaction_date" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">
                                        <i class="fas fa-calendar-alt mr-2"></i>Transaction Date
                                    </label>
                                    <input id="transaction_date" type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" 
                                        class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 transition-all text-emerald-100 font-bold focus:outline-none" required>
                                    <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Category & Type Pair -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Transaction Category -->
                                <div class="w-full">
                                    <label for="category" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">
                                        <i class="fas fa-tags mr-2"></i>Transaction Category
                                    </label>
                                    <div class="relative group">
                                        <select id="category" name="category" class="w-full pl-6 pr-12 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 transition-all text-emerald-100 font-bold appearance-none cursor-pointer" required>
                                            @foreach($categories as $category)
                                                <option value="{{ $category }}" {{ old('category', $selectedCategory ?? '') == $category ? 'selected' : '' }}>
                                                    {{ $category }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-emerald-900 group-hover:text-gold transition-colors">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>

                                <!-- Transaction Type -->
                                <div class="w-full">
                                    <label for="type" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">
                                        <i class="fas fa-exchange-alt mr-2"></i>Type of Transaction
                                    </label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="type" value="deposit" class="peer sr-only" {{ old('type', 'deposit') == 'deposit' ? 'checked' : '' }}>
                                            <div class="flex flex-col items-center justify-center px-4 py-3 bg-[#0E211A] border-2 border-transparent rounded-2xl peer-checked:border-emerald-500 peer-checked:bg-emerald-950/30 text-emerald-600/50 peer-checked:text-emerald-400 hover:bg-emerald-900/20 transition-all">
                                                <i class="fas fa-plus-circle mb-1 text-base opacity-40 group-hover:opacity-100 transition-opacity"></i>
                                                <span class="text-[9px] font-black uppercase tracking-widest">Deposit</span>
                                            </div>
                                        </label>

                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="type" value="withdrawal" class="peer sr-only" {{ old('type') == 'withdrawal' ? 'checked' : '' }}>
                                            <div class="flex flex-col items-center justify-center px-4 py-3 bg-[#0E211A] border-2 border-transparent rounded-2xl peer-checked:border-red-500 peer-checked:bg-red-950/30 text-red-600/50 peer-checked:text-red-400 hover:bg-red-900/20 transition-all">
                                                <i class="fas fa-minus-circle mb-1 text-base opacity-40 group-hover:opacity-100 transition-opacity"></i>
                                                <span class="text-[9px] font-black uppercase tracking-widest">Withdrawal</span>
                                            </div>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Amount & Reference Pair -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Amount -->
                                <div class="w-full">
                                    <label for="amount" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">
                                        <i class="fas fa-naira-sign mr-2"></i>Amount
                                    </label>
                                    <div class="relative group">
                                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-600/70 group-focus-within:text-gold transition-colors font-black text-2xl pointer-events-none">₦</div>
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
                                                let amountVal = this.value.replace(/,/g, '');
                                                if (amountVal && !isNaN(amountVal)) {
                                                    this.value = parseFloat(amountVal).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                                }
                                            "
                                            class="w-full pl-14 pr-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 transition-all text-emerald-400 font-black text-2xl tracking-tight focus:outline-none placeholder-emerald-900/50" 
                                            placeholder="0,000.00" required>
                                    </div>
                                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                </div>

                                <!-- Reference -->
                                <div class="w-full">
                                    <label for="reference" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">
                                        <i class="fas fa-fingerprint mr-2"></i>Reference / Slip No.
                                    </label>
                                    <div class="relative">
                                        <input id="reference" type="text" name="reference" value="{{ old('reference') }}" placeholder="e.g. TR-2024-001"
                                            class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 transition-all text-emerald-100 font-bold focus:outline-none placeholder-emerald-900/50">
                                    </div>
                                    <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="w-full">
                                <label for="notes" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">
                                    <i class="fas fa-comment-dots mr-2"></i>Notes / Description
                                </label>
                                <textarea id="notes" name="notes" rows="2" 
                                    class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 transition-all text-emerald-100 font-bold resize-none focus:outline-none placeholder-emerald-900/50" placeholder="Enter additional details about this transaction...">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>

                            <!-- Bank Details (Only for Withdrawal) -->
                            <div class="col-span-2 p-8 bg-[#0B1A14] rounded-3xl border border-emerald-900/50 relative overflow-hidden hidden" id="bank-details-section">
                                <span class="absolute left-0 top-0 w-1.5 h-full bg-red-600 opacity-50"></span>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-xl bg-red-500/10 text-red-500 flex items-center justify-center text-lg border border-red-500/20">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-white">Withdrawal Bank Details</h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-red-600/70 uppercase tracking-widest mb-2">Bank Name</label>
                                        <input type="text" name="bank_name" value="{{ old('bank_name') }}" class="w-full px-5 py-3 bg-[#0E211A] border border-emerald-900/50 rounded-xl text-sm font-bold text-emerald-100 focus:outline-none focus:border-red-500/50" placeholder="e.g. Zenith Bank">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-red-600/70 uppercase tracking-widest mb-2">Account Name</label>
                                        <input type="text" name="account_name" value="{{ old('account_name') }}" class="w-full px-5 py-3 bg-[#0E211A] border border-emerald-900/50 rounded-xl text-sm font-bold text-emerald-100 focus:outline-none focus:border-red-500/50" placeholder="Account Holder">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-red-600/70 uppercase tracking-widest mb-2">Account Number</label>
                                        <input type="text" name="account_number" value="{{ old('account_number', $selectedAccount ?? '') }}" class="w-full px-5 py-3 bg-[#0E211A] border border-emerald-900/50 rounded-xl text-sm font-bold text-emerald-100 focus:outline-none focus:border-red-500/50" placeholder="10 Digits" maxlength="10">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-10 border-t border-emerald-900/30">
                            <a href="{{ route('savings.index') }}" class="px-6 py-4 bg-transparent text-emerald-600/70 font-black text-[10px] uppercase tracking-widest rounded-2xl hover:text-emerald-400 transition-all flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                Cancel Entry
                            </a>
                            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-4 px-12 rounded-[2rem] shadow-xl shadow-emerald-900/30 hover:shadow-emerald-500/30 hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase tracking-widest text-[10px]">
                                <i class="fas fa-save"></i>
                                Record Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionForm = document.getElementById('transactionForm');
            const amountInput = document.getElementById('amount');
            const typeRadios = document.querySelectorAll('input[name="type"]');
            const bankDetailsSection = document.getElementById('bank-details-section');

            typeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'withdrawal') {
                        bankDetailsSection.classList.remove('hidden');
                    } else {
                        bankDetailsSection.classList.add('hidden');
                    }
                });
            });

            // Initial check
            const checkedType = document.querySelector('input[name="type"]:checked');
            if (checkedType && checkedType.value === 'withdrawal') {
                bankDetailsSection.classList.remove('hidden');
            }

            // Clean amount on submit
            transactionForm.addEventListener('submit', function() {
                amountInput.value = amountInput.value.replace(/,/g, '');
            });
        });
    </script>
</x-app-layout>
