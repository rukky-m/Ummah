<nav x-data="{ open: false }" class="bg-[#0B1A14] border-b border-emerald-900/50 sticky top-0 z-50 backdrop-blur-md bg-opacity-95">
    <!-- Primary Navigation Menu -->
    <div class="max-w-none w-full px-2 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center pr-4 border-r border-gray-100 mr-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <x-application-logo class="block h-12 w-auto transition-transform duration-300 group-hover:scale-110" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-2 group">
                        <i class="fas fa-th-large text-xs group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-bold uppercase tracking-widest">{{ __('Dashboard') }}</span>
                    </x-nav-link>

                    @can('manage-members')
                        <x-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')" class="flex items-center gap-2 group">
                            <i class="fas fa-users text-xs group-hover:scale-110 transition-transform"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">{{ __('Community Members') }}</span>
                        </x-nav-link>
                    @endcan

                    @if(Auth::user()->isStaff())
                        <!-- Financials Dropdown -->
                        @if(Auth::user()->canManageSavings() || Auth::user()->canManageContributions() || Auth::user()->canManageLoans() || Auth::user()->canManageRepayments())
                            <div class="hidden sm:flex sm:items-center">
                                <x-dropdown align="left" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest hover:text-gold transition-all gap-2 {{ request()->routeIs('savings.*') || request()->routeIs('contributions.*') || request()->routeIs('admin.loans.*') || request()->routeIs('repayments.*') ? 'text-gold' : '' }}">
                                            <i class="fas fa-wallet text-xs"></i>
                                            <span>{{ __('Financials') }}</span>
                                            <i class="fas fa-chevron-down text-[8px] ml-1 opacity-50"></i>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        @can('manage-savings')
                                            <x-dropdown-link :href="route('savings.index')">
                                                <i class="fas fa-piggy-bank mr-2 text-gold"></i> {{ __('Savings') }}
                                            </x-dropdown-link>
                                        @endcan
                                        @can('manage-contributions')
                                            <x-dropdown-link :href="route('contributions.index')">
                                                <i class="fas fa-hand-holding-heart mr-2 text-gold"></i> {{ __('Contributions') }}
                                            </x-dropdown-link>
                                        @endcan
                                        @can('manage-loans')
                                            <x-dropdown-link :href="route('admin.loans.index')">
                                                <i class="fas fa-hand-holding-usd mr-2 text-gold"></i> {{ __('Loans') }}
                                            </x-dropdown-link>
                                        @endcan
                                        @can('manage-repayments')
                                            <x-dropdown-link :href="route('repayments.index')">
                                                <i class="fas fa-coins mr-2 text-gold"></i> {{ __('Repayments') }}
                                            </x-dropdown-link>
                                        @endcan
                                        <div class="border-t border-gray-100 my-1"></div>
                                        <div class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Product Management') }}</div>
                                        @can('manage-loans')
                                            <x-dropdown-link :href="route('admin.loan-products.index', ['category' => 'asset'])">
                                                <i class="fas fa-couch mr-2 text-purple-600"></i> {{ __('Post Assets') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('admin.loan-products.index', ['category' => 'ramadan'])">
                                                <i class="fas fa-star-and-crescent mr-2 text-gold"></i> {{ __('Post Commodities') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('admin.loan-products.index', ['category' => 'motorcycle'])">
                                                <i class="fas fa-motorcycle mr-2 text-blue-600"></i> {{ __('Post Motorcycles') }}
                                            </x-dropdown-link>
                                        @endcan
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endif

                        <!-- Operations Dropdown -->
                        @if(Auth::user()->isAdmin() || Auth::user()->canManageAnnouncements() || Auth::user()->canViewCashbook())
                            <div class="hidden sm:flex sm:items-center">
                                <x-dropdown align="left" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-6 text-[11px] font-black text-gray-400 uppercase tracking-widest hover:text-gold transition-all gap-2 {{ request()->routeIs('cashbook.*') || request()->routeIs('committee.dashboard') || request()->routeIs('admin.announcements.*') ? 'text-gold' : '' }}">
                                            <i class="fas fa-cogs text-xs"></i>
                                            <span>{{ __('Ops') }}</span>
                                            <i class="fas fa-chevron-down text-[8px] ml-1 opacity-50"></i>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        @can('view-cashbook')
                                            <x-dropdown-link :href="route('cashbook.index')">
                                                <i class="fas fa-file-invoice-dollar mr-2 text-army-green"></i> {{ __('Cashbook') }}
                                            </x-dropdown-link>
                                        @endcan
                                        @if(Auth::user()->isAdmin() && !Auth::user()->canManageAnnouncements())
                                            <x-dropdown-link :href="route('committee.dashboard')">
                                                <i class="fas fa-users-cog mr-2 text-army-green"></i> {{ __('Committee') }}
                                            </x-dropdown-link>
                                        @endif
                                        @can('manage-announcements')
                                            <x-dropdown-link :href="route('admin.announcements.index')">
                                                <i class="fas fa-bullhorn mr-2 text-army-green"></i> {{ __('Announcements') }}
                                            </x-dropdown-link>
                                        @endcan
                                        <div class="border-t border-gray-100 my-1"></div>
                                        @if(Auth::user()->isAdmin())
                                            <x-dropdown-link :href="route('admin.vendors.index')">
                                                <i class="fas fa-store mr-2 text-army-green"></i> {{ __('Vendors') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('admin.loan-products.index')">
                                                <i class="fas fa-boxes mr-2 text-army-green"></i> {{ __('Product Catalog') }}
                                            </x-dropdown-link>
                                        @endif
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endif
                    @else
                        {{-- Member Navigation --}}
                        <x-nav-link :href="route('savings.index')" :active="request()->routeIs('savings.*')" class="flex items-center gap-2 group">
                            <i class="fas fa-piggy-bank text-xs group-hover:scale-110 transition-transform"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">{{ __('Special Savings') }}</span>
                        </x-nav-link>

                        <x-nav-link :href="route('contributions.index')" :active="request()->routeIs('contributions.*')" class="flex items-center gap-2 group">
                            <i class="fas fa-hand-holding-heart text-xs group-hover:scale-110 transition-transform"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">{{ __('Investments') }}</span>
                        </x-nav-link>

                        <x-nav-link :href="route('loans.index')" :active="request()->routeIs('loans.*')" class="flex items-center gap-2 group">
                            <i class="fas fa-hand-holding-usd text-xs group-hover:scale-110 transition-transform"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">{{ __('Loans') }}</span>
                        </x-nav-link>
 
                        <x-nav-link :href="route('support.index')" :active="request()->routeIs('support.*')" class="flex items-center gap-2 group">
                            <i class="fas fa-headset text-sm"></i>
                            {{ __('Support') }}
                        </x-nav-link>

                        <!-- Special Loans Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ml-4">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center text-[11px] font-black text-gray-400 hover:text-gold transition duration-150 ease-in-out uppercase tracking-widest gap-2">
                                        <i class="fas fa-star text-xs text-gold animate-pulse"></i>
                                        <span>Special Loans</span>
                                        <i class="fas fa-chevron-down text-[8px] ml-1 opacity-50"></i>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Select & Apply') }}</div>
                                    <x-dropdown-link :href="route('loans.apply.asset')">
                                        <i class="fas fa-couch mr-2 text-purple-600"></i> {{ __('Asset Acquisition') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('loans.apply.ramadan_sallah')">
                                        <i class="fas fa-star-and-crescent mr-2 text-gold"></i> {{ __('Ramadan/Sallah') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('loans.apply.motorcycle')">
                                        <i class="fas fa-motorcycle mr-2 text-blue-600"></i> {{ __('Motorcycle Purchase') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    {{-- Ultra-Compact Admin Shortcuts --}}
                @if(Auth::user()->isAdmin() && in_array(Auth::user()->approval_order, [1, 2, 4]))
                    <div class="flex items-center gap-2 ml-4">
                        <a href="{{ route('admin.loans.index') }}" title="Loan Management" class="w-9 h-9 rounded-xl flex items-center justify-center bg-white/5 text-gray-300 hover:bg-gold hover:text-white transition-all shadow-inner border border-white/5 group">
                            <i class="fas fa-gem text-xs group-hover:scale-110"></i>
                        </a>
                        <a href="{{ route('savings.create') }}" title="Record Transaction" class="w-9 h-9 rounded-xl flex items-center justify-center bg-white/5 text-gray-300 hover:bg-army-green hover:text-white transition-all shadow-inner border border-white/5 group">
                            <i class="fas fa-plus-circle text-xs group-hover:rotate-90 transition-transform"></i>
                        </a>
                    </div>
                @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                @if(Auth::user()->isStaff() && !Auth::user()->canManageAnnouncements())
                    @php
                        $pendingLoans = \App\Models\Loan::where('status', 'pending')->count();
                        $pendingSavings = \App\Models\Saving::where('status', 'pending')->count();
                        $pendingMembers = \App\Models\Member::where('status', 'pending')->count();
                        $totalPending = $pendingLoans + $pendingSavings + $pendingMembers;
                    @endphp
                    
                    <div class="relative" x-data="{ openNotifications: false }" @click.outside="openNotifications = false">
                        <button @click="openNotifications = !openNotifications" class="flex items-center text-gray-400 hover:text-gold transition-colors relative p-2 rounded-xl hover:bg-white/5">
                            <i class="fas fa-bell text-xl"></i>
                            @if($totalPending > 0)
                                <span class="absolute top-1 right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-black text-white ring-2 ring-[#0B1A14]">
                                    {{ $totalPending }}
                                </span>
                            @endif
                        </button>
                        
                        <!-- Mini Notification Dropdown -->
                        <div x-show="openNotifications"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-72 bg-[#0E211A] rounded-2xl shadow-[0_0_30px_rgba(16,185,129,0.2)] border border-emerald-900/50 z-50 overflow-hidden"
                             style="display: none;">
                            <div class="px-5 py-4 border-b border-white/5 flex justify-between items-center bg-white/5">
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Pending Tasks</h3>
                                @if($totalPending > 0)
                                    <span class="bg-red-500/20 text-red-500 px-2 py-0.5 rounded-full text-[9px] font-black uppercase">{{ $totalPending }} Actions</span>
                                @endif
                            </div>
                            <div class="divide-y divide-white/5">
                                <a href="{{ route('admin.loans.index', ['status' => 'pending']) }}" class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors">
                                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center shrink-0">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-200">Loan Applications</p>
                                        <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">{{ $pendingLoans }} items awaiting review</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
                                </a>
                                <a href="{{ route('savings.index', ['status' => 'pending']) }}" class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors">
                                    <div class="w-10 h-10 rounded-xl bg-green-500/10 text-green-400 flex items-center justify-center shrink-0">
                                        <i class="fas fa-piggy-bank"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-200">Savings Deposits</p>
                                        <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">{{ $pendingSavings }} proofs to verify</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
                                </a>
                                <a href="{{ route('members.index', ['status' => 'pending']) }}" class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors">
                                    <div class="w-10 h-10 rounded-xl bg-gold/10 text-gold flex items-center justify-center shrink-0">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-200">Registrations</p>
                                        <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">{{ $pendingMembers }} members pending</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
                                </a>
                            </div>
                            <a href="{{ route('dashboard') }}" class="block px-5 py-3 bg-white/5 text-center text-[10px] font-black text-gold uppercase tracking-widest hover:bg-gold hover:text-white transition-all">
                                Go to Command Center
                            </a>
                        </div>
                    </div>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-emerald-900/50 text-[11px] leading-4 font-black rounded-xl text-emerald-100/70 bg-[#0B1A14] hover:text-emerald-400 hover:bg-emerald-900/30 transition-all gap-3 shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)]">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover ring-2 ring-gold/20">
                            @else
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-gold to-yellow-600 text-white flex items-center justify-center font-black text-xs shadow-lg">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="uppercase tracking-widest">{{ Auth::user()->name }}</div>
                            <i class="fas fa-chevron-down text-[8px] opacity-40"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger & Mobile Notifications -->
            <div class="-me-2 flex items-center sm:hidden gap-2">
                @if(Auth::user()->isStaff() && !Auth::user()->canManageAnnouncements())
                    @php
                        $pendingLoans = \App\Models\Loan::where('status', 'pending')->count();
                        $pendingSavings = \App\Models\Saving::where('status', 'pending')->count();
                        $pendingMembers = \App\Models\Member::where('status', 'pending')->count();
                        $totalPending = $pendingLoans + $pendingSavings + $pendingMembers;
                    @endphp
                    
                    <div class="relative mr-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center text-gray-400 hover:text-gold transition-colors relative p-2 rounded-xl hover:bg-white/5">
                            <i class="fas fa-bell text-xl"></i>
                            @if($totalPending > 0)
                                <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[8px] font-black text-white ring-2 ring-[#0B1A14]">
                                    {{ $totalPending }}
                                </span>
                            @endif
                        </a>
                    </div>
                @endif

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 focus:outline-none focus:bg-white/5 focus:text-white transition duration-150 ease-in-out border border-transparent hover:border-white/10">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-2">
                <i class="fas fa-th-large text-sm"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @can('manage-members')
                <x-responsive-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')" class="flex items-center gap-2">
                    <i class="fas fa-users text-sm"></i>
                    {{ __('Members') }}
                </x-responsive-nav-link>
            @endcan

            @if(Auth::user()->isStaff())
                @can('manage-savings')
                    <x-responsive-nav-link :href="route('savings.index')" :active="request()->routeIs('savings.index')" class="flex items-center gap-2">
                        <i class="fas fa-piggy-bank text-sm"></i>
                        {{ __('Special Savings') }}
                    </x-responsive-nav-link>
                @endcan

                @can('manage-contributions')
                    <x-responsive-nav-link :href="route('contributions.index')" :active="request()->routeIs('contributions.*')" class="flex items-center gap-2">
                        <i class="fas fa-hand-holding-heart text-sm"></i>
                        {{ __('Investments') }}
                    </x-responsive-nav-link>
                @endcan

                @can('manage-loans')
                    <x-responsive-nav-link :href="route('admin.loans.index')" :active="request()->routeIs('admin.loans.*') || request()->routeIs('loans.index')" class="flex items-center gap-2">
                        <i class="fas fa-hand-holding-usd text-sm"></i>
                        {{ __('Loans') }}
                    </x-responsive-nav-link>
                @endcan

                @can('manage-repayments')
                    <x-responsive-nav-link :href="route('repayments.index')" :active="request()->routeIs('repayments.*')" class="flex items-center gap-2">
                        <i class="fas fa-coins text-sm"></i>
                        {{ __('Repayments') }}
                    </x-responsive-nav-link>
                @endcan

                @can('manage-announcements')
                    <x-responsive-nav-link :href="route('admin.announcements.index')" :active="request()->routeIs('admin.announcements.*')" class="flex items-center gap-2">
                        <i class="fas fa-bullhorn text-sm"></i>
                        {{ __('Announcements') }}
                    </x-responsive-nav-link>
                @endcan

                @if(Auth::user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.vendors.index')" :active="request()->routeIs('admin.vendors.*')" class="flex items-center gap-2">
                        <i class="fas fa-store text-sm"></i>
                        {{ __('Vendors') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.loan-products.index')" :active="request()->routeIs('admin.loan-products.*')" class="flex items-center gap-2">
                        <i class="fas fa-boxes text-sm"></i>
                        {{ __('Product Catalog') }}
                    </x-responsive-nav-link>
                @endif
            @else
                {{-- Member Responsive Navigation --}}
                <x-responsive-nav-link :href="route('savings.index')" :active="request()->routeIs('savings.*')" class="flex items-center gap-2">
                    <i class="fas fa-piggy-bank text-sm"></i>
                    {{ __('Special Savings') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('contributions.index')" :active="request()->routeIs('contributions.*')" class="flex items-center gap-2">
                    <i class="fas fa-hand-holding-heart text-sm"></i>
                    {{ __('Investments') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('loans.index')" :active="request()->routeIs('loans.*')" class="flex items-center gap-2">
                    <i class="fas fa-hand-holding-usd text-sm"></i>
                    {{ __('Loans') }}
                </x-responsive-nav-link>

                <div class="border-t border-gray-100 my-1"></div>
                <div class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Special Loans') }}</div>
                
                <x-responsive-nav-link :href="route('loans.apply.asset')" :active="request()->routeIs('loans.apply.asset')" class="flex items-center gap-2">
                    <i class="fas fa-couch text-sm text-purple-600"></i>
                    {{ __('Asset Acquisition') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('loans.apply.ramadan_sallah')" :active="request()->routeIs('loans.apply.ramadan_sallah')" class="flex items-center gap-2">
                    <i class="fas fa-star-and-crescent text-sm text-gold"></i>
                    {{ __('Ramadan/Sallah') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('loans.apply.motorcycle')" :active="request()->routeIs('loans.apply.motorcycle')" class="flex items-center gap-2">
                    <i class="fas fa-motorcycle text-sm text-blue-600"></i>
                    {{ __('Motorcycle Purchase') }}
                </x-responsive-nav-link>
            @endif
 
            <x-responsive-nav-link :href="Auth::user()->isStaff() ? route('admin.support.index') : route('support.index')" :active="request()->routeIs('support.*') || request()->routeIs('admin.support.*')" class="flex items-center gap-2">
                <i class="fas fa-headset text-sm"></i>
                {{ __('Support') }}
            </x-responsive-nav-link>
 
            @can('view-cashbook')
                <x-responsive-nav-link :href="route('cashbook.index')" :active="request()->routeIs('cashbook.*')" class="flex items-center gap-2">
                    <i class="fas fa-file-invoice-dollar text-sm"></i>
                    {{ __('Cashbook') }}
                </x-responsive-nav-link>
            @endcan
            
            @if(Auth::user()->isAdmin() && !Auth::user()->canManageAnnouncements())
                <x-responsive-nav-link :href="route('committee.dashboard')" :active="request()->routeIs('committee.dashboard')" class="flex items-center gap-2">
                    <i class="fas fa-users-cog text-sm"></i>
                    {{ __('Committee') }}
                </x-responsive-nav-link>
            @endif

            {{-- Compact Responsive Admin Shortcuts --}}
        @if(Auth::user()->isAdmin() && in_array(Auth::user()->approval_order, [1, 2, 4]))
            <div class="px-3 py-2 grid grid-cols-2 gap-2 mt-2 border-t border-white/10">
                <x-responsive-nav-link :href="route('admin.loans.index')" :active="request()->routeIs('admin.loans.index')" class="bg-white/5 text-gray-300 hover:bg-gold hover:text-white rounded-lg text-center text-[10px] font-bold uppercase tracking-wider py-2 border border-white/10 transition-all">
                    <i class="fas fa-gem mr-1"></i> {{ __('Loans') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('savings.create')" :active="request()->routeIs('savings.create')" class="bg-white/5 text-gray-300 hover:bg-army-green hover:text-white rounded-lg text-center text-[10px] font-bold uppercase tracking-wider py-2 border border-white/10 transition-all">
                    <i class="fas fa-plus-circle mr-1"></i> {{ __('Record') }}
                </x-responsive-nav-link>
            </div>
        @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10 bg-white/5">
            <div class="px-4">
                <div class="font-black text-base text-white uppercase tracking-widest">{{ Auth::user()->name }}</div>
                <div class="font-bold text-xs text-gray-400">
                    @if(Auth::user()->isAdmin())
                        {{ Auth::user()->email }}
                    @else
                        {{ Auth::user()->member->file_number ?? Auth::user()->email }}
                    @endif
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
