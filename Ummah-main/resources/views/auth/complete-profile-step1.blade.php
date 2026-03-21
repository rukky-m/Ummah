<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10 text-center relative">
                <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full"></div>
                <h2 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight drop-shadow-sm mb-3">
                    Complete <span class="text-emerald-600 dark:text-emerald-500">Profile</span>
                </h2>
                <p class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Step 1: Personal Details</p>
            </div>

            <!-- Progress Bar -->
            <div class="flex items-center justify-center gap-4 mb-10 px-10">
                <div class="h-1.5 flex-1 bg-emerald-600 rounded-full shadow-[0_0_15px_rgba(5,150,105,0.3)]"></div>
                <div class="h-1.5 flex-1 bg-gray-100 dark:bg-white/5 rounded-full"></div>
                <div class="h-1.5 flex-1 bg-gray-100 dark:bg-white/5 rounded-full"></div>
            </div>

            <div class="bg-white/70 dark:bg-gray-900/40 backdrop-blur-2xl shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] sm:rounded-[2.5rem] border border-gray-100 dark:border-white/10 p-10">
                <form method="POST" action="{{ route('complete-profile.step1.store') }}" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group">
                            <x-input-label for="first_name" :value="__('First Name')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="first_name" name="first_name" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('first_name', $data['first_name'] ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="last_name" :value="__('Last Name')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="last_name" name="last_name" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('last_name', $data['last_name'] ?? '')" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="middle_name" :value="__('Middle Name (Optional)')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="middle_name" name="middle_name" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('middle_name', $data['middle_name'] ?? '')" />
                            <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="dob" :value="__('Date of Birth')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="dob" type="date" name="dob" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('dob', $data['dob'] ?? '')" required />
                            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="gender" :value="__('Gender')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <select id="gender" name="gender" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4 shadow-sm">
                                <option value="Male" {{ old('gender', $data['gender'] ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $data['gender'] ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $data['gender'] ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="marital_status" :value="__('Marital Status')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="marital_status" name="marital_status" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('marital_status', $data['marital_status'] ?? '')" required placeholder="e.g. Married, Single" />
                            <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-white/5 pt-8">
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="group">
                                <x-input-label for="occupation" :value="__('Occupation')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                                <x-text-input id="occupation" name="occupation" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('occupation', $data['occupation'] ?? '')" required />
                                <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="employer_name" :value="__('Employer Name')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                                <x-text-input id="employer_name" name="employer_name" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" :value="old('employer_name', $data['employer_name'] ?? '')" required />
                                <x-input-error :messages="$errors->get('employer_name')" class="mt-2" />
                            </div>

                            <div class="group md:col-span-2">
                                <x-input-label for="monthly_income_range" :value="__('Monthly Income Range')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                                <select id="monthly_income_range" name="monthly_income_range" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4">
                                    <option value="Below 50k" {{ old('monthly_income_range', $data['monthly_income_range'] ?? '') == 'Below 50k' ? 'selected' : '' }}>Below ₦50,000</option>
                                    <option value="50k - 100k" {{ old('monthly_income_range', $data['monthly_income_range'] ?? '') == '50k - 100k' ? 'selected' : '' }}>₦50,000 - ₦100,000</option>
                                    <option value="100k - 250k" {{ old('monthly_income_range', $data['monthly_income_range'] ?? '') == '100k - 250k' ? 'selected' : '' }}>₦100,000 - ₦250,000</option>
                                    <option value="Above 250k" {{ old('monthly_income_range', $data['monthly_income_range'] ?? '') == 'Above 250k' ? 'selected' : '' }}>Above ₦250,000</option>
                                </select>
                                <x-input-error :messages="$errors->get('monthly_income_range')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-end">
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
