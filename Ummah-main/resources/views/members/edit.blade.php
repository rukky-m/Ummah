<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('members.update', $member) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Details -->
                            <div class="col-span-2">
                                <h3 class="text-lg font-medium text-army-green border-b pb-2 mb-4">Personal Details</h3>
                            </div>

                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $member->title)" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="full_name" :value="__('Full Name')" />
                                <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name', $member->full_name)" required />
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $member->phone)" required />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="dob" :value="__('Date of Birth')" />
                                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob', $member->dob ? $member->dob->format('Y-m-d') : '')" />
                                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="gender" :value="__('Gender')" />
                                <select id="gender" name="gender" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $member->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $member->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="occupation" :value="__('Occupation')" />
                                <x-text-input id="occupation" class="block mt-1 w-full" type="text" name="occupation" :value="old('occupation', $member->occupation)" />
                                <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <x-input-label for="address" :value="__('Address')" />
                                <textarea id="address" name="address" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('address', $member->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div class="col-span-2 mt-4">
                                <h3 class="text-lg font-medium text-army-green border-b pb-2 mb-4">Identification Details</h3>
                            </div>

                            <div>
                                <x-input-label for="file_number" :value="__('File Number')" />
                                <x-text-input id="file_number" class="block mt-1 w-full" type="text" name="file_number" :value="old('file_number', $member->file_number)" placeholder="e.g. F-12345" />
                                <x-input-error :messages="$errors->get('file_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="id_type" :value="__('Identification Type')" />
                                <select id="id_type" name="id_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Select ID Type</option>
                                    <option value="Staff ID" {{ old('id_type', $member->id_type) == 'Staff ID' ? 'selected' : '' }}>Staff ID</option>
                                    <option value="National ID" {{ old('id_type', $member->id_type) == 'National ID' ? 'selected' : '' }}>National ID</option>
                                    <option value="Voter ID" {{ old('id_type', $member->id_type) == 'Voter ID' ? 'selected' : '' }}>Voter ID</option>
                                    <option value="International Passport" {{ old('id_type', $member->id_type) == 'International Passport' ? 'selected' : '' }}>International Passport</option>
                                    <option value="Other" {{ old('id_type', $member->id_type) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('id_type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="id_number" :value="__('Identification Number')" />
                                <x-text-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number', $member->id_number)" placeholder="Enter ID number" />
                                <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                            </div>

                            <!-- Next of Kin -->
                            <div class="col-span-2 mt-4">
                                <h3 class="text-lg font-medium text-army-green border-b pb-2 mb-4">Next of Kin</h3>
                            </div>

                            <div>
                                <x-input-label for="next_of_kin_name" :value="__('Next of Kin Name')" />
                                <x-text-input id="next_of_kin_name" class="block mt-1 w-full" type="text" name="next_of_kin_name" :value="old('next_of_kin_name', $member->next_of_kin_name)" />
                                <x-input-error :messages="$errors->get('next_of_kin_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="next_of_kin_phone" :value="__('Next of Kin Phone')" />
                                <x-text-input id="next_of_kin_phone" class="block mt-1 w-full" type="text" name="next_of_kin_phone" :value="old('next_of_kin_phone', $member->next_of_kin_phone)" />
                                <x-input-error :messages="$errors->get('next_of_kin_phone')" class="mt-2" />
                            </div>

                            <!-- Cooperative Details -->
                            <div class="col-span-2 mt-4">
                                <h3 class="text-lg font-medium text-army-green border-b pb-2 mb-4">Cooperative Account</h3>
                            </div>

                            <div>
                                <x-input-label for="account_number" :value="__('Account Number')" />
                                <x-text-input id="account_number" class="block mt-1 w-full" type="text" name="account_number" :value="old('account_number', $member->account_number)" />
                                <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="suspended" {{ old('status', $member->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-10 pt-8 border-t border-gray-50">
                            <a href="{{ route('members.index') }}" class="inline-flex items-center px-6 py-4 bg-gray-50 text-gray-400 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-gray-100 hover:text-gray-600 border border-gray-100 transition-all">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Directory
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-army-green to-green-900 hover:from-green-900 hover:to-army-green text-white font-black py-4 px-10 rounded-xl shadow-xl shadow-green-900/20 hover:shadow-green-900/30 transition-all active:scale-95 flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                                <i class="fas fa-save text-[10px]"></i>
                                Update Member Records
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
