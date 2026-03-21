<x-guest-layout>
    <div class="mb-10 text-center relative">
        <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full"></div>
        <h2 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight drop-shadow-sm mb-3">
            Join <span class="text-emerald-600 dark:text-emerald-500">Ummah</span>
        </h2>
        <p class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Create your account</p>
    </div>

    <!-- Google Register Button -->
    <div class="mb-8">
        <a href="{{ route('auth.google') }}" class="group w-full bg-white dark:bg-white/5 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-700 dark:text-white font-bold py-4 px-6 rounded-2xl border border-gray-100 dark:border-white/10 shadow-sm transition-all duration-300 flex items-center justify-center gap-3 active:scale-[0.98]">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span>Sign up with Google</span>
        </a>

        <div class="relative mt-8 mb-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-100 dark:border-white/5"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase tracking-widest font-black text-gray-300 dark:text-gray-600">
                <span class="bg-white/50 dark:bg-gray-950/50 backdrop-blur-sm px-4">Or use email</span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="group">
            <x-input-label for="name" :value="__('Full Name')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 ps-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                    <i class="fas fa-user text-sm"></i>
                </div>
                <x-text-input id="name" class="block w-full ps-11 rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4 text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" :value="__('Email Address')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 ps-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                    <i class="fas fa-envelope text-sm"></i>
                </div>
                <x-text-input id="email" class="block w-full ps-11 rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4 text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="group">
            <x-input-label for="password" :value="__('Password')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 ps-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                    <i class="fas fa-lock text-sm"></i>
                </div>
                <x-text-input id="password" class="block w-full ps-11 rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4 text-sm"
                                type="password"
                                name="password"
                                required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="group">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 ps-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                    <i class="fas fa-shield-check text-sm"></i>
                </div>
                <x-text-input id="password_confirmation" class="block w-full ps-11 rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4 text-sm"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 rounded-2xl shadow-xl shadow-emerald-500/20 hover:shadow-emerald-400/30 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase tracking-[0.2em] text-xs">
                <span>Create Account</span>
                <i class="fas fa-user-plus text-[10px]"></i>
            </button>

            <p class="mt-8 text-center text-xs font-bold text-gray-400">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-500 transition-colors font-black uppercase tracking-widest">Sign In</a>
            </p>
        </div>
    </form>
</x-guest-layout>
