<x-guest-layout>
    <div class="mb-8 text-center text-sm font-medium text-gray-500 dark:text-gray-400 leading-relaxed">
        {{ __('Forgot your password? No problem. Enter your email address and we will send you a secure link to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="mb-2" />
            <x-text-input id="email" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5 focus:border-amber-500 focus:ring-amber-500 transition-all font-medium py-3.5" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-4 mt-8">
            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-black py-4 rounded-2xl shadow-xl shadow-amber-600/20 hover:shadow-amber-500/30 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                <i class="fas fa-paper-plane text-sm"></i>
                {{ __('Reset Password Link') }}
            </button>
            <a href="{{ route('login') }}" class="text-center text-xs font-black text-gray-400 hover:text-emerald-600 transition-colors uppercase tracking-widest">
                Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>
