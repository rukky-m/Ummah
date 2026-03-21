<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('contributions.index') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gold leading-tight tracking-tight uppercase">
                    {{ __('Make Contribution') }}
                </h2>
                <p class="text-xs text-emerald-500/60 mt-1 font-bold uppercase tracking-widest">Submit monthly mandatory cooperative contribution</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#0B1A14] overflow-hidden shadow-2xl border border-emerald-900/50 sm:rounded-[2.5rem]">
                <div class="p-8 md:p-12">
                    <form id="contributionForm" action="{{ route('contributions.store.deposit') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <div class="bg-gold/5 border-l-4 border-gold p-6 rounded-r-2xl mb-10 shadow-inner">
                            <h4 class="text-gold font-black uppercase tracking-[0.2em] text-[10px] mb-2 flex items-center gap-2">
                                <i class="fas fa-bullhorn text-xs"></i> Important Notice
                            </h4>
                            <p class="text-xs text-emerald-100/90 font-bold leading-relaxed italic uppercase tracking-wider">
                                Mandatory monthly contribution is ₦2,000. Larger amounts increase your capital and loan eligibility.
                            </p>
                        </div>

                        <div class="space-y-8">
                            <!-- Amount -->
                            <div>
                                <label for="amount" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                    <i class="fas fa-naira-sign mr-3"></i>Contribution Amount (₦)
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
                                        placeholder="2,000.00" required>
                                </div>
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <!-- Payment Proof -->
                            <div class="relative group">
                                <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                    <i class="fas fa-paperclip mr-3"></i>Payment Proof (Receipt)
                                </label>
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
                                <x-input-error :messages="$errors->get('payment_proof')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">
                                    <i class="fas fa-comment-alt mr-3"></i>Additional Note (Optional)
                                </label>
                                <textarea name="notes" id="notes" rows="2" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-emerald-100 font-medium resize-none shadow-inner focus:outline-none placeholder-emerald-900/40" placeholder="E.g. Contribution for January 2026"></textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" 
                                class="w-full bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white px-8 py-6 rounded-[2rem] font-black uppercase tracking-[0.25em] shadow-2xl shadow-emerald-900/50 hover:shadow-emerald-500/30 hover:-translate-y-1.5 transition-all flex items-center justify-center gap-4 active:scale-95 text-[11px]">
                                <i class="fas fa-paper-plane"></i>
                                {{ __('Submit Contribution') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0] ? input.files[0].name : 'Click to upload receipt';
            document.getElementById('file-name').textContent = fileName;
        }

        document.getElementById('contributionForm').addEventListener('submit', function() {
            const amountInput = document.getElementById('amount');
            amountInput.value = amountInput.value.replace(/,/g, '');
        });
    </script>
</x-app-layout>
