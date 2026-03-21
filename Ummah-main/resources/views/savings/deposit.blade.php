<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gold leading-tight tracking-tight uppercase">
                    {{ __('Savings & Contributions') }}
                </h2>
                <p class="text-xs text-emerald-500/60 mt-1 font-bold uppercase tracking-widest">Deposit funds or submit contribution proofs</p>
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
                            How to Deposit
                        </h3>
                        
                        <div class="space-y-8 relative">
                            <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-emerald-900/20"></div>
                            
                            <!-- Step 1 -->
                            <div class="relative flex gap-5">
                                <div class="w-6 h-6 rounded-full bg-gold text-[#0B1A14] text-[10px] font-black flex items-center justify-center shrink-0 z-10 shadow-[0_0_10px_rgba(255,215,0,0.3)]">1</div>
                                <div>
                                    <h4 class="text-[10px] font-black text-white uppercase tracking-[0.2em] mb-2">Make Transfer</h4>
                                    <p class="text-xs text-emerald-600/70 leading-relaxed font-medium">Transfer the desired amount to our official bank account.</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="relative flex gap-5">
                                <div class="w-6 h-6 rounded-full bg-gold text-[#0B1A14] text-[10px] font-black flex items-center justify-center shrink-0 z-10 shadow-[0_0_10px_rgba(255,215,0,0.3)]">2</div>
                                <div>
                                    <h4 class="text-[10px] font-black text-white uppercase tracking-[0.2em] mb-2">Upload Receipt</h4>
                                    <p class="text-xs text-emerald-600/70 leading-relaxed font-medium">Capture or save your transaction receipt/slip.</p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="relative flex gap-5">
                                <div class="w-6 h-6 rounded-full bg-gold text-[#0B1A14] text-[10px] font-black flex items-center justify-center shrink-0 z-10 shadow-[0_0_10px_rgba(255,215,0,0.3)]">3</div>
                                <div>
                                    <h4 class="text-[10px] font-black text-white uppercase tracking-[0.2em] mb-2">Verification</h4>
                                    <p class="text-xs text-emerald-600/70 leading-relaxed font-medium">Wait for admin to verify and approve your deposit.</p>
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
                            <form id="depositForm" action="{{ route('savings.store.deposit') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                                @csrf
                                
                                <div class="flex items-center gap-5 mb-10 border-b border-emerald-900/30 pb-10">
                                     <div class="w-16 h-16 rounded-[1.5rem] bg-emerald-900/40 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-3xl shadow-inner">
                                        <i class="fas fa-piggy-bank"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-white uppercase tracking-tight">Submit Deposit Proof</h3>
                                        <p class="text-xs text-emerald-600/70 font-bold uppercase tracking-widest mt-1">Select category and provide proof of payment.</p>
                                    </div>
                                </div>

                                <div class="space-y-8">
                                    <!-- Deposit Type -->
                                    <div>
                                        <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                                            <i class="fas fa-list text-gold"></i>
                                            @if(request('category')) Transaction Type @else Deposit Category @endif
                                        </label>

                                        @if(request('category'))
                                            <div class="p-6 bg-[#0E211A] border border-emerald-900/50 rounded-2xl flex items-center justify-between">
                                                <div class="flex items-center gap-4">
                                                    @if(request('category') == 'Contribution')
                                                        <div class="w-12 h-12 rounded-xl bg-emerald-900/40 text-emerald-400 flex items-center justify-center border border-emerald-800/30">
                                                            <i class="fas fa-hand-holding-heart"></i>
                                                        </div>
                                                        <div>
                                                            <p class="font-black text-sm text-white uppercase tracking-wide">Contribution</p>
                                                            <p class="text-[10px] text-emerald-600/70 font-bold uppercase tracking-widest">Monthly mandatory saving</p>
                                                        </div>
                                                    @else
                                                        <div class="w-12 h-12 rounded-xl bg-gold/10 text-gold flex items-center justify-center border border-gold/20">
                                                            <i class="fas fa-piggy-bank"></i>
                                                        </div>
                                                        <div>
                                                            <p class="font-black text-sm text-white uppercase tracking-wide">Personal Savings</p>
                                                            <p class="text-[10px] text-emerald-600/70 font-bold uppercase tracking-widest">Voluntary additional saving</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <a href="{{ route('savings.deposit') }}" class="text-[10px] font-black text-emerald-600 hover:text-gold transition-colors uppercase tracking-[0.2em] border-b border-emerald-600/30 hover:border-gold/50">Change</a>
                                                <input type="hidden" name="category" value="{{ request('category') }}">
                                            </div>
                                        @else
                                            <div class="grid grid-cols-2 gap-6">
                                                <label class="relative flex items-center justify-center p-6 bg-[#0E211A] border border-emerald-900/50 rounded-2xl cursor-pointer hover:bg-emerald-950/20 hover:border-emerald-500/30 transition-all group has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-900/20 shadow-inner">
                                                    <input type="radio" name="category" value="Contribution" class="sr-only" {{ request('category', 'Contribution') == 'Contribution' ? 'checked' : '' }}>
                                                    <div class="text-center">
                                                        <i class="fas fa-hand-holding-heart text-emerald-900 group-hover:text-emerald-400 group-has-[:checked]:text-emerald-400 mb-2 block text-xl transition-colors"></i>
                                                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-800 group-hover:text-emerald-100 group-has-[:checked]:text-white transition-colors">Contribution</span>
                                                    </div>
                                                </label>
                                                <label class="relative flex items-center justify-center p-6 bg-[#0E211A] border border-emerald-900/50 rounded-2xl cursor-pointer hover:bg-emerald-950/20 hover:border-gold/30 transition-all group has-[:checked]:border-gold/50 has-[:checked]:bg-gold/5 shadow-inner">
                                                    <input type="radio" name="category" value="Personal Savings" class="sr-only" {{ request('category') == 'Personal Savings' ? 'checked' : '' }}>
                                                    <div class="text-center">
                                                        <i class="fas fa-piggy-bank text-emerald-900 group-hover:text-gold group-has-[:checked]:text-gold mb-2 block text-xl transition-colors"></i>
                                                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-800 group-hover:text-emerald-100 group-has-[:checked]:text-white transition-colors">Personal Savings</span>
                                                    </div>
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Amount -->
                                    <div>
                                        <label for="amount" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                            <i class="fas fa-naira-sign mr-3"></i>Amount Transferred
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
                                                class="w-full pl-16 pr-8 py-6 bg-[#0E211A] border border-emerald-900/50 rounded-3xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-black text-3xl tracking-tighter transition-all focus:outline-none placeholder-emerald-900/40" placeholder="0,000.00" required>
                                        </div>
                                        <p class="mt-3 text-[10px] text-emerald-600/60 font-black uppercase tracking-[0.2em]">Minimum amount: ₦100.00</p>
                                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                    </div>

                                    <!-- Payment Proof -->
                                    <div>
                                        <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                            <i class="fas fa-paperclip mr-3"></i>Payment Proof (Receipt)
                                        </label>
                                        <div class="relative group">
                                            <input type="file" name="payment_proof" id="payment_proof" class="peer sr-only" accept="image/*,application/pdf" required onchange="updateFileName(this)">
                                            <label for="payment_proof" class="flex flex-col items-center justify-center w-full h-48 bg-[#0E211A] border-2 border-dashed border-emerald-900/50 rounded-[2rem] cursor-pointer hover:bg-emerald-950/20 hover:border-gold/50 transition-all">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <div class="w-14 h-14 rounded-2xl bg-emerald-900/40 border border-emerald-800/50 flex items-center justify-center text-emerald-400 mb-4 group-hover:scale-110 group-hover:text-gold transition-all duration-500">
                                                        <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                                    </div>
                                                    <p class="mb-2 text-sm text-white font-black uppercase tracking-wider" id="file-name">Click to upload receipt</p>
                                                    <p class="text-[10px] text-emerald-600/70 font-bold uppercase tracking-widest">Image or PDF (Max 2MB)</p>
                                                </div>
                                            </label>
                                        </div>
                                        <x-input-error :messages="$errors->get('payment_proof')" class="mt-2" />
                                    </div>
                                    
                                    <!-- Notes -->
                                    <div>
                                        <label for="notes" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                            <i class="fas fa-comment-alt mr-3"></i>Notes (Optional)
                                        </label>
                                        <textarea name="notes" id="notes" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-emerald-100 font-medium resize-none shadow-inner focus:outline-none placeholder-emerald-900/40" rows="2" placeholder="Tell us more about this deposit..."></textarea>
                                    </div>

                                    <div class="pt-6">
                                        <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white px-8 py-6 rounded-[2rem] font-black uppercase tracking-[0.25em] shadow-2xl shadow-emerald-900/50 hover:shadow-emerald-500/30 hover:-translate-y-1.5 transition-all flex items-center justify-center gap-4 active:scale-95 text-[11px]">
                                            <i class="fas fa-paper-plane"></i>
                                            {{ __('Submit for Approval') }}
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
            const fileName = input.files[0] ? input.files[0].name : 'Click to upload receipt';
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

        document.getElementById('depositForm').addEventListener('submit', function() {
            const amountInput = document.getElementById('amount');
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    </script>
</x-app-layout>
