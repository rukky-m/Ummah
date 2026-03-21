<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/70 dark:bg-gray-900/40 backdrop-blur-2xl overflow-hidden shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] sm:rounded-[2.5rem] border border-gray-100 dark:border-white/10">
                <div class="p-12 text-center">
                    <div class="w-24 h-24 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-8 animate-pulse-slow">
                        <i class="fas fa-user-clock text-4xl text-emerald-600 dark:text-emerald-500"></i>
                    </div>
                    
                    <h2 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight mb-4">
                        {{ $status }}
                    </h2>
                    
                    <p class="text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed font-medium">
                        {{ $message }}
                    </p>

                    @if(isset($application_ref))
                        <div class="inline-flex items-center gap-3 px-6 py-3 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/10 mb-10">
                            <span class="text-xs font-black uppercase tracking-widest text-gray-400">Application Ref:</span>
                            <span class="text-sm font-black text-emerald-600 dark:text-emerald-500">{{ $application_ref }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center justify-center gap-4">
                        @if($status === 'No Profile')
                            <a href="{{ route('complete-profile.step1') }}" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 px-8 rounded-2xl shadow-xl shadow-emerald-500/20 transition-all active:scale-95 grid place-items-center content-center grid-flow-col gap-3 uppercase tracking-widest text-xs">
                                <span>Complete Profile</span>
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        @endif

                        @if(isset($is_rejected) && $is_rejected)
                             <a href="{{ route('complete-profile.step1') }}" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-black py-4 px-8 rounded-2xl shadow-xl shadow-amber-500/20 transition-all active:scale-95 grid place-items-center content-center grid-flow-col gap-3 uppercase tracking-widest text-xs">
                                <span>Resubmit Application</span>
                                <i class="fas fa-redo text-[10px]"></i>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full bg-white dark:bg-white/5 text-gray-700 dark:text-gray-300 font-black py-4 px-8 rounded-2xl border border-gray-100 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/10 transition-all active:scale-95 uppercase tracking-widest text-xs">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
