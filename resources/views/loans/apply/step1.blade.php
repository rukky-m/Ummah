<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('loans.create') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Apply for a Loan') }}
                </h2>
                <p class="text-sm text-emerald-500/60 mt-1">Start your financial journey with our simplified application.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Modern Stepper -->
            <div class="mb-12 relative">
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-emerald-900/30 -translate-y-1/2 z-0"></div>
                <div class="relative z-10 flex justify-between items-center px-4 md:px-12">
                    <!-- Step 1 (Active) -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.3)] ring-4 ring-[#0B1A14] ring-offset-0">
                            <i class="fas fa-file-invoice text-xs"></i>
                        </div>
                        <span class="mt-3 text-[10px] font-black uppercase tracking-widest text-emerald-400">Details</span>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 text-emerald-600/50 flex items-center justify-center shadow-sm ring-4 ring-transparent ring-offset-0">
                            <i class="fas fa-users-cog text-xs"></i>
                        </div>
                        <span class="mt-3 text-[10px] font-black uppercase tracking-widest text-emerald-600/50">Guarantors</span>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 text-emerald-600/50 flex items-center justify-center shadow-sm ring-4 ring-transparent ring-offset-0">
                            <i class="fas fa-cloud-upload-alt text-xs"></i>
                        </div>
                        <span class="mt-3 text-[10px] font-black uppercase tracking-widest text-emerald-600/50">Documents</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#0B1A14] overflow-hidden shadow-sm border border-emerald-900/50 sm:rounded-3xl">
                <div class="p-8 md:p-12">
                    <div class="flex items-center gap-4 mb-10 border-b border-emerald-900/30 pb-8">
                        <div class="w-14 h-14 rounded-2xl bg-gold/10 border border-gold/20 text-gold flex items-center justify-center text-2xl shadow-inner">
                            <i class="fas fa-hand-holding-dollar"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">Loan Structure</h3>
                            <p class="text-xs text-emerald-600/70 font-bold">Step 1 of 3: Define your loan requirements.</p>
                        </div>
                    </div>

                    <form action="{{ route('loans.apply.step1.store') }}" method="POST" id="loanForm" class="space-y-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Loan Amount -->
                            <div class="md:col-span-2">
                                <label for="amount" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">Principal Amount Requested</label>
                                <div class="relative group">
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-600/70 group-focus-within:text-gold transition-colors font-black text-3xl">₦</div>
                                    <input id="amount" type="text" name="amount" value="{{ old('amount', isset($loanData['amount']) ? number_format($loanData['amount'], 2) : '') }}" 
                                        inputmode="numeric"
                                        oninput="
                                            let val = this.value.replace(/[^0-9.]/g, '');
                                            if (val.split('.').length > 2) val = val.replace(/\.+$/, '');
                                            let parts = val.split('.');
                                            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                            this.value = parts.join('.');
                                        "
                                        class="w-full pl-16 pr-8 py-6 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-emerald-400 font-black text-4xl tracking-tighter transition-all focus:outline-none placeholder-emerald-900/50" 
                                        placeholder="0,000.00" required>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] bg-emerald-900/20 border border-emerald-900/50 px-2 py-1 rounded text-emerald-500/70 font-black tracking-widest uppercase">Min: ₦20k</span>
                                        <span class="text-[10px] bg-emerald-900/20 border border-emerald-900/50 px-2 py-1 rounded text-emerald-500/70 font-black tracking-widest uppercase">Max: ₦3M</span>
                                    </div>
                                    <x-input-error :messages="$errors->get('amount')" class="mt-0" />
                                </div>
                            </div>

                            <!-- Purpose -->
                            <div>
                                <label for="purpose" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">Primary Purpose</label>
                                <select id="purpose" name="purpose" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all cursor-pointer">
                                    <option value="">Select category</option>
                                    @foreach(['Emergency', 'Sallah Ram', 'Essential Commodity', 'Asset', 'School Fee', 'Agriculture Tool', 'Medical Fee', 'Purchase of House', 'Other'] as $purpose)
                                        <option value="{{ $purpose }}" {{ old('purpose', $loanData['purpose'] ?? '') == $purpose ? 'selected' : '' }}>{{ $purpose }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration_months" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">Repayment Window</label>
                                <select id="duration_months" name="duration_months" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all cursor-pointer">
                                    <!-- Options populated by JavaScript -->
                                </select>
                                <x-input-error :messages="$errors->get('duration_months')" class="mt-2" />
                            </div>

                            <!-- Other Purpose -->
                            <div id="otherPurposeDiv" class="md:col-span-2 hidden">
                                <label for="other_purpose" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">Describe specific reason</label>
                                <textarea id="other_purpose" name="other_purpose" rows="2" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all resize-none focus:outline-none placeholder-emerald-700/50" placeholder="Provide more context about your loan request...">{{ old('other_purpose', $loanData['other_purpose'] ?? '') }}</textarea>
                                <x-input-error :messages="$errors->get('other_purpose')" class="mt-2" />
                            </div>

                            <!-- Repayment Frequency -->
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">Repayment Frequency</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="relative flex items-center gap-3 p-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl cursor-pointer hover:bg-emerald-900/20 transition-all border-2 border-transparent has-[:checked]:border-gold has-[:checked]:bg-[#0B1A14] group">
                                        <input type="radio" name="repayment_frequency" value="monthly" class="peer sr-only" {{ old('repayment_frequency', $loanData['repayment_frequency'] ?? 'monthly') == 'monthly' ? 'checked' : '' }}>
                                        <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-600/70 group-hover:text-gold transition-colors shadow-sm">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div>
                                            <span class="block text-xs font-black text-white uppercase tracking-widest">Monthly</span>
                                            <span class="text-[10px] text-emerald-500/60 font-bold italic">Pay every month</span>
                                        </div>
                                    </label>
                                    <label class="relative flex items-center gap-3 p-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl cursor-pointer hover:bg-emerald-900/20 transition-all border-2 border-transparent has-[:checked]:border-gold has-[:checked]:bg-[#0B1A14] group">
                                        <input type="radio" name="repayment_frequency" value="quarterly" class="peer sr-only" {{ old('repayment_frequency', $loanData['repayment_frequency'] ?? '') == 'quarterly' ? 'checked' : '' }}>
                                        <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-600/70 group-hover:text-gold transition-colors shadow-sm">
                                            <i class="fas fa-calendar-minus"></i>
                                        </div>
                                        <div>
                                            <span class="block text-xs font-black text-white uppercase tracking-widest">Quarterly</span>
                                            <span class="text-[10px] text-emerald-500/60 font-bold italic">Pay every 3 months</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Details for Disbursement -->
                        <div class="bg-[#0E211A] p-6 sm:p-8 rounded-3xl border border-emerald-900/50 relative overflow-hidden mt-8">
                            <span class="absolute -left-4 top-0 w-1 h-full bg-gold rounded-full opacity-30"></span>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 text-gold flex items-center justify-center text-lg shadow-sm">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Disbursement Account</h4>
                                    <p class="text-[10px] text-emerald-500/60 font-bold italic mt-0.5">Where should we send the funds?</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="bank_name" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Bank Name</label>
                                    <input id="bank_name" type="text" name="bank_name" value="{{ old('bank_name', $loanData['bank_name'] ?? '') }}" 
                                        class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 shadow-sm focus:outline-none" placeholder="e.g. Access Bank" required>
                                    <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="account_number" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Account Number</label>
                                    <input id="account_number" type="text" name="account_number" value="{{ old('account_number', $loanData['account_number'] ?? '') }}" 
                                        class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 shadow-sm focus:outline-none" placeholder="0123456789" required maxlength="10">
                                    <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                                </div>
                                <div class="sm:col-span-2 md:col-span-1">
                                    <label for="account_name" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Account Name</label>
                                    <input id="account_name" type="text" name="account_name" value="{{ old('account_name', $loanData['account_name'] ?? '') }}" 
                                        class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 shadow-sm focus:outline-none" placeholder="Your full name" required>
                                    <x-input-error :messages="$errors->get('account_name')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Summary Calculation Card -->
                        <div class="mt-12 bg-gradient-to-br from-[#0B1A14] to-emerald-900/30 border border-emerald-500/30 p-8 rounded-[2rem] shadow-[0_0_25px_rgba(16,185,129,0.2)] text-white relative overflow-hidden">
                            <div class="absolute -right-6 -bottom-6 opacity-[0.05]">
                                <i class="fas fa-calculator text-[120px]"></i>
                            </div>
                            
                            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                                <div>
                                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.3em] mb-2">Estimated Commitment</p>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-xs font-bold text-gold">₦</span>
                                        <span id="estimatedPayment" class="text-4xl md:text-5xl font-black tracking-tighter">0.00</span>
                                        <span class="text-xs font-black text-emerald-500 uppercase" id="paymentPeriod">/ MONTH</span>
                                    </div>
                                    <p class="text-[10px] text-emerald-500/80 mt-2 font-bold italic" id="interestRateLabel">Calculated at 6.0% flat interest rate</p>
                                </div>
                                <div class="shrink-0 w-full md:w-auto">
                                    <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-gold to-yellow-600 hover:from-yellow-600 hover:to-gold text-white font-black py-4 px-10 rounded-2xl transition-all shadow-[0_0_15px_rgba(234,179,8,0.3)] hover:shadow-[0_0_25px_rgba(234,179,8,0.5)] hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 uppercase tracking-widest text-xs group">
                                        {{ __('Confirm Details') }}
                                        <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('loans.create') }}" class="text-[10px] font-black text-emerald-600/70 hover:text-emerald-400 uppercase tracking-[0.2em] transition-colors">Abort Application</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amount');
            const durationSelect = document.getElementById('duration_months');
            const frequencyRadios = document.querySelectorAll('input[name="repayment_frequency"]');
            const purposeSelect = document.getElementById('purpose');
            const otherPurposeDiv = document.getElementById('otherPurposeDiv');
            const estimatedPaymentSpan = document.getElementById('estimatedPayment');
            const paymentPeriodSpan = document.getElementById('paymentPeriod');
            const interestRateLabel = document.getElementById('interestRateLabel');

            let currentDuration = "{{ old('duration_months', $loanData['duration_months'] ?? '') }}";

            function updateDurationOptions() {
                const purpose = purposeSelect.value;
                let options = [];

                if (purpose === 'Emergency') {
                    options = [{ value: 3, label: '3 Months Tenure' }];
                } else if (purpose === 'Sallah Ram') {
                    options = [{ value: 6, label: '6 Months Tenure' }];
                } else if (purpose === 'Essential Commodity') {
                    options = [{ value: 3, label: '3 Months Tenure' }];
                } else {
                    options = [
                        { value: 6, label: '6 Months Tenure' },
                        { value: 12, label: '12 Months Tenure' },
                        { value: 18, label: '18 Months Tenure' }
                    ];
                }

                durationSelect.innerHTML = '';
                options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt.value;
                    option.textContent = opt.label;
                    if (currentDuration == opt.value) {
                        option.selected = true;
                    }
                    durationSelect.appendChild(option);
                });

                calculatePayment();
            }

            function calculatePayment() {
                const amount = parseFloat(amountInput.value.replace(/,/g, '')) || 0;
                const duration = parseInt(durationSelect.value) || 0;
                let frequency = 'monthly';
                
                frequencyRadios.forEach(radio => {
                    if (radio.checked) frequency = radio.value;
                });

                const purpose = purposeSelect.value;
                let interestRate = 0.10; // Default 10%
                if (purpose === 'Emergency' || purpose === 'Essential Commodity') {
                    interestRate = 0.06; // 6%
                }
                
                if (interestRateLabel) {
                    interestRateLabel.textContent = `Calculated at ${(interestRate * 100).toFixed(1)}% flat interest rate`;
                }

                const totalRepayment = amount * (1 + interestRate);
                let numberOfPayments = duration;

                if (frequency === 'monthly') {
                    numberOfPayments = duration;
                    paymentPeriodSpan.textContent = '/ MONTH';
                } else {
                    numberOfPayments = duration / 3;
                    paymentPeriodSpan.textContent = '/ QUARTER';
                }

                if (numberOfPayments > 0 && amount > 10) {
                    const payment = totalRepayment / numberOfPayments;
                    estimatedPaymentSpan.textContent = payment.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                } else {
                    estimatedPaymentSpan.textContent = '0.00';
                }
            }

            document.getElementById('loanForm').addEventListener('submit', function() {
                amountInput.value = amountInput.value.replace(/,/g, '');
            });

            function toggleOtherPurpose() {
                if (purposeSelect.value === 'Other') {
                    otherPurposeDiv.classList.remove('hidden');
                } else {
                    otherPurposeDiv.classList.add('hidden');
                }
            }

            amountInput.addEventListener('input', calculatePayment);
            amountInput.addEventListener('blur', function() {
                let val = this.value.replace(/,/g, '');
                if (val && !isNaN(val)) {
                    this.value = parseFloat(val).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }
            });
            durationSelect.addEventListener('change', function() {
                currentDuration = durationSelect.value;
                calculatePayment();
            });
            frequencyRadios.forEach(radio => radio.addEventListener('change', calculatePayment));
            purposeSelect.addEventListener('change', function() {
                updateDurationOptions();
                toggleOtherPurpose();
            });

            // Initial calls
            updateDurationOptions();
            toggleOtherPurpose();
        });
    </script>
</x-app-layout>
