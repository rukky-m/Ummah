<x-guest-layout>
    <div class="py-16 text-center animate-fade-in">
        <div class="flex justify-center mb-8 relative">
            <div class="w-24 h-24 bg-gradient-to-br from-army-green to-green-900 rounded-2xl flex items-center justify-center shadow-xl shadow-green-900/20 rotate-3 animate-pulse">
                <i class="fas fa-check text-white text-4xl"></i>
            </div>
            <div class="absolute -right-2 top-0 w-8 h-8 bg-gold rounded-full flex items-center justify-center shadow-lg animate-bounce">
                <i class="fas fa-star text-white text-[10px]"></i>
            </div>
        </div>

        <h2 class="text-4xl font-black text-army-green dark:text-gold mb-3 tracking-tighter uppercase">Registration Received!</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-10 max-w-sm mx-auto font-medium">Welcome to the future of cooperative wealth. Your application has been logged safely in our mainframe.</p>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700 inline-block text-left w-full max-w-md mx-auto mb-10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:scale-110 transition-transform">
                <i class="fas fa-id-card text-6xl"></i>
            </div>
            
            <div class="space-y-6 relative z-10">
                <div class="flex justify-between items-center border-b border-gray-50 dark:border-gray-700 pb-4">
                    <span class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Application ID</span>
                    <span class="text-sm font-black text-army-green font-mono">{{ $member->application_ref }}</span>
                </div>
                
                <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700 pb-4">
                    <span class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Account Holder</span>
                    <span class="text-sm font-black text-gray-800 dark:text-white">{{ $member->full_name }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Entry Date</span>
                    <span class="text-sm font-black text-gray-800 dark:text-white">{{ $member->created_at->format('d M, Y') }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-6 max-w-md mx-auto mb-12">
            <h4 class="font-black text-gold border-b border-gold/20 pb-4 text-[11px] uppercase tracking-[0.3em]">Lifecycle of Your Application</h4>
            
            <div class="flex gap-6 text-left items-start">
                <div class="w-10 h-10 rounded-full bg-army-green/10 text-army-green flex items-center justify-center font-black text-sm shrink-0">1</div>
                <div>
                    <p class="font-black text-sm text-gray-800 dark:text-white mb-1 uppercase tracking-tight">Vetting Process</p>
                    <p class="text-xs text-gray-500 font-medium">Our administrators are verifying your identity and documents. This usually takes 12-24 hours.</p>
                </div>
            </div>

            <div class="flex gap-6 text-left items-start">
                <div class="w-10 h-10 rounded-full bg-army-green/10 text-army-green flex items-center justify-center font-black text-sm shrink-0">2</div>
                <div>
                    <p class="font-black text-sm text-gray-800 dark:text-white mb-1 uppercase tracking-tight">Confirmation Alert</p>
                    <p class="text-xs text-gray-500 font-medium">You will receive an automated email notification once your account is fully activated.</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="/" class="px-8 py-4 bg-gray-50 text-gray-400 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-gray-100 hover:text-gray-600 border border-gray-100 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-home"></i>
                Return Home
            </a>
            <a href="{{ route('login') }}" class="px-10 py-4 bg-gradient-to-r from-army-green to-green-900 hover:from-green-900 hover:to-army-green text-white font-black text-[10px] uppercase tracking-widest rounded-xl shadow-xl shadow-green-900/20 transition-all active:scale-95 flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i>
                Login to Portal
            </a>
        </div>
    </div>
</x-guest-layout>
