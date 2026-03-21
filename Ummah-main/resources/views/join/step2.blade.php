<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-army-green dark:text-gold">New Member Registration</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Step 2 of 3: Contact & Identification</p>
        
        <!-- Progress Bar -->
        <div class="mt-4 flex justify-center gap-2">
            <div class="h-2 w-12 bg-army-green rounded-full"></div>
            <div class="h-2 w-12 bg-army-green rounded-full"></div>
            <div class="h-2 w-12 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
        </div>
    </div>

    <form method="POST" action="{{ route('join.step2.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Contact Info -->
        <h3 class="font-semibold text-gray-800 dark:text-white border-b pb-2 mb-4">Contact Information</h3>

        <div class="mb-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <div class="flex">
                 <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    +234
                  </span>
                <x-text-input id="phone" class="rounded-none rounded-r-lg bg-gray-50 border text-gray-900 focus:ring-army-green focus:border-army-green block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5" type="tel" name="phone" :value="old('phone', $data['phone'] ?? '')" required placeholder="803 123 4567" />
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="address" :value="__('Residential Address')" />
            <textarea id="address" name="address" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-army-green focus:border-army-green dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required placeholder="Street Address">{{ old('address', $data['address'] ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <x-input-label for="city" :value="__('City / Town')" />
                <x-text-input id="city" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="city" :value="old('city', $data['city'] ?? '')" required />
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>
             <div>
                <x-input-label for="state" :value="__('State')" />
                <x-text-input id="state" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="state" :value="old('state', $data['state'] ?? '')" required />
                <x-input-error :messages="$errors->get('state')" class="mt-2" />
            </div>
        </div>

        <!-- Identification -->
        <h3 class="font-semibold text-gray-800 dark:text-white border-b pb-2 mb-4">Identification</h3>

        <div class="mb-4">
            <x-input-label for="id_type" :value="__('ID Type')" />
             <select id="id_type" name="id_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-army-green focus:ring-army-green rounded-md shadow-sm">
                <option value="National ID" {{ (old('id_type', $data['id_type'] ?? '') == 'National ID') ? 'selected' : '' }}>National ID Card</option>
                <option value="Voters Card" {{ (old('id_type', $data['id_type'] ?? '') == 'Voters Card') ? 'selected' : '' }}>Voter's Card</option>
                <option value="Drivers License" {{ (old('id_type', $data['id_type'] ?? '') == 'Drivers License') ? 'selected' : '' }}>Driver's License</option>
                <option value="International Passport" {{ (old('id_type', $data['id_type'] ?? '') == 'International Passport') ? 'selected' : '' }}>International Passport</option>
                <option value="Staff ID" {{ (old('id_type', $data['id_type'] ?? '') == 'Staff ID') ? 'selected' : '' }}>Staff ID</option>
                <option value="File ID" {{ (old('id_type', $data['id_type'] ?? '') == 'File ID') ? 'selected' : '' }}>File ID</option>
            </select>
            <x-input-error :messages="$errors->get('id_type')" class="mt-2" />
        </div>

        <div class="mb-4">
             <x-input-label for="id_number" :value="__('ID Number')" />
             <x-text-input id="id_number" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="id_number" :value="old('id_number', $data['id_number'] ?? '')" required />
             <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="id_card_file" :value="__('Upload ID Document')" />
            <input id="id_card_file" type="file" name="id_card_file" class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0
                file:text-sm file:font-semibold
                file:bg-army-green file:text-white
                hover:file:bg-opacity-90 cursor-pointer" accept="image/*,.pdf" required />
            <p class="text-xs text-gray-500 mt-1">Accepted: JPG, PNG, PDF - Max 2MB</p>
            <x-input-error :messages="$errors->get('id_card_file')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="passport_photo_file" :value="__('Passport Photograph')" />
            <input id="passport_photo_file" type="file" name="passport_photo_file" class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0
                file:text-sm file:font-semibold
                file:bg-army-green file:text-white
                hover:file:bg-opacity-90 cursor-pointer" accept="image/*" required />
            <p class="text-xs text-gray-500 mt-1">White background, recent photo</p>
            <x-input-error :messages="$errors->get('passport_photo_file')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-10 border-t border-gray-50 pt-10">
            <a href="{{ route('join.step1') }}" class="inline-flex items-center px-6 py-4 bg-gray-50 text-gray-400 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-gray-100 hover:text-gray-600 border border-gray-100 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-army-green to-green-900 hover:from-green-900 hover:to-army-green text-white font-black py-5 px-12 rounded-2xl shadow-2xl shadow-green-900/30 transition-all active:scale-95 group flex items-center justify-center gap-4 uppercase tracking-[0.2em] text-xs underline-none">
                {{ __('Next: Final Step') }}
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>
</x-guest-layout>
