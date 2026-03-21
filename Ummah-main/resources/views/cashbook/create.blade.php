<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('cashbook.index') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gold leading-tight tracking-tight uppercase">
                    {{ isset($isEdit) ? __('Edit Transaction') : __('Record Transaction') }}
                </h2>
                <p class="text-xs text-emerald-500/60 mt-1 font-bold uppercase tracking-widest">
                    {{ isset($isEdit) ? 'Modify an existing transaction record.' : 'Record a new financial inflow or outflow.' }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#0B1A14] overflow-hidden shadow-2xl border border-emerald-900/50 sm:rounded-[2.5rem]">
                <div class="p-8 md:p-12">
                    <form id="cashbookForm" action="{{ isset($isEdit) ? route('cashbook.update', $transaction) : route('cashbook.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          class="space-y-10">
                        @csrf
                        @if(isset($isEdit))
                            @method('PATCH')
                        @endif

                        <!-- Transaction Type Toggle -->
                        <div class="flex justify-center">
                            <div class="bg-emerald-950/20 p-1.5 rounded-2xl inline-flex relative border border-emerald-900/50 shadow-inner">
                                <input type="radio" name="type" value="income" id="type_income" class="peer/income hidden" {{ (old('type', $transaction->type ?? 'income') == 'income') ? 'checked' : '' }} onchange="updateCategories()">
                                <label for="type_income" class="px-8 py-3 rounded-xl cursor-pointer text-emerald-800 peer-checked/income:bg-emerald-600 peer-checked/income:text-white peer-checked/income:shadow-lg transition-all duration-300 font-black uppercase tracking-widest text-[10px] flex items-center gap-2">
                                    <i class="fas fa-arrow-down text-xs"></i> Income
                                </label>

                                <input type="radio" name="type" value="expense" id="type_expense" class="peer/expense hidden" {{ (old('type', $transaction->type ?? '') == 'expense') ? 'checked' : '' }} onchange="updateCategories()">
                                <label for="type_expense" class="px-8 py-3 rounded-xl cursor-pointer text-emerald-800 peer-checked/expense:bg-red-600 peer-checked/expense:text-white peer-checked/expense:shadow-lg transition-all duration-300 font-black uppercase tracking-widest text-[10px] flex items-center gap-2">
                                    <i class="fas fa-arrow-up text-xs"></i> Expense
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <!-- Date -->
                            <div class="space-y-4">
                                <label for="transaction_date" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em]">
                                    <i class="fas fa-calendar-day mr-3 text-gold"></i>Transaction Date
                                </label>
                                <input type="date" name="transaction_date" id="transaction_date" required
                                    class="w-full bg-[#0E211A] border border-emerald-900/50 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-bold text-sm focus:outline-none transition-all"
                                    value="{{ old('transaction_date', isset($transaction) ? $transaction->transaction_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
                                <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                            </div>

                            <!-- Amount -->
                            <div class="space-y-4">
                                <label for="amount" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em]">
                                    <i class="fas fa-naira-sign mr-3 text-gold"></i>Amount (₦)
                                </label>
                                <div class="relative group">
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-600/70 font-black text-xl transition-colors group-focus-within:text-gold">₦</div>
                                    <input id="amount" type="text" name="amount" value="{{ old('amount', isset($transaction) ? number_format($transaction->amount, 2, '.', ',') : '') }}" 
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
                                        class="w-full pl-14 pr-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-black text-2xl tracking-tight transition-all focus:outline-none placeholder-emerald-900/40" 
                                        placeholder="0,000.00" required>
                                </div>
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <!-- Category -->
                            <div class="space-y-4">
                                <label for="category" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em]">
                                    <i class="fas fa-tags mr-3 text-gold"></i>Category
                                </label>
                                <select name="category" id="category" required
                                    class="w-full bg-[#0E211A] border border-emerald-900/50 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-bold text-sm focus:outline-none transition-all appearance-none cursor-pointer">
                                    <!-- Populated by JS -->
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>

                            <!-- Payment Method -->
                            <div class="space-y-4">
                                <label for="payment_method" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em]">
                                    <i class="fas fa-credit-card mr-3 text-gold"></i>Payment Method
                                </label>
                                <select name="payment_method" id="payment_method" required
                                    class="w-full bg-[#0E211A] border border-emerald-900/50 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-bold text-sm focus:outline-none transition-all appearance-none cursor-pointer">
                                    <option value="Cash" {{ old('payment_method', $transaction->payment_method ?? '') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Bank Transfer" {{ old('payment_method', $transaction->payment_method ?? '') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="POS" {{ old('payment_method', $transaction->payment_method ?? '') == 'POS' ? 'selected' : '' }}>POS</option>
                                    <option value="Check" {{ old('payment_method', $transaction->payment_method ?? '') == 'Check' ? 'selected' : '' }}>Check</option>
                                </select>
                                <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Reference Number -->
                        <div class="space-y-4">
                            <label for="reference_number" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em]">
                                <i class="fas fa-barcode mr-3 text-gold"></i>Reference / Invoice Number <span class="text-emerald-900 font-bold lowercase tracking-normal">(Optional)</span>
                            </label>
                            <input type="text" name="reference_number" id="reference_number"
                                class="w-full bg-[#0E211A] border border-emerald-900/50 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-bold text-sm focus:outline-none transition-all placeholder-emerald-900/40"
                                value="{{ old('reference_number', $transaction->reference_number ?? '') }}" placeholder="e.g. INV-001 or TRF-123456">
                            <x-input-error :messages="$errors->get('reference_number')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="space-y-4">
                            <label for="description" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em]">
                                <i class="fas fa-comment-dots mr-3 text-gold"></i>Description <span class="text-emerald-900 font-bold lowercase tracking-normal">(Optional)</span>
                            </label>
                            <textarea name="description" id="description" rows="2"
                                class="w-full bg-[#0E211A] border border-emerald-900/50 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-emerald-100 font-medium text-sm focus:outline-none transition-all placeholder-emerald-900/40 resize-none shadow-inner" placeholder="Additional details about this transaction...">{{ old('description', $transaction->description ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Attachment -->
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em]">
                                <i class="fas fa-paperclip mr-3 text-gold"></i>Supporting Document / receipt
                            </label>
                            @if(isset($transaction) && $transaction->attachment_path)
                                <div class="p-4 bg-emerald-900/20 border border-emerald-500/20 rounded-2xl flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-800/40 flex items-center justify-center text-emerald-400 border border-emerald-700/30">
                                            <i class="fas fa-file-invoice"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-white uppercase tracking-wider">Current Attachment</p>
                                            <p class="text-[10px] text-emerald-600/70 font-bold uppercase tracking-widest">Already uploaded</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($transaction->attachment_path) }}" target="_blank" class="text-[10px] font-black text-gold hover:text-white transition-colors uppercase tracking-widest border-b border-gold/30 hover:border-white/50 pb-0.5">View File</a>
                                </div>
                            @endif
                            
                            <div class="relative group">
                                <input id="attachment" name="attachment" type="file" class="peer sr-only" accept="image/*,application/pdf" onchange="showFileName(this)" />
                                <label for="attachment" class="flex flex-col items-center justify-center w-full h-40 bg-[#0E211A] border-2 border-dashed border-emerald-900/50 rounded-[2rem] cursor-pointer hover:bg-emerald-950/20 hover:border-gold/50 transition-all duration-500">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <div class="w-14 h-14 rounded-2xl bg-emerald-900/40 border border-emerald-800/50 flex items-center justify-center text-emerald-400 mb-4 group-hover:scale-110 group-hover:text-gold transition-all duration-500 shadow-inner">
                                            <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                        </div>
                                        <p class="mb-2 text-sm text-white font-black uppercase tracking-wider" id="attachment-text">Click to upload document</p>
                                        <p class="text-[10px] text-emerald-600/70 font-bold uppercase tracking-widest">PNG, JPG, PDF (MAX. 2MB)</p>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between gap-6 pt-10 border-t border-emerald-900/30 mt-10">
                            <a href="{{ route('cashbook.index') }}" class="inline-flex items-center px-8 py-5 bg-emerald-950/30 text-emerald-600 font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl hover:bg-emerald-900/50 hover:text-emerald-400 border border-emerald-900/50 transition-all active:scale-95 shadow-inner">
                                <i class="fas fa-arrow-left mr-3"></i>
                                Cancel
                            </a>
                            <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-5 px-10 rounded-2xl shadow-2xl shadow-emerald-900/50 hover:shadow-emerald-500/40 transition-all active:scale-95 flex items-center justify-center gap-4 uppercase tracking-[0.25em] text-[11px]">
                                <i class="fas fa-save mb-0.5"></i>
                                {{ isset($isEdit) ? 'Update' : 'Save' }} Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const categoryOptions = {
            income: [
                'Membership Due',
                'Donation',
                'Grant',
                'Loan Repayment',
                'Investment Return',
                'Other Income'
            ],
            expense: [
                'Utility Bill',
                'Maintenance',
                'Salary',
                'Loan Disbursement',
                'Office Supplies',
                'Event Cost',
                'Other Expense'
            ]
        };

        function updateCategories() {
            const checkedRadio = document.querySelector('input[name="type"]:checked');
            if (!checkedRadio) return; 

            const type = checkedRadio.value;
            const select = document.getElementById('category');
            const selectedValue = "{{ old('category', $transaction->category ?? '') }}";
            
            select.innerHTML = '';
            
            categoryOptions[type].forEach(cat => {
                const option = document.createElement('option');
                option.value = cat;
                option.textContent = cat;
                if (cat === selectedValue) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
        }
        
        function showFileName(input) {
            const fileNameElement = document.getElementById('attachment-text');
            if (input.files && input.files[0]) {
                fileNameElement.textContent = input.files[0].name;
                fileNameElement.classList.add('text-gold');
            } else {
                fileNameElement.textContent = 'Click to upload document';
                fileNameElement.classList.remove('text-gold');
            }
        }

        document.getElementById('cashbookForm').addEventListener('submit', function() {
            const amountInput = document.getElementById('amount');
            amountInput.value = amountInput.value.replace(/,/g, '');
        });

        // Initialize on load
        document.addEventListener('DOMContentLoaded', updateCategories);
    </script>
</x-app-layout>
