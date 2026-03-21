<x-app-layout>
    <div class="py-10 bg-transparent min-h-screen" x-data="{ activeTab: 'profile' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">
                
                {{-- Sidebar --}}
                <div class="w-full md:w-1/3 lg:w-1/4">
                    <div class="bg-[#0E211A] p-6 rounded-2xl shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 flex flex-col items-center text-center mb-6 relative overflow-hidden">
                        <span class="absolute -left-4 top-0 w-2 h-full bg-gold rounded-full opacity-30"></span>
                        <div class="relative group cursor-pointer inline-block z-10">
                            @if(Auth::user()->profile_photo_path)
                                <img class="h-28 w-28 object-cover rounded-full shadow-[0_0_15px_rgba(16,185,129,0.2)] border-4 border-[#0B1A14] group-hover:scale-105 transition-transform duration-300" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                            @else
                                <div class="h-28 w-28 rounded-full bg-gradient-to-tr from-emerald-600 to-emerald-900 text-white flex items-center justify-center text-4xl font-bold shadow-[0_0_15px_rgba(16,185,129,0.2)] border-4 border-[#0B1A14] group-hover:scale-105 transition-transform duration-300">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <!-- We could add file upload logic here or just rely on the main form -->
                        </div>
                        <h2 class="mt-4 text-xl font-bold text-white tracking-tight z-10">{{ Auth::user()->name }}</h2>
                        <div class="flex items-center justify-center gap-2 mt-2 z-10">
                            <span class="px-2.5 py-1 bg-emerald-900/30 text-emerald-400 rounded-md text-xs font-semibold capitalize tracking-wider border border-emerald-500/30">
                                {{ Auth::user()->role }}
                            </span>
                            <span class="px-2.5 py-1 bg-[#0B1A14] text-emerald-600/70 rounded-md text-xs font-bold tracking-widest border border-emerald-900/50">
                                #{{ Auth::user()->id + 1000 }}
                            </span>
                        </div>
                    </div>

                    <div class="bg-[#0E211A] rounded-2xl shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 overflow-hidden">
                        <nav class="flex flex-col p-2 space-y-1">
                            <button @click="activeTab = 'profile'" :class="{'bg-[#0B1A14] text-emerald-400 font-bold ring-1 ring-emerald-500/30': activeTab === 'profile', 'text-emerald-600/70 hover:bg-emerald-900/20 hover:text-emerald-400 font-medium': activeTab !== 'profile'}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm text-left w-full">
                                <i class="fas fa-user-circle w-5 text-center" :class="{'text-emerald-500': activeTab === 'profile'}"></i>
                                Personal Information
                            </button>
                            
                            @if(Auth::user()->member)
                            <button @click="activeTab = 'bank'" :class="{'bg-[#0B1A14] text-emerald-400 font-bold ring-1 ring-emerald-500/30': activeTab === 'bank', 'text-emerald-600/70 hover:bg-emerald-900/20 hover:text-emerald-400 font-medium': activeTab !== 'bank'}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm text-left w-full">
                                <i class="fas fa-university w-5 text-center" :class="{'text-emerald-500': activeTab === 'bank'}"></i>
                                Bank Details
                            </button>
                            @endif

                            <button @click="activeTab = 'security'" :class="{'bg-[#0B1A14] text-emerald-400 font-bold ring-1 ring-emerald-500/30': activeTab === 'security', 'text-emerald-600/70 hover:bg-emerald-900/20 hover:text-emerald-400 font-medium': activeTab !== 'security'}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm text-left w-full">
                                <i class="fas fa-shield-alt w-5 text-center" :class="{'text-emerald-500': activeTab === 'security'}"></i>
                                Security & Privacy
                            </button>

                            <button @click="activeTab = 'danger'" :class="{'bg-red-900/20 text-red-400 font-bold ring-1 ring-red-500/30': activeTab === 'danger', 'text-emerald-600/70 hover:bg-red-900/10 hover:text-red-400 font-medium': activeTab !== 'danger'}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm text-left w-full mt-4">
                                <i class="fas fa-exclamation-triangle w-5 text-center" :class="{'text-red-500': activeTab === 'danger'}"></i>
                                Danger Zone
                            </button>
                        </nav>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="w-full md:w-2/3 lg:w-3/4 space-y-6">
                    
                    {{-- Personal Information Tab --}}
                    <div x-show="activeTab === 'profile'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-[#0E211A] p-6 sm:p-8 rounded-2xl shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50">
                        <div class="mb-6 border-b border-emerald-900/30 pb-4">
                            <h3 class="text-xl font-bold text-white tracking-tight">Personal Information</h3>
                            <p class="mt-1 text-sm text-emerald-600/70 font-medium tracking-wide">Update your account's profile information and email address.</p>
                        </div>
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    {{-- Bank Details Tab --}}
                    @if(Auth::user()->member)
                    <div x-show="activeTab === 'bank'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-[#0E211A] p-6 sm:p-8 rounded-2xl shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50">
                        <div class="mb-6 border-b border-emerald-900/30 pb-4">
                            <h3 class="text-xl font-bold text-white tracking-tight">Bank Details</h3>
                            <p class="mt-1 text-sm text-emerald-600/70 font-medium tracking-wide">Provide your bank information for disbursements and withdrawals.</p>
                        </div>
                        <div class="max-w-xl">
                            <form action="{{ route('profile.bank.update') }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PATCH')
                                
                                <div>
                                    <label for="bank_name" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Bank Name</label>
                                    <input id="bank_name" name="bank_name" type="text" class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none" value="{{ Auth::user()->member->bank_name }}" required autofocus autocomplete="bank_name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
                                </div>

                                <div>
                                    <label for="account_number" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Account Number</label>
                                    <input id="account_number" name="account_number" type="text" maxlength="10" class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none" value="{{ Auth::user()->member->account_number }}" required autocomplete="account_number" />
                                    <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
                                </div>

                                <div>
                                    <label for="account_name" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-2">Account Name</label>
                                    <input id="account_name" name="account_name" type="text" class="w-full px-5 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all focus:outline-none" value="{{ Auth::user()->member->account_name }}" required autocomplete="account_name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('account_name')" />
                                </div>

                                <div class="flex items-center gap-4 pt-2">
                                    <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-3 px-8 rounded-xl transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:-translate-y-0.5 uppercase tracking-widest text-xs">
                                        Save Details
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    {{-- Security Tab --}}
                    <div x-show="activeTab === 'security'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-[#0E211A] p-6 sm:p-8 rounded-2xl shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50">
                        <div class="mb-6 border-b border-emerald-900/30 pb-4">
                            <h3 class="text-xl font-bold text-white tracking-tight">Security & Privacy</h3>
                            <p class="mt-1 text-sm text-emerald-600/70 font-medium tracking-wide">Ensure your account is using a long, random password to stay secure.</p>
                        </div>
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    {{-- Danger Zone Tab --}}
                    <div x-show="activeTab === 'danger'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-[#0E211A] p-6 sm:p-8 rounded-2xl shadow-[0_0_25px_rgba(239,68,68,0.05)] border border-red-900/30">
                        <div class="mb-6 border-b border-red-900/20 pb-4">
                            <h3 class="text-xl font-bold text-red-500 tracking-tight">Danger Zone</h3>
                            <p class="mt-1 text-sm text-emerald-600/70 font-medium tracking-wide">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                        </div>
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>
