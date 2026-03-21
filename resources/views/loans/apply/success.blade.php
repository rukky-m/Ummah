<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight">
            {{ __('Application Result') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-transparent min-h-screen flex items-center">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#0E211A] overflow-hidden shadow-[0_0_30px_rgba(16,185,129,0.1)] border border-emerald-900/50 sm:rounded-[3rem] text-center">
                <div class="p-12">
                    
                    <!-- Celebratory Icon -->
                    <div class="flex justify-center mb-10">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gold/20 rounded-full blur-2xl scale-150 animate-pulse"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-br from-emerald-600 to-emerald-900 rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(16,185,129,0.4)]">
                                <i class="fas fa-check text-4xl text-gold"></i>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-3xl font-black text-white uppercase tracking-tighter mb-2">Success!</h3>
                    <p class="text-xs text-emerald-500/70 font-bold uppercase tracking-widest mb-10">Your application has been logged.</p>

                    <!-- Receipt Style Card -->
                    <div class="bg-gradient-to-br from-[#0B1A14] to-emerald-900/20 rounded-[2.5rem] p-8 border border-emerald-900/50 relative mb-10 overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-[0.05]">
                            <i class="fas fa-file-contract text-6xl text-white"></i>
                        </div>
                        
                        <div class="space-y-6 relative z-10">
                            <div class="flex justify-between items-center border-b border-emerald-900/50 border-dashed pb-4">
                                <span class="text-[10px] font-black text-emerald-600/70 uppercase tracking-widest">Reference No</span>
                                <span class="text-xs font-black text-emerald-400">{{ strtoupper(substr(md5($loan->id), 0, 8)) }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-emerald-600/70 uppercase tracking-widest">Amount</span>
                                <span class="text-xl font-black text-white tracking-tight">₦{{ number_format($loan->amount, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-emerald-600/70 uppercase tracking-widest">Purpose</span>
                                <span class="text-xs font-bold text-emerald-100">{{ $loan->purpose }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center border-t border-emerald-900/50 border-dashed pt-4">
                                <span class="text-[10px] font-black text-emerald-600/70 uppercase tracking-widest">Date Logged</span>
                                <span class="text-xs font-bold text-emerald-100">{{ $loan->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="space-y-6 mb-10">
                        <h4 class="text-[10px] font-black text-gold uppercase tracking-[0.3em] flex items-center justify-center gap-2">
                             Protocol Pipeline
                        </h4>
                        <div class="grid grid-cols-1 gap-3 max-w-sm mx-auto">
                            <div class="flex items-start gap-4 p-4 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl text-left shadow-sm hover:border-emerald-500/50 hover:bg-emerald-900/20 transition-all">
                                <div class="w-8 h-8 rounded-lg bg-emerald-900/30 text-emerald-400 flex items-center justify-center shrink-0">
                                    <i class="fas fa-shield-check text-sm"></i>
                                </div>
                                <div>
                                    <h5 class="text-[10px] font-black text-white uppercase tracking-widest">Verification</h5>
                                    <p class="text-[10px] text-emerald-500/70 font-medium leading-relaxed">Our committee will verify your documents and guarantors.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl text-left shadow-sm hover:border-gold/30 hover:bg-gold/5 transition-all">
                                <div class="w-8 h-8 rounded-lg bg-gold/10 text-gold flex items-center justify-center shrink-0">
                                    <i class="fas fa-bell text-sm"></i>
                                </div>
                                <div>
                                    <h5 class="text-[10px] font-black text-white uppercase tracking-widest">Notification</h5>
                                    <p class="text-[10px] text-emerald-500/70 font-medium leading-relaxed">You will receive an update within 3-5 working days.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                        <a href="{{ route('dashboard') }}" class="w-full bg-emerald-600 text-white font-black py-5 rounded-2xl transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] hover:-translate-y-1 flex items-center justify-center gap-3 uppercase tracking-[0.3em] text-xs">
                            Return to Dashboard
                        </a>
                        <button class="text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] hover:text-emerald-400 transition-colors">
                            <i class="fas fa-download mr-1"></i> Download Confirmation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
