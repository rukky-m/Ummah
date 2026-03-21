<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-army-green dark:text-gold">New Member Registration</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Step 1 of 3: Personal Information</p>
        
        <!-- Progress Bar -->
        <div class="mt-4 flex justify-center gap-2">
            <div class="h-2 w-12 bg-army-green rounded-full"></div>
            <div class="h-2 w-12 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
            <div class="h-2 w-12 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
        </div>
    </div>

    <form method="POST" action="{{ route('join.step1.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="first_name" :value="old('first_name', $data['first_name'] ?? '')" required autofocus />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="middle_name" :value="__('Middle Name')" />
                <x-text-input id="middle_name" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="middle_name" :value="old('middle_name', $data['middle_name'] ?? '')" />
                <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="last_name" :value="old('last_name', $data['last_name'] ?? '')" required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>
        
        <div class="mb-4">
            <x-input-label for="email" :value="__('File Number / Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="email" name="email" :value="old('email', $data['email'] ?? '')" required placeholder="Enter your file number or email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="dob" :value="__('Date of Birth')" />
                <x-text-input id="dob" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="date" name="dob" :value="old('dob', $data['dob'] ?? '')" required />
                <p class="text-xs text-gray-500 mt-1">Must be 18+ years old.</p>
                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-army-green focus:ring-army-green rounded-md shadow-sm">
                    <option value="">Select Gender</option>
                    <option value="Male" {{ (old('gender', $data['gender'] ?? '') == 'Male') ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ (old('gender', $data['gender'] ?? '') == 'Female') ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ (old('gender', $data['gender'] ?? '') == 'Other') ? 'selected' : '' }}>Prefer not to say</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
        </div>

        <div class="mb-4">
            <x-input-label for="marital_status" :value="__('Marital Status')" />
             <select id="marital_status" name="marital_status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-army-green focus:ring-army-green rounded-md shadow-sm">
                <option value="Single" {{ (old('marital_status', $data['marital_status'] ?? '') == 'Single') ? 'selected' : '' }}>Single</option>
                <option value="Married" {{ (old('marital_status', $data['marital_status'] ?? '') == 'Married') ? 'selected' : '' }}>Married</option>
                <option value="Divorced" {{ (old('marital_status', $data['marital_status'] ?? '') == 'Divorced') ? 'selected' : '' }}>Divorced</option>
                <option value="Widowed" {{ (old('marital_status', $data['marital_status'] ?? '') == 'Widowed') ? 'selected' : '' }}>Widowed</option>
            </select>
            <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
        </div>

        <div class="mb-4">
             <x-input-label for="occupation" :value="__('Occupation')" />
             <x-text-input id="occupation" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="occupation" :value="old('occupation', $data['occupation'] ?? '')" required />
             <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
        </div>
        
        <div class="mb-4">
             <x-input-label for="employer_name" :value="__('Employer / Business Name')" />
             <x-text-input id="employer_name" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="employer_name" :value="old('employer_name', $data['employer_name'] ?? '')" required />
             <x-input-error :messages="$errors->get('employer_name')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="monthly_income_range" :value="__('Monthly Income Range')" />
             <select id="monthly_income_range" name="monthly_income_range" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-army-green focus:ring-army-green rounded-md shadow-sm">
                <option value="">Select Range</option>
                <option value="Below 50,000" {{ (old('monthly_income_range', $data['monthly_income_range'] ?? '') == 'Below 50,000') ? 'selected' : '' }}>Below ₦50,000</option>
                <option value="50,000 - 100,000" {{ (old('monthly_income_range', $data['monthly_income_range'] ?? '') == '50,000 - 100,000') ? 'selected' : '' }}>₦50,000 - ₦100,000</option>
                <option value="100,000 - 200,000" {{ (old('monthly_income_range', $data['monthly_income_range'] ?? '') == '100,000 - 200,000') ? 'selected' : '' }}>₦100,000 - ₦200,000</option>
                <option value="Above 200,000" {{ (old('monthly_income_range', $data['monthly_income_range'] ?? '') == 'Above 200,000') ? 'selected' : '' }}>Above ₦200,000</option>
            </select>
            <x-input-error :messages="$errors->get('monthly_income_range')" class="mt-2" />
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-8 gap-4 border-t border-gray-50 pt-8">
             <a class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-army-green transition-colors" href="{{ route('login') }}">
                {{ __('Member Login') }}
            </a>
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-army-green to-green-900 hover:from-green-900 hover:to-army-green text-white font-black py-5 px-12 rounded-2xl shadow-2xl shadow-green-900/30 transition-all active:scale-95 group flex items-center justify-center gap-4 uppercase tracking-[0.2em] text-xs underline-none">
                {{ __('Next: Identification') }}
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
    </form>
</x-guest-layout>
