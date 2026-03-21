<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10 text-center relative">
                <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full"></div>
                <h2 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight drop-shadow-sm mb-3">
                    Complete <span class="text-emerald-600 dark:text-emerald-500">Profile</span>
                </h2>
                <p class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Step 2: Contact & Identification</p>
            </div>

            <!-- Progress Bar -->
            <div class="flex items-center justify-center gap-4 mb-10 px-10">
                <div class="h-1.5 flex-1 bg-emerald-600 opacity-50 rounded-full"></div>
                <div class="h-1.5 flex-1 bg-emerald-600 rounded-full shadow-[0_0_15px_rgba(5,150,105,0.3)]"></div>
                <div class="h-1.5 flex-1 bg-gray-100 dark:bg-white/5 rounded-full"></div>
            </div>

            <div class="bg-white/70 dark:bg-gray-900/40 backdrop-blur-2xl shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] sm:rounded-[2.5rem] border border-gray-100 dark:border-white/10 p-10">
                <form method="POST" action="{{ route('complete-profile.step2.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                         <div class="group">
                            <x-input-label for="phone" :value="__('Phone Number')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="phone" name="phone" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('phone', $data['phone'] ?? '')" required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                         <div class="group md:col-span-2">
                            <x-input-label for="address" :value="__('Residential Address')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="address" name="address" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('address', $data['address'] ?? '')" required />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="city" :value="__('City')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="city" name="city" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('city', $data['city'] ?? '')" required />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="state" :value="__('State')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="state" name="state" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('state', $data['state'] ?? '')" required />
                            <x-input-error :messages="$errors->get('state')" class="mt-2" />
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-white/5 pt-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="group">
                                <x-input-label for="id_type" :value="__('ID Type')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                                <select id="id_type" name="id_type" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4">
                                    <option value="National ID" {{ old('id_type', $data['id_type'] ?? '') == 'National ID' ? 'selected' : '' }}>National ID (NIN)</option>
                                    <option value="Voters Card" {{ old('id_type', $data['id_type'] ?? '') == 'Voters Card' ? 'selected' : '' }}>Voters Card</option>
                                    <option value="International Passport" {{ old('id_type', $data['id_type'] ?? '') == 'International Passport' ? 'selected' : '' }}>International Passport</option>
                                    <option value="Drivers License" {{ old('id_type', $data['id_type'] ?? '') == 'Drivers License' ? 'selected' : '' }}>Drivers License</option>
                                </select>
                                <x-input-error :messages="$errors->get('id_type')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="id_number" :value="__('ID Number')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                                <x-text-input id="id_number" name="id_number" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('id_number', $data['id_number'] ?? '')" required />
                                <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="id_card_file" :value="__('Upload ID Card')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 transition-colors" />
                                <input type="file" id="id_card_file" name="id_card_file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all" required />
                                <x-input-error :messages="$errors->get('id_card_file')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="passport_photo_file" :value="__('Upload Passport Photo')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 transition-colors" />
                                <input type="file" id="passport_photo_file" name="passport_photo_file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all" required />
                                <x-input-error :messages="$errors->get('passport_photo_file')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-between gap-4">
                        <a href="{{ route('complete-profile.step1') }}" class="w-full sm:w-auto bg-white dark:bg-white/5 text-gray-700 dark:text-gray-300 font-black py-4 px-10 rounded-2xl border border-gray-100 dark:border-white/10 hover:bg-gray-50 transition-all active:scale-95 text-center uppercase tracking-widest text-xs">
                            Back
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-emerald-500/20 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                            <span>Continue</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
