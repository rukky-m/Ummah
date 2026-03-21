<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('loans.index') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gold leading-tight tracking-tight uppercase">
                    {{ __('Loan Repayment') }}
                </h2>
                <p class="text-xs text-emerald-500/60 mt-1 font-bold uppercase tracking-widest">Submit monthly repayment proof for verification</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Instruction Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-[#0B1A14] p-8 rounded-[2rem] border border-emerald-900/50 shadow-sm">
                        <h3 class="font-black text-white text-sm mb-8 flex items-center gap-3 uppercase tracking-widest">
                            <i class="fas fa-info-circle text-gold"></i>
                            Repayment Guide
                        </h3>
                        
                        <div class="space-y-8 relative">
                            <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-emerald-900/20"></div>
                            
                            <!-- Step 1 -->
                            <div class="relative flex gap-5">
                                <div class="w-6 h-6 rounded-full bg-gold text-[#0B1A14] text-[10px] font-black flex items-center justify-center shrink-0 z-10 shadow-[0_0_10px_rgba(255,215,0,0.3)]">1</div>
                                <div>
                                    <h4 class="text-[10px] font-black text-white uppercase tracking-[0.2em] mb-2">Select Loan</h4>
                                    <p class="text-xs text-emerald-600/70 leading-relaxed font-medium">Choose the specific loan application you are repaying for.</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="relative flex gap-5">
                                <div class="w-6 h-6 rounded-full bg-gold text-[#0B1A14] text-[10px] font-black flex items-center justify-center shrink-0 z-10 shadow-[0_0_10px_rgba(255,215,0,0.3)]">2</div>
                                <div>
                                    <h4 class="text-[10px] font-black text-white uppercase tracking-[0.2em] mb-2">Make Payment</h4>
                                    <p class="text-xs text-emerald-600/70 leading-relaxed font-medium">Transfer the monthly amount to our official bank account below.</p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="relative flex gap-5">
                                <div class="w-6 h-6 rounded-full bg-gold text-[#0B1A14] text-[10px] font-black flex items-center justify-center shrink-0 z-10 shadow-[0_0_10px_rgba(255,215,0,0.3)]">3</div>
                                <div>
                                    <h4 class="text-[10px] font-black text-white uppercase tracking-[0.2em] mb-2">Upload Proof</h4>
                                    <p class="text-xs text-emerald-600/70 leading-relaxed font-medium">Upload a clear screenshot or photo of your transfer receipt.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Details Card -->
                    <div class="bg-gradient-to-br from-[#0B1A14] to-emerald-900/30 rounded-[2rem] p-8 shadow-2xl border border-emerald-500/20 text-white relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                            <i class="fas fa-building-columns text-8xl"></i>
                        </div>
                        <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-gold mb-6">Official Bank Account</h4>
                        <div class="space-y-6">
                            <div>
                                <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-1">Bank Name</p>
                                <p class="text-lg font-black tracking-tight text-white/90">Access Bank PLC</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-1">Account Name</p>
                                <p class="text-sm font-black tracking-tight text-white/90 leading-tight">NSUK UMMAH MULTIPURPOSE COOPERATIVE SOCIETY LIMITED</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-1">Account Number</p>
                                <div class="flex items-center gap-3">
                                    <p class="text-3xl font-black text-gold tracking-tighter" id="account-number">1444477940</p>
                                    <button type="button" 
                                            onclick="copyToClipboard('1444477940', this)" 
                                            class="w-10 h-10 rounded-xl bg-white/5 hover:bg-gold/10 hover:text-gold border border-white/10 hover:border-gold/30 transition-all flex items-center justify-center group/copy relative active:scale-90" 
                                            title="Copy">
                                        <i class="fas fa-copy"></i>
                                        <span class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gold text-[#0B1A14] text-[10px] font-black px-3 py-1.5 rounded-lg opacity-0 pointer-events-none transition-opacity group-focus/copy:opacity-100 uppercase tracking-widest shadow-lg">COPIED!</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Area -->
                <div class="lg:col-span-2">
                    <div class="bg-[#0B1A14] overflow-hidden shadow-2xl border border-emerald-900/50 sm:rounded-[2.5rem]">
                        <div class="p-8 md:p-12">
                            <form id="repaymentForm" action="{{ route('repayments.store.user') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                                @csrf
                                
                                <div class="flex items-center gap-5 mb-10 border-b border-emerald-900/30 pb-10">
                                     <div class="w-16 h-16 rounded-[1.5rem] bg-emerald-900/40 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-3xl shadow-inner">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-white uppercase tracking-tight">Submit Repayment Proof</h3>
                                        <p class="text-xs text-emerald-600/70 font-bold uppercase tracking-widest mt-1">Validated entries will be reconciled within 24 hours.</p>
                                    </div>
                                </div>

                                <div class="space-y-8">
                                    <!-- Loan Selection -->
                                    <div x-data="{ 
                                        amount: '{{ (old('loan_id', $selectedLoanId) && $loans->find(old('loan_id', $selectedLoanId))) ? number_format($loans->find(old('loan_id', $selectedLoanId))->monthlyRepaymentAmount(), 2, '.', '') : '' }}' 
                                    }" @loan-selected.window="
                                        let rawAmount = parseFloat($event.detail.amount);
                                        amount = rawAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                    ">
                                        <div class="mb-8">
                                            <label for="loan_id" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                                <i class="fas fa-file-invoice mr-3"></i>Target Loan Account
                                            </label>
                                            <div class="relative group">
                                                <select name="loan_id" id="loan_id" class="w-full pl-6 pr-12 py-5 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 transition-all text-emerald-100 font-bold text-sm appearance-none cursor-pointer" required @change="$dispatch('loan-selected', { amount: $el.options[$el.selectedIndex].dataset.monthly })">
                                                    <option value="" disabled {{ !old('loan_id', $selectedLoanId) ? 'selected' : '' }}>Choose an active loan...</option>
                                                    @foreach($loans as $loan)
                                                        <option value="{{ $loan->id }}" 
                                                                data-monthly="{{ $loan->monthlyRepaymentAmount() }}"
                                                                {{ (old('loan_id', $selectedLoanId) == $loan->id) ? 'selected' : '' }}>
                                                            {{ $loan->application_number }} - ₦{{ number_format($loan->amount, 0) }} ({{ $loan->purpose }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-emerald-900 group-hover:text-gold transition-colors">
                                                    <i class="fas fa-chevron-down text-xs"></i>
                                                </div>
                                            </div>
                                            <x-input-error :messages="$errors->get('loan_id')" class="mt-2" />
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                            <!-- Month -->
                                            <div>
                                                <label for="month" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">
                                                    <i class="fas fa-calendar mr-2"></i>Repayment Month
                                                </label>
                                                <div class="relative group">
                                                    <select name="month" id="month" class="w-full pl-6 pr-12 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 transition-all text-emerald-100 font-bold text-sm appearance-none cursor-pointer" required>
                                                        @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                                                            <option value="{{ $m }}" {{ now()->format('F') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 text-emerald-900 group-hover:text-gold transition-colors">
                                                        <i class="fas fa-chevron-down text-xs"></i>
                                                    </div>
                                                </div>
                                                <x-input-error :messages="$errors->get('month')" class="mt-2" />
                                            </div>

                                            <!-- Year -->
                                            <div>
                                                <label for="year" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">
                                                    <i class="fas fa-calendar-alt mr-2"></i>Year
                                                </label>
                                                <div class="relative group">
                                                    <select name="year" id="year" class="w-full pl-6 pr-12 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 transition-all text-emerald-100 font-bold text-sm appearance-none cursor-pointer" required>
                                                        <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                                                        <option value="{{ now()->year - 1 }}">{{ now()->year - 1 }}</option>
                                                    </select>
                                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 text-emerald-900 group-hover:text-gold transition-colors">
                                                        <i class="fas fa-chevron-down text-xs"></i>
                                                    </div>
                                                </div>
                                                <x-input-error :messages="$errors->get('year')" class="mt-2" />
                                            </div>
                                        </div>

                                        <!-- Amount -->
                                        <div class="mb-8">
                                            <label for="amount" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                                <i class="fas fa-naira-sign mr-3"></i>Repayment Amount Paid
                                            </label>
                                            <div class="relative group">
                                                <div class="absolute left-7 top-1/2 -translate-y-1/2 text-emerald-600/70 font-black text-2xl transition-colors group-focus-within:text-gold">₦</div>
                                                <input id="amount" type="text" name="amount" x-model="amount" 
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
                                            <p class="mt-3 text-[10px] text-emerald-600/60 font-black uppercase tracking-[0.2em] italic">Enter exact amount from your transfer receipt.</p>
                                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                        </div>
                                    </div>

                                    <!-- Proof Upload -->
                                    <div class="mb-10">
                                        <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                            <i class="fas fa-paperclip mr-3"></i>Repayment Proof (Receipt)
                                        </label>
                                        <div class="relative group">
                                            <input type="file" name="proof_image" id="proof_image" class="peer sr-only" accept="image/*,application/pdf" required onchange="updateFileName(this)">
                                            <label for="proof_image" class="flex flex-col items-center justify-center w-full h-48 bg-[#0E211A] border-2 border-dashed border-emerald-900/50 rounded-3xl cursor-pointer hover:bg-emerald-950/20 hover:border-gold/50 transition-all">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <div class="w-14 h-14 rounded-2xl bg-emerald-900/40 border border-emerald-800/50 flex items-center justify-center text-emerald-400 mb-4 group-hover:scale-110 group-hover:text-gold transition-all duration-500">
                                                        <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                                    </div>
                                                    <p class="mb-2 text-sm text-white font-black uppercase tracking-wider" id="file-name">Click to upload receipt</p>
                                                    <p class="text-[10px] text-emerald-600/70 font-bold uppercase tracking-widest">Image or PDF (Max 2MB)</p>
                                                </div>
                                            </label>
                                        </div>
                                        <x-input-error :messages="$errors->get('proof_image')" class="mt-2" />
                                    </div>

                                    <div class="pt-6">
                                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white px-8 py-6 rounded-[2rem] font-black uppercase tracking-[0.25em] shadow-2xl shadow-emerald-900/50 hover:shadow-emerald-500/30 hover:-translate-y-1.5 transition-all flex items-center justify-center gap-4 active:scale-95 text-[11px]">
                                            <i class="fas fa-paper-plane"></i>
                                            {{ __('Submit Repayment Proof') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0] ? input.files[0].name : 'Click to upload transfer receipt';
            document.getElementById('file-name').textContent = fileName;
        }

        function copyToClipboard(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                btn.focus();
                setTimeout(() => {
                    btn.blur();
                }, 2000);
            });
        }

        document.getElementById('repaymentForm').addEventListener('submit', function() {
            const amountInput = document.getElementById('amount');
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    </script>
</x-app-layout>
