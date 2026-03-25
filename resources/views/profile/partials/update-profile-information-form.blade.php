<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Integrated Photo Upload --}}
        <div class="flex items-center gap-6" x-data="{ 
            photoName: null, 
            photoPreview: null,
            handleFileChange(e) {
                const file = e.target.files[0];
                if (!file) return;
                this.photoName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }">
            <div class="shrink-0 flex items-center justify-center h-16 w-16 rounded-full overflow-hidden bg-[#0B1A14] border border-emerald-900/50 shadow-[0_0_10px_rgba(16,185,129,0.1)]">
                <template x-if="! photoPreview">
                    @if($user->profile_photo_path)
                        <img class="h-16 w-16 object-cover" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" />
                    @else
                        <span class="text-xl font-bold text-emerald-400">{{ substr($user->name, 0, 1) }}</span>
                    @endif
                </template>
                <template x-if="photoPreview">
                    <img class="h-16 w-16 object-cover" :src="photoPreview" alt="Preview" />
                </template>
            </div>
            
            <div>
                <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-[#0E211A] border border-emerald-900/50 rounded-lg font-bold text-xs text-emerald-400 uppercase tracking-widest shadow-sm hover:bg-emerald-900/30 hover:border-emerald-500/50 focus:outline-none focus:ring-2 focus:ring-gold/20 transition ease-in-out duration-150">
                    <span x-text="photoPreview ? 'Change Selection' : 'Change Photo'"></span>
                    <input type="file" name="photo" class="hidden" @change="handleFileChange" accept="image/*" />
                </label>
                <div x-show="photoName" class="mt-2 text-xs text-emerald-500/70 font-bold" x-text="photoName" style="display: none;"></div>
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
        </div>

        <div>
            <label for="name" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">{{ __('Email Address') }}</label>
            <input id="email" name="email" type="email" class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gold font-bold">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-emerald-400 hover:text-emerald-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gold/20">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if(session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-sm text-emerald-500">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-3 px-8 rounded-xl transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:-translate-y-0.5 uppercase tracking-widest text-xs">
                {{ __('Save Changes') }}
            </button>

            @if(session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-bold text-emerald-400 px-3 flex items-center gap-1"
                ><i class="fas fa-check-circle"></i> {{ __('Saved successfully.') }}</p>
            @endif
        </div>
    </form>
</section>
