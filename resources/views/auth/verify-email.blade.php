<x-guest-layout>
    <div class="mb-10 text-center relative">
        <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full"></div>
        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight drop-shadow-sm mb-3">
            Verify Your <span class="text-emerald-600 dark:text-emerald-500">Email</span>
        </h2>
        <p class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] leading-loose">We've sent a link to your inbox</p>
    </div>

    <div class="mb-8 text-sm font-medium text-gray-500 dark:text-gray-400 leading-relaxed text-center px-4">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if(session('status') == 'verification-link-sent')
        <div class="mb-8 py-4 px-6 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 rounded-2xl font-bold text-xs text-emerald-600 dark:text-emerald-400 text-center uppercase tracking-widest animate-pulse-slow">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-8 flex flex-col items-center gap-6">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 px-8 rounded-2xl shadow-xl shadow-emerald-500/20 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                <i class="fas fa-paper-plane text-[10px]"></i>
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full bg-white dark:bg-white/5 text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-500 font-black py-4 px-8 rounded-2xl border border-gray-100 dark:border-white/5 transition-all active:scale-95 uppercase tracking-widest text-xs">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
