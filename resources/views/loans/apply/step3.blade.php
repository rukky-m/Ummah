<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('loans.apply.step2') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Apply for a Loan') }}
                </h2>
                <p class="text-sm text-emerald-500/60 mt-1">Finalize your application by providing supporting documents.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Modern Stepper -->
            <div class="mb-12 relative">
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-emerald-900/30 -translate-y-1/2 z-0"></div>
                <div class="relative z-10 flex justify-between items-center px-4 md:px-12">
                    <!-- Step 1 (Completed) -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shadow-sm border border-emerald-500/30">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <span class="mt-3 text-[10px] font-black uppercase tracking-widest text-emerald-500/70">Details</span>
                    </div>
                    <!-- Step 2 (Completed) -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center shadow-sm border border-emerald-500/30">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <span class="mt-3 text-[10px] font-black uppercase tracking-widest text-emerald-500/70">Guarantors</span>
                    </div>
                    <!-- Step 3 (Active) -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.3)] ring-4 ring-[#0B1A14] ring-offset-0">
                            <i class="fas fa-cloud-upload-alt text-xs"></i>
                        </div>
                        <span class="mt-3 text-[10px] font-black uppercase tracking-widest text-emerald-400">Documents</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#0B1A14] overflow-hidden shadow-sm border border-emerald-900/50 sm:rounded-3xl">
                <div class="p-8 md:p-12">
                    <div class="flex items-center gap-4 mb-10 border-b border-emerald-900/30 pb-8">
                        <div class="w-14 h-14 rounded-2xl bg-gold/10 border border-gold/20 text-gold flex items-center justify-center text-2xl shadow-inner">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">Documentation</h3>
                            <p class="text-xs text-emerald-600/70 font-bold">Step 3 of 3: Verification and Narration.</p>
                        </div>
                    </div>

                    <form action="{{ route('loans.apply.step3.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        
                        <!-- Upload Grid -->
                        <div class="space-y-6">
                            <h4 class="text-xs font-black text-white uppercase tracking-[0.2em] mb-4">Select Required Documents</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Business Plan -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-1">Business Plan <span class="text-[9px] lowercase italic">(If applicable)</span></label>
                                    <div class="relative group">
                                        <input type="file" name="business_plan" id="business_plan" class="peer sr-only" onchange="updateFileLabel(this)">
                                        <label for="business_plan" class="flex items-center gap-3 p-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl cursor-pointer hover:bg-emerald-900/20 hover:border-gold/50 hover:shadow-[0_0_10px_rgba(234,179,8,0.1)] transition-all">
                                            <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-600/70 group-hover:text-gold transition-colors shadow-sm">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <span class="text-xs font-bold text-emerald-500/70 truncate" id="label-business_plan">Choose file...</span>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('business_plan')" class="mt-2" />
                                </div>

                                <!-- Bank Statement -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-1">Bank Statement <span class="text-[9px] lowercase italic">(Last 3 months)</span></label>
                                    <div class="relative group">
                                        <input type="file" name="bank_statement" id="bank_statement" class="peer sr-only" onchange="updateFileLabel(this)">
                                        <label for="bank_statement" class="flex items-center gap-3 p-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl cursor-pointer hover:bg-emerald-900/20 hover:border-gold/50 hover:shadow-[0_0_10px_rgba(234,179,8,0.1)] transition-all">
                                            <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-600/70 group-hover:text-gold transition-colors shadow-sm">
                                                <i class="fas fa-university"></i>
                                            </div>
                                            <span class="text-xs font-bold text-emerald-500/70 truncate" id="label-bank_statement">Choose file...</span>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('bank_statement')" class="mt-2" />
                                </div>

                                <!-- Proof of Income -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-1">Proof of Income</label>
                                    <div class="relative group">
                                        <input type="file" name="proof_of_income" id="proof_of_income" class="peer sr-only" onchange="updateFileLabel(this)">
                                        <label for="proof_of_income" class="flex items-center gap-3 p-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl cursor-pointer hover:bg-emerald-900/20 hover:border-gold/50 hover:shadow-[0_0_10px_rgba(234,179,8,0.1)] transition-all">
                                            <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-600/70 group-hover:text-gold transition-colors shadow-sm">
                                                <i class="fas fa-receipt"></i>
                                            </div>
                                            <span class="text-xs font-bold text-emerald-500/70 truncate" id="label-proof_of_income">Choose file...</span>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('proof_of_income')" class="mt-2" />
                                </div>

                                <!-- Collateral -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-1">Collateral Docs <span class="text-[9px] lowercase italic">(Optional)</span></label>
                                    <div class="relative group">
                                        <input type="file" name="collateral_docs" id="collateral_docs" class="peer sr-only" onchange="updateFileLabel(this)">
                                        <label for="collateral_docs" class="flex items-center gap-3 p-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl cursor-pointer hover:bg-emerald-900/20 hover:border-gold/50 hover:shadow-[0_0_10px_rgba(234,179,8,0.1)] transition-all">
                                            <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-600/70 group-hover:text-gold transition-colors shadow-sm">
                                                <i class="fas fa-home"></i>
                                            </div>
                                            <span class="text-xs font-bold text-emerald-500/70 truncate" id="label-collateral_docs">Choose file...</span>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('collateral_docs')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Narration -->
                        <div class="pt-6 relative">
                            <span class="absolute -left-4 top-6 w-1 h-full bg-gold rounded-full opacity-30"></span>
                            <div class="flex items-center justify-between mb-4">
                                <label for="narration" class="text-xs font-black text-white uppercase tracking-[0.2em]">Application Narrative</label>
                                <span class="bg-[#0E211A] border border-emerald-900/50 px-2 py-0.5 rounded text-[9px] font-black text-emerald-600/70 uppercase tracking-widest" id="charCount">0 characters</span>
                            </div>
                            <textarea id="narration" name="narration" rows="5" class="w-full px-6 py-5 bg-[#0E211A] border border-emerald-900/50 rounded-3xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-medium text-emerald-100 transition-all resize-none shadow-inner placeholder-emerald-700/50 focus:outline-none" placeholder="Provide a detailed explanation of how these funds will be used..." required>{{ old('narration') }}</textarea>
                            <x-input-error :messages="$errors->get('narration')" class="mt-2" />
                        </div>

                        <div class="pt-10 flex flex-col md:flex-row items-center justify-between gap-6 px-4 pb-4">
                            <a href="{{ route('loans.apply.step2') }}" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-4 bg-[#0B1A14] text-emerald-600/70 border border-emerald-900/50 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-900/30 hover:text-emerald-400 transition-all">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to guarantors
                            </a>
                            <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-gold to-yellow-600 hover:from-yellow-600 hover:to-gold text-white font-black py-5 px-16 rounded-2xl transition-all shadow-[0_0_15px_rgba(234,179,8,0.3)] hover:shadow-[0_0_25px_rgba(234,179,8,0.5)] hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 uppercase tracking-[0.3em] text-xs">
                                <i class="fas fa-paper-plane mr-1 text-[10px]"></i>
                                {{ __('Submit Final Application') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function updateFileLabel(input) {
            const fileName = input.files[0] ? input.files[0].name : 'Choose file...';
            document.getElementById('label-' + input.id).textContent = fileName;
            document.getElementById('label-' + input.id).classList.remove('text-emerald-500/70');
            document.getElementById('label-' + input.id).classList.add('text-emerald-400');
        }

        document.getElementById('narration').addEventListener('input', function() {
            document.getElementById('charCount').textContent = this.value.length + ' characters';
        });
    </script>
</x-app-layout>
