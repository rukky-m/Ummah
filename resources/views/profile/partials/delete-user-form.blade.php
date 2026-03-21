<section class="space-y-6">
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center justify-center px-6 py-3 bg-red-900/20 border border-red-500/30 rounded-xl font-bold text-xs text-red-500 uppercase tracking-widest hover:bg-red-900/40 hover:text-red-400 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm w-full md:w-auto mt-4"
    >
        <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-white tracking-tight flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                {{ __('Delete Account') }}
            </h2>

            <p class="mt-3 text-sm text-emerald-500/70 font-medium leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-red-500/30 focus:border-red-500/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none placeholder-emerald-900/50"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-400 font-bold text-[10px] tracking-widest uppercase" />
            </div>

            <div class="mt-8 flex justify-end gap-3 flex-col sm:flex-row">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center justify-center px-6 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-xl font-bold text-xs text-emerald-600/70 uppercase tracking-widest hover:bg-emerald-900/30 hover:text-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition duration-150 w-full sm:w-auto">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-500 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 shadow-[0_0_15px_rgba(220,38,38,0.3)] hover:shadow-[0_0_20px_rgba(220,38,38,0.5)] hover:-translate-y-0.5 w-full sm:w-auto">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
