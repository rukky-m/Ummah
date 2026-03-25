<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none placeholder-emerald-900/50" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none placeholder-emerald-900/50" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none placeholder-emerald-900/50" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-3 px-8 rounded-xl transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:-translate-y-0.5 uppercase tracking-widest text-xs">
                {{ __('Update Password') }}
            </button>

            @if(session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold text-emerald-400 px-3 flex items-center gap-1"
                ><i class="fas fa-check-circle"></i> {{ __('Password Secured.') }}</p>
            @endif
        </div>
    </form>
</section>
