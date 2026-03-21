<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('loans.create') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gold leading-tight tracking-tight uppercase">
                    {{ __('Purchase of Motorcycle') }}
                </h2>
                <p class="text-xs text-emerald-500/60 mt-1 font-bold uppercase tracking-widest">Submit request for commercial motorcycle purchase</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Info Card -->
            <div class="bg-blue-900/10 border-l-4 border-blue-500 p-8 rounded-r-[2rem] mb-10 shadow-2xl backdrop-blur-sm border-y border-r border-blue-500/10">
                <div class="flex items-start gap-6">
                    <div class="shrink-0 w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-400 border border-blue-500/20">
                        <i class="fas fa-info-circle text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-blue-400 text-sm mb-4 uppercase tracking-[0.2em]">Qualification Matrix</h3>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-3 text-[11px] text-blue-100/70 font-bold uppercase tracking-widest leading-relaxed">
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Membership: 1+ Years</li>
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> No active deductions</li>
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> 12 Months Tenure</li>
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-blue-500"></div> Net Salary Verification</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-[#0B1A14] overflow-hidden shadow-2xl border border-emerald-900/50 sm:rounded-[2.5rem]">
                <div class="p-8 md:p-12">
                    <form action="{{ route('loans.apply.store.motorcycle') }}" method="POST" class="space-y-10">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <!-- Brand -->
                            <div class="md:col-span-2">
                                <label for="brand" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">Motorcycle Brand / model</label>
                                <div class="relative group">
                                    <select id="brand" name="brand" class="w-full px-6 py-5 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[13px] font-black text-white transition-all cursor-pointer appearance-none uppercase tracking-widest" required>
                                        <option value="" class="bg-[#0B1A14]">Select Brand</option>
                                        @forelse($brands as $brand)
                                            <option value="{{ $brand->name }}" class="bg-[#0B1A14]">{{ $brand->name }} ({{ $brand->vendor->name ?? $brand->vendor ?? 'General' }})</option>
                                        @empty
                                            <option value="Jincheng" class="bg-[#0B1A14]">Jincheng (Standard)</option>
                                            <option value="Haojou" class="bg-[#0B1A14]">Haojou (Standard)</option>
                                            <option value="Abazat" class="bg-[#0B1A14]">Abazat (Standard)</option>
                                        @endforelse
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-emerald-700">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">Quantity Units</label>
                                <div class="relative group">
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-600/70 font-black text-xl">x</div>
                                    <input id="quantity" type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="5" 
                                        class="w-full pl-12 pr-6 py-5 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-black text-2xl tracking-tighter transition-all focus:outline-none" required>
                                </div>
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                             <!-- User Info (Display Only) -->
                             <div>
                                <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">Primary Applicant</label>
                                <div class="px-6 py-5 bg-emerald-900/20 rounded-2xl text-emerald-500/50 font-black text-xs uppercase tracking-widest cursor-not-allowed border border-emerald-900/30 shadow-inner">
                                    {{ Auth::user()->name }}
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-emerald-900/30 pt-10">
                            <h3 class="font-black text-lg text-white mb-8 flex items-center gap-4 uppercase tracking-tight">
                                <i class="fas fa-shield-alt text-gold text-xl"></i> Guarantors Allocation
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Guarantor 1 -->
                                <div class="space-y-6 p-8 bg-[#0E211A] rounded-[2rem] border border-emerald-900/50 shadow-inner group hover:border-emerald-500/30 transition-all">
                                    <h4 class="text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.3em] flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-600"></div> Guarantor Alpha
                                    </h4>
                                    <div class="space-y-4">
                                        <input type="text" name="guarantor_1_name" placeholder="FULL LEGAL NAME" class="w-full px-6 py-4 bg-[#0B1A14] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[11px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                                        <input type="text" name="guarantor_1_phone" placeholder="CONTACT NUMBER" class="w-full px-6 py-4 bg-[#0B1A14] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[11px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                                    </div>
                                </div>

                                <!-- Guarantor 2 -->
                                <div class="space-y-6 p-8 bg-[#0E211A] rounded-[2rem] border border-emerald-900/50 shadow-inner group hover:border-emerald-500/30 transition-all">
                                    <h4 class="text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.3em] flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-600"></div> Guarantor Bravo
                                    </h4>
                                    <div class="space-y-4">
                                        <input type="text" name="guarantor_2_name" placeholder="FULL LEGAL NAME" class="w-full px-6 py-4 bg-[#0B1A14] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[11px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                                        <input type="text" name="guarantor_2_phone" placeholder="CONTACT NUMBER" class="w-full px-6 py-4 bg-[#0B1A14] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[11px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-6 rounded-[2rem] shadow-2xl shadow-emerald-900/50 hover:shadow-emerald-500/30 hover:-translate-y-1.5 transition-all uppercase tracking-[0.25em] text-[11px] flex items-center justify-center gap-4 active:scale-95 group">
                                <span>Submit Professional Application</span>
                                <i class="fas fa-paper-plane group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
