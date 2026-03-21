<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10 text-center relative">
                <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full"></div>
                <h2 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight drop-shadow-sm mb-3">
                    Complete <span class="text-emerald-600 dark:text-emerald-500">Profile</span>
                </h2>
                <p class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">Step 3: Next of Kin & Payment</p>
            </div>

            <!-- Progress Bar -->
            <div class="flex items-center justify-center gap-4 mb-10 px-10">
                <div class="h-1.5 flex-1 bg-emerald-600 opacity-30 rounded-full"></div>
                <div class="h-1.5 flex-1 bg-emerald-600 opacity-50 rounded-full"></div>
                <div class="h-1.5 flex-1 bg-emerald-600 rounded-full shadow-[0_0_15px_rgba(5,150,105,0.3)]"></div>
            </div>

            <div class="bg-white/70 dark:bg-gray-900/40 backdrop-blur-2xl shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] sm:rounded-[2.5rem] border border-gray-100 dark:border-white/10 p-10">
                <form method="POST" action="{{ route('complete-profile.step3.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                         <div class="group">
                            <x-input-label for="next_of_kin_name" :value="__('Next of Kin Name')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="next_of_kin_name" name="next_of_kin_name" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" required />
                            <x-input-error :messages="$errors->get('next_of_kin_name')" class="mt-2" />
                        </div>

                         <div class="group">
                            <x-input-label for="next_of_kin_phone" :value="__('Next of Kin Phone')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="next_of_kin_phone" name="next_of_kin_phone" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" required />
                            <x-input-error :messages="$errors->get('next_of_kin_phone')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="nok_relationship" :value="__('Relationship')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="nok_relationship" name="nok_relationship" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" required />
                            <x-input-error :messages="$errors->get('nok_relationship')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="emergency_contact_name" :value="__('Emergency Contact Name')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="emergency_contact_name" name="emergency_contact_name" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" required />
                            <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="emergency_contact_phone" :value="__('Emergency Contact Phone')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                            <x-text-input id="emergency_contact_phone" name="emergency_contact_phone" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" required />
                            <x-input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-white/5 pt-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                             <div class="group">
                                <x-input-label for="bank_name" :value="__('Your Bank Name')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                                <x-text-input id="bank_name" name="bank_name" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" required />
                                <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                            </div>

                             <div class="group">
                                <x-input-label for="account_number" :value="__('Account Number')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                                <x-text-input id="account_number" name="account_number" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" required maxlength="10" />
                                <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                            </div>

                            <div class="group md:col-span-2">
                                <x-input-label for="account_name" :value="__('Account Name (Must match your ID)')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                                <x-text-input id="account_name" name="account_name" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4" required />
                                <x-input-error :messages="$errors->get('account_name')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="payment_method" :value="__('Registration Fee Payment')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 group-focus-within:text-emerald-500 transition-colors" />
                                <select id="payment_method" name="payment_method" class="block w-full rounded-2xl border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all font-medium py-4">
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Online Payment">Online Payment</option>
                                    <option value="Cash">Cash at Office</option>
                                </select>
                                <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="payment_proof_file" :value="__('Upload Payment Proof (If Transfer)')" class="ms-1 mb-2 text-xs font-black uppercase tracking-widest text-gray-400 transition-colors" />
                                <input type="file" id="payment_proof_file" name="payment_proof_file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all" />
                                <x-input-error :messages="$errors->get('payment_proof_file')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-between gap-4">
                        <a href="{{ route('complete-profile.step2') }}" class="w-full sm:w-auto bg-white dark:bg-white/5 text-gray-700 dark:text-gray-300 font-black py-4 px-10 rounded-2xl border border-gray-100 dark:border-white/10 hover:bg-gray-50 transition-all active:scale-95 text-center uppercase tracking-widest text-xs">
                            Back
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-500 text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-emerald-500/20 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                            <span>Submit Application</span>
                            <i class="fas fa-check-double text-[10px]"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
