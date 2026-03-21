<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-army-green dark:text-gold">New Member Registration</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Step 3 of 3: Emergency & Payment</p>
        
        <!-- Progress Bar -->
        <div class="mt-4 flex justify-center gap-2">
            <div class="h-2 w-12 bg-army-green rounded-full"></div>
            <div class="h-2 w-12 bg-army-green rounded-full"></div>
            <div class="h-2 w-12 bg-army-green rounded-full"></div>
        </div>
    </div>

    <form method="POST" action="{{ route('join.step3.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Emergency Contact -->
        <h3 class="font-semibold text-gray-800 dark:text-white border-b pb-2 mb-4">Emergency Contact (Next of Kin)</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                 <x-input-label for="next_of_kin_name" :value="__('Next of Kin Name')" />
                 <x-text-input id="next_of_kin_name" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="next_of_kin_name" required />
                 <x-input-error :messages="$errors->get('next_of_kin_name')" class="mt-2" />
            </div>
            <div>
                 <x-input-label for="nok_relationship" :value="__('Relationship')" />
                 <x-text-input id="nok_relationship" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="nok_relationship" required placeholder="e.g. Spouse, Father" />
                 <x-input-error :messages="$errors->get('nok_relationship')" class="mt-2" />
            </div>
        </div>
        
        <div class="mb-6">
             <x-input-label for="next_of_kin_phone" :value="__('Next of Kin Phone')" />
             <x-text-input id="next_of_kin_phone" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="tel" name="next_of_kin_phone" required />
             <x-input-error :messages="$errors->get('next_of_kin_phone')" class="mt-2" />
        </div>
        
        <h3 class="font-semibold text-gray-800 dark:text-white border-b pb-2 mb-4">Secondary Emergency Contact</h3>
         <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                 <x-input-label for="emergency_contact_name" :value="__('Contact Name')" />
                 <x-text-input id="emergency_contact_name" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="emergency_contact_name" required />
                 <p class="text-xs text-gray-500 mt-1">Different from Next of Kin</p>
            </div>
            <div>
                 <x-input-label for="emergency_contact_phone" :value="__('Contact Phone')" />
                 <x-text-input id="emergency_contact_phone" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="tel" name="emergency_contact_phone" required />
            </div>
        </div>

        <!-- Bank Details for Disbursements -->
        <h3 class="font-semibold text-gray-800 dark:text-white border-b pb-2 mb-4">Your Bank Details (For Dividends & Loans)</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                 <x-input-label for="bank_name" :value="__('Bank Name')" />
                 <x-text-input id="bank_name" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="bank_name" required placeholder="e.g. GTBank" />
                 <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
            </div>
            <div>
                 <x-input-label for="account_number" :value="__('Account Number')" />
                 <x-text-input id="account_number" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="account_number" required maxlength="10" pattern="\d{10}" title="10 digit account number" />
                 <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
            </div>
            <div>
                 <x-input-label for="account_name" :value="__('Account Name')" />
                 <x-text-input id="account_name" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="text" name="account_name" required />
                 <x-input-error :messages="$errors->get('account_name')" class="mt-2" />
            </div>
        </div>

        <!-- Payment -->
        <h3 class="font-semibold text-gray-800 dark:text-white border-b pb-2 mb-4">Membership Fee Payment</h3>
        
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded p-4 mb-6">
            <p class="font-bold text-blue-800 dark:text-blue-300">Registration Fee: ₦1,000</p>
            <p class="text-sm text-blue-600 dark:text-blue-400">This is a non-refundable one-time payment.</p>
        </div>

        <div class="mb-4">
             <x-input-label for="payment_method" :value="__('Select Payment Method')" />
             <div class="mt-2 space-y-2">
                 <div class="flex items-center">
                     <input id="pay_bank" name="payment_method" type="radio" value="Bank Transfer" class="focus:ring-army-green h-4 w-4 text-army-green border-gray-300" checked onclick="document.getElementById('bank_details').classList.remove('hidden')">
                     <label for="pay_bank" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Transfer</label>
                 </div>
                 <div class="flex items-center">
                     <input id="pay_cash" name="payment_method" type="radio" value="Cash" class="focus:ring-army-green h-4 w-4 text-army-green border-gray-300" onclick="document.getElementById('bank_details').classList.add('hidden')">
                     <label for="pay_cash" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Cash (Pay at Office)</label>
                 </div>
             </div>
        </div>

        <div id="bank_details" class="bg-gray-100 dark:bg-gray-800 p-4 rounded mb-6">
            <h4 class="font-bold text-sm mb-2">Bank Transfer Instructions:</h4>
            <div class="text-sm space-y-1 mb-4">
                <p>Bank: <span class="font-bold">ACCESS BANK</span></p>
                <p>Account Name: <span class="font-bold">NSUK UMMAH MULTIPURPOSE COOPERATIVE SOCIETY LIMITED</span></p>
                <p>Account Number: <span class="font-bold">1444477940</span></p>
            </div>
            
            <x-input-label for="payment_proof_file" :value="__('Upload Payment Proof')" />
            <input id="payment_proof_file" type="file" name="payment_proof_file" class="block w-full text-sm text-gray-500 rounded border border-gray-300 p-1
                file:mr-4 file:py-1 file:px-2
                file:rounded-md file:border-0
                file:text-xs file:bg-gray-200 file:text-gray-700
                hover:file:bg-gray-300" accept="image/*,.pdf" />
            <x-input-error :messages="$errors->get('payment_proof_file')" class="mt-2" />
        </div>
        
        <hr class="my-6 border-gray-200 dark:border-gray-700">
        
        <!-- Account Security -->
        <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Create Your Account Password</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                 <x-input-label for="password" :value="__('Password')" />
                 <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="password" name="password" required />
                 <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                 <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                 <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-army-green focus:ring-army-green" type="password" name="password_confirmation" required />
            </div>
        </div>

        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" required class="rounded border-gray-300 text-army-green shadow-sm focus:ring-army-green">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">I agree to abide by the NUMCSU constitution and terms.</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-10 gap-4">
            <a href="{{ route('join.step2') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-4 bg-gray-50 text-gray-400 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-gray-100 hover:text-gray-600 border border-gray-100 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-gold to-yellow-600 hover:from-yellow-600 hover:to-gold text-white font-black py-5 px-14 rounded-2xl shadow-2xl shadow-gold/40 transition-all active:scale-95 flex items-center justify-center gap-4 uppercase tracking-[0.2em] text-xs outline-none group border-2 border-white/20 hover:border-white/40">
                <i class="fas fa-rocket group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>
                {{ __('Finalize Registration') }}
            </button>
        </div>
    </form>
</x-guest-layout>
