<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('loans.apply.step1') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Apply for a Loan') }}
                </h2>
                <p class="text-sm text-emerald-500/60 mt-1">Provide information about your trusted guarantors.</p>
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
                    <!-- Step 2 (Active) -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.3)] ring-4 ring-[#0B1A14] ring-offset-0">
                            <i class="fas fa-users-cog text-xs"></i>
                        </div>
                        <span class="mt-3 text-[10px] font-black uppercase tracking-widest text-emerald-400">Guarantors</span>
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
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-white uppercase tracking-tight">Security & Trust</h3>
                            <p class="text-xs text-emerald-600/70 font-bold">Step 2 of 3: You are required to provide 2 reliable guarantors.</p>
                        </div>
                    </div>

                    <form action="{{ route('loans.apply.step2.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        
                        <div class="space-y-12">
                            <!-- Guarantor 1 Section -->
                            <div class="relative">
                                <span class="absolute -left-4 top-0 w-1 h-full bg-gold rounded-full opacity-30"></span>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-lg bg-[#0E211A] border border-emerald-900/50 text-emerald-500/70 flex items-center justify-center text-xs font-black">01</div>
                                    <h4 class="text-xs font-black text-white uppercase tracking-[0.2em]">First Guarantor Information</h4>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <label for="guarantor_1_name" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Legal Full Name</label>
                                        <input id="guarantor_1_name" type="text" name="guarantor_1_name" value="{{ old('guarantor_1_name', $guarantorsData['guarantor_1_name'] ?? '') }}" 
                                            class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 focus:outline-none" placeholder="Enter full name" required>
                                        <x-input-error :messages="$errors->get('guarantor_1_name')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="guarantor_1_relationship" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Relationship</label>
                                        <input id="guarantor_1_relationship" type="text" name="guarantor_1_relationship" value="{{ old('guarantor_1_relationship', $guarantorsData['guarantor_1_relationship'] ?? '') }}" 
                                            class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 focus:outline-none" placeholder="e.g. Brother, Colleague" required>
                                        <x-input-error :messages="$errors->get('guarantor_1_relationship')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="guarantor_1_phone" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Phone Number</label>
                                        <input id="guarantor_1_phone" type="text" name="guarantor_1_phone" value="{{ old('guarantor_1_phone', $guarantorsData['guarantor_1_phone'] ?? '') }}" 
                                            class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 focus:outline-none" placeholder="080 0000 0000" required>
                                        <x-input-error :messages="$errors->get('guarantor_1_phone')" class="mt-2" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="guarantor_1_member_id" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Member ID <span class="text-[9px] lowercase italic">(If applicable)</span></label>
                                        <input id="guarantor_1_member_id" type="text" name="guarantor_1_member_id" value="{{ old('guarantor_1_member_id', $guarantorsData['guarantor_1_member_id'] ?? '') }}" 
                                            class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 focus:outline-none" placeholder="Search by NUMCSU ID">
                                        <x-input-error :messages="$errors->get('guarantor_1_member_id')" class="mt-2" />
                                    </div>
                                    <div class="md:col-span-1">
                                        <label for="guarantor_1_passport" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Passport Photograph</label>
                                        <input id="guarantor_1_passport" type="file" name="guarantor_1_passport" accept="image/jpeg,image/png,image/jpg" required
                                            class="block w-full text-sm text-emerald-500/70 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-[#0E211A] file:text-emerald-400 file:border-emerald-900/50 hover:file:bg-[#0B1A14] hover:file:text-white cursor-pointer bg-[#0E211A] border border-emerald-900/50 rounded-2xl">
                                        <x-input-error :messages="$errors->get('guarantor_1_passport')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Guarantor 2 Section -->
                            <div class="relative pt-6">
                                <span class="absolute -left-4 top-6 w-1 h-full bg-gold rounded-full opacity-30"></span>
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-lg bg-[#0E211A] border border-emerald-900/50 text-emerald-500/70 flex items-center justify-center text-xs font-black">02</div>
                                    <h4 class="text-xs font-black text-white uppercase tracking-[0.2em]">Second Guarantor Information</h4>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <label for="guarantor_2_name" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Legal Full Name</label>
                                        <input id="guarantor_2_name" type="text" name="guarantor_2_name" value="{{ old('guarantor_2_name', $guarantorsData['guarantor_2_name'] ?? '') }}" 
                                        class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 focus:outline-none" placeholder="Enter full name" required>
                                        <x-input-error :messages="$errors->get('guarantor_2_name')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="guarantor_2_relationship" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Relationship</label>
                                        <input id="guarantor_2_relationship" type="text" name="guarantor_2_relationship" value="{{ old('guarantor_2_relationship', $guarantorsData['guarantor_2_relationship'] ?? '') }}" 
                                        class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 focus:outline-none" placeholder="e.g. Sister, Advisor" required>
                                        <x-input-error :messages="$errors->get('guarantor_2_relationship')" class="mt-2" />
                                    </div>
                                    <div>
                                        <label for="guarantor_2_phone" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Phone Number</label>
                                        <input id="guarantor_2_phone" type="text" name="guarantor_2_phone" value="{{ old('guarantor_2_phone', $guarantorsData['guarantor_2_phone'] ?? '') }}" 
                                        class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 focus:outline-none" placeholder="080 0000 0000" required>
                                        <x-input-error :messages="$errors->get('guarantor_2_phone')" class="mt-2" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="guarantor_2_member_id" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Member ID <span class="text-[9px] lowercase italic">(If applicable)</span></label>
                                        <input id="guarantor_2_member_id" type="text" name="guarantor_2_member_id" value="{{ old('guarantor_2_member_id', $guarantorsData['guarantor_2_member_id'] ?? '') }}" 
                                        class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all placeholder-emerald-700/50 focus:outline-none" placeholder="Search by NUMCSU ID">
                                        <x-input-error :messages="$errors->get('guarantor_2_member_id')" class="mt-2" />
                                    </div>
                                    <div class="md:col-span-1">
                                        <label for="guarantor_2_passport" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Passport Photograph</label>
                                        <input id="guarantor_2_passport" type="file" name="guarantor_2_passport" accept="image/jpeg,image/png,image/jpg" required
                                            class="block w-full text-sm text-emerald-500/70 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-[#0E211A] file:text-emerald-400 file:border-emerald-900/50 hover:file:bg-[#0B1A14] hover:file:text-white cursor-pointer bg-[#0E211A] border border-emerald-900/50 rounded-2xl">
                                        <x-input-error :messages="$errors->get('guarantor_2_passport')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-10 flex flex-col md:flex-row items-center justify-between gap-6 border-t border-emerald-900/30">
                            <a href="{{ route('loans.apply.step1') }}" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-4 bg-[#0B1A14] border border-emerald-900/50 text-emerald-600/70 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-900/30 hover:text-emerald-400 transition-all">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to structural details
                            </a>
                            <button type="submit" class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 px-12 rounded-2xl transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 uppercase tracking-widest text-xs group">
                                {{ __('Proceed to Documentation') }}
                                <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-8 text-center bg-gold/5 p-4 rounded-xl border border-gold/10">
                <p class="text-[10px] text-gold font-black uppercase tracking-wider leading-relaxed">
                    <i class="fas fa-info-circle mr-1"></i> Note: Your guarantors will be contacted for verification purposes.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
