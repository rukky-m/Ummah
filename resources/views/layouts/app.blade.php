<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>NSUK Ummah Multi-Purpose Cooperative Society (NUMCSU)</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- PWA Meta Tags -->
        <meta name="theme-color" content="#053123">
        <link rel="manifest" href="/manifest.json">
        <link rel="apple-touch-icon" href="{{ asset('images/pwa_icon_192.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .bg-logo-pattern {
                background-color: transparent;
                background-image: radial-gradient(#10b981 0.5px, transparent 0.5px);
                background-size: 40px 40px;
                opacity: 0.1;
                pointer-events: none;
                position: absolute;
                inset: 0;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-dark-bg text-white selection:bg-army-green selection:text-white transition-colors duration-300"
          x-data="{ showPwaPrompt: false, showContributionRules: false }"
          @show-pwa-prompt.window="showPwaPrompt = true"
          @hide-pwa-prompt.window="showPwaPrompt = false">
        
        {{-- PWA Installation Popup --}}
        <div x-show="showPwaPrompt" 
             style="display: none;"
             class="fixed inset-0 z-[200] flex items-end sm:items-center justify-center p-4 sm:p-6 pointer-events-none">
            <div x-show="showPwaPrompt"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 sm:scale-95"
                 class="w-full max-w-sm bg-dark-surface border border-dark-border rounded-3xl shadow-2xl pointer-events-auto overflow-hidden">
                
                <div class="relative p-6">
                    {{-- Close Button --}}
                    <button @click="window.dismissPWA(false)" class="absolute top-4 right-4 text-gray-500 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 rounded-2xl bg-army-green/10 flex items-center justify-center text-army-green border border-army-green/20 overflow-hidden">
                            <img src="{{ asset('images/pwa_icon_192.png') }}" alt="App Icon" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-white leading-tight">Install Ummah App</h3>
                            <p class="text-xs text-emerald-100/60">Access your cooperative secretariate faster from your home screen.</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button @click="window.installPWA()" 
                                class="w-full py-3.5 bg-army-green hover:bg-emerald-600 text-white font-black uppercase tracking-widest text-xs rounded-xl transition-all shadow-lg shadow-army-green/20 flex items-center justify-center gap-2">
                            <i class="fas fa-download"></i>
                            <span>Install Now</span>
                        </button>
                        
                        <div class="flex gap-2">
                             <button @click="window.dismissPWA(false)" 
                                    class="flex-1 py-3 bg-dark-bg text-gray-400 font-bold uppercase tracking-widest text-[10px] rounded-xl border border-dark-border hover:bg-dark-border transition">
                                Not Now
                            </button>
                            <button @click="if(confirm('This will stop the install prompt from appearing. You can still install the app from your Profile page later. Continue?')) { window.dismissPWA(true); }" 
                                    class="flex-1 py-3 bg-dark-bg text-red-500/50 hover:text-red-500 font-bold uppercase tracking-widest text-[10px] rounded-xl border border-dark-border hover:bg-dark-border transition">
                                Don't Install
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="min-h-screen bg-dark-bg relative overflow-hidden transition-colors duration-300">
            <!-- Background Logo Pattern Overlay -->
            <div class="absolute inset-0 bg-logo-pattern"></div>
            
            <!-- Enterprise Background Pattern -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiMzMzQxNTUiIGZpbGwtb3BhY2l0eT0iMC4yIi8+PC9zdmc+')] [mask-image:linear-gradient(to_bottom,white,transparent)] pointer-events-none"></div>

            <div class="relative z-10">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-dark-surface border-b border-dark-border shadow-sm transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="pb-20 sm:pb-0">
                {{ $slot }}
            </main>

            {{-- Mobile Bottom Navigation + Services Modal (hidden on desktop) --}}
            <div class="sm:hidden" x-data="{ servicesOpen: false }">

                {{-- Bottom Nav Bar --}}
                <nav class="fixed bottom-0 left-0 right-0 z-50 bg-dark-surface border-t border-dark-border shadow-[0_-4px_20px_rgba(0,0,0,0.3)]">
                    <div class="flex items-center justify-around h-16 px-2 relative">

                        @if(Auth::user()->isStaff())
                            {{-- Home --}}
                            <a href="{{ route('dashboard') }}"
                               class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                      {{ request()->routeIs('dashboard') ? 'text-army-green' : 'text-gray-400' }}">
                                <i class="fas fa-th-large text-lg"></i>
                                <span class="text-[9px] font-black uppercase tracking-widest">Home</span>
                            </a>

                            {{-- Members OR Savings (Fallback) --}}
                            @if(Auth::user()->canManageMembers())
                                <a href="{{ route('members.index') }}"
                                   class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                          {{ request()->routeIs('members.*') ? 'text-army-green' : 'text-gray-400' }}">
                                    <i class="fas fa-users text-lg"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Members</span>
                                </a>
                            @else
                                <a href="{{ route('savings.index') }}"
                                   class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                          {{ request()->routeIs('savings.*') || request()->routeIs('contributions.*') ? 'text-army-green' : 'text-gray-400' }}">
                                    <i class="fas fa-piggy-bank text-lg"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Savings</span>
                                </a>
                            @endif

                        @else
                            {{-- MEMBER BOTTOM NAV (always 5) --}}
                            <a href="{{ route('dashboard') }}"
                               class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                      {{ request()->routeIs('dashboard') ? 'text-army-green' : 'text-gray-400' }}">
                                <i class="fas fa-th-large text-lg"></i>
                                <span class="text-[9px] font-black uppercase tracking-widest">Home</span>
                            </a>

                            <a href="{{ route('savings.index') }}"
                               class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                      {{ request()->routeIs('savings.*') ? 'text-army-green' : 'text-gray-400' }}">
                                <i class="fas fa-piggy-bank text-lg"></i>
                                <span class="text-[9px] font-black uppercase tracking-widest">Savings</span>
                            </a>
                        @endif

                        {{-- FLOATING + BUTTON (center) --}}
                        <div class="flex flex-col items-center justify-center relative" style="margin-top:-28px">
                            <button @click="servicesOpen = true"
                                class="w-14 h-14 rounded-full bg-army-green text-white flex items-center justify-center shadow-2xl shadow-army-green/40 active:scale-95 transition-all border-4 border-dark-surface"
                                :class="servicesOpen ? 'rotate-45' : 'rotate-0'"
                                style="transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)">
                                <i class="fas fa-plus text-xl"></i>
                            </button>
                            <span class="text-[8px] font-black uppercase tracking-[0.2em] text-emerald-100/40 mt-1.5 transition-opacity" :class="servicesOpen ? 'opacity-0' : 'opacity-100'">More</span>
                        </div>

                        @if(Auth::user()->isStaff())
                            {{-- Financials OR Loans (Fallback) --}}
                            @if(Auth::user()->canManageSavings() || Auth::user()->canManageLoans())
                                <a href="{{ route('savings.index', ['view' => 'financials']) }}"
                                   class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                          {{ request()->routeIs('savings.*') || request()->routeIs('admin.loans.*') || request()->routeIs('repayments.*') ? 'text-army-green' : 'text-gray-400' }}">
                                    <i class="fas fa-wallet text-lg"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Financials</span>
                                </a>
                            @else
                                <a href="{{ route('admin.loans.index') }}"
                                   class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                          {{ request()->routeIs('admin.loans.*') ? 'text-army-green' : 'text-gray-400' }}">
                                    <i class="fas fa-hand-holding-usd text-lg"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Loans</span>
                                </a>
                            @endif

                            {{-- Cashbook OR Profile (Fallback) --}}
                            @if(Auth::user()->canViewCashbook())
                                <a href="{{ route('cashbook.index') }}"
                                   class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                          {{ request()->routeIs('cashbook.*') ? 'text-army-green' : 'text-gray-400' }}">
                                    <i class="fas fa-file-invoice-dollar text-lg"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Cashbook</span>
                                </a>
                            @else
                                <a href="{{ route('profile.edit') }}"
                                   class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                          {{ request()->routeIs('profile.*') ? 'text-army-green' : 'text-gray-400' }}">
                                    <i class="fas fa-user-circle text-lg"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest">Profile</span>
                                </a>
                            @endif

                        @else
                            {{-- Contrib / Loans always for members --}}
                            <a href="{{ route('contributions.index') }}"
                               class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                      {{ request()->routeIs('contributions.*') ? 'text-army-green' : 'text-gray-400' }}">
                                <i class="fas fa-hand-holding-heart text-lg"></i>
                                <span class="text-[9px] font-black uppercase tracking-widest">Contribute</span>
                            </a>

                            <a href="{{ route('loans.index') }}"
                               class="flex flex-col items-center justify-center gap-1 min-w-[48px] transition-colors
                                      {{ request()->routeIs('loans.*') ? 'text-army-green' : 'text-gray-400' }}">
                                <i class="fas fa-hand-holding-usd text-lg"></i>
                                <span class="text-[9px] font-black uppercase tracking-widest">Loans</span>
                            </a>
                        @endif

                    </div>
                </nav>

                {{-- Services Bottom-Sheet Modal --}}
                <div x-show="servicesOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-[100] bg-gray-900/60 backdrop-blur-sm"
                     @click="servicesOpen = false"
                     style="display:none">
                </div>

                <div x-show="servicesOpen"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-full"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-full"
                     class="fixed bottom-0 left-0 right-0 z-[101] bg-dark-surface rounded-t-3xl shadow-2xl pb-24 pt-6 px-6"
                     style="display:none">

                    {{-- Handle --}}
                    <div class="w-10 h-1 bg-dark-border rounded-full mx-auto mb-6"></div>

                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-emerald-100/60 mb-5">All Services</h3>

                    <div class="space-y-2">

                        @if(Auth::user()->isStaff())
                            @can('manage-contributions')
                            <a href="{{ route('contributions.index') }}" @click="servicesOpen = false"
                               class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 border border-transparent hover:border-gold/20 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-gold/10 flex items-center justify-center text-gold group-hover:bg-gold group-hover:text-white transition-all">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-black text-white">Contributions</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">Monthly capital contributions</p>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                            </a>
                            @endcan

                            @can('manage-repayments')
                            <a href="{{ route('repayments.index') }}" @click="servicesOpen = false"
                               class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 border border-transparent hover:border-blue-500/30 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-black text-white">Repayments</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">Manage loan repayments</p>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                            </a>
                            @endcan

                            @can('manage-announcements')
                            <a href="{{ route('admin.announcements.index') }}" @click="servicesOpen = false"
                               class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 border border-transparent hover:border-red-500/30 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-all">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-black text-white">Announcements</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">Post community notices</p>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                            </a>
                            @endcan

                            @if(Auth::user()->isAdmin() && !Auth::user()->canManageAnnouncements())
                            <a href="{{ route('committee.dashboard') }}" @click="servicesOpen = false"
                               class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 border border-transparent hover:border-army-green/30 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-army-green/10 flex items-center justify-center text-army-green group-hover:bg-army-green group-hover:text-white transition-all">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-black text-white">Committee</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">5-step approval pipeline</p>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                            </a>
                            @endif

                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.vendors.index') }}" @click="servicesOpen = false"
                               class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 border border-transparent hover:border-purple-500/30 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-400 group-hover:bg-purple-500 group-hover:text-white transition-all">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-black text-white">Vendors</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">Manage cooperative vendors</p>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                            </a>
                            @endif
 
                            <a href="{{ route('admin.support.index') }}" @click="servicesOpen = false"
                               class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 border border-transparent hover:border-army-green/30 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-army-green/10 flex items-center justify-center text-army-green group-hover:bg-army-green group-hover:text-white transition-all">
                                    <i class="fas fa-headset text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-black text-white">Support Center</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">Manage member inquiries</p>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                            </a>

                        @else
                            {{-- MEMBER extra services --}}
                            <a href="{{ route('loans.apply.asset') }}" @click="servicesOpen = false"
                               class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 border border-transparent hover:border-purple-500/30 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-400 group-hover:bg-purple-600 group-hover:text-white transition-all">
                                    <i class="fas fa-couch"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-black text-white">Asset Acquisition</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">Apply for asset loan</p>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                            </a>

                            <a href="{{ route('loans.apply.ramadan_sallah') }}" @click="servicesOpen = false"
                               class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 border border-transparent hover:border-gold/30 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-gold/10 flex items-center justify-center text-gold group-hover:bg-gold group-hover:text-white transition-all">
                                    <i class="fas fa-star-and-crescent"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-black text-white">Ramadan / Sallah</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">Seasonal commodity loan</p>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                            </a>

                            <a href="{{ route('loans.apply.motorcycle') }}" @click="servicesOpen = false"
                               class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 border border-transparent hover:border-blue-500/30 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                    <i class="fas fa-motorcycle"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-black text-white">Motorcycle Loan</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">Apply for motorcycle purchase</p>
                                </div>
                                 <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                            </a>
 
                            <a href="{{ route('support.index') }}" @click="servicesOpen = false"
                               class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 border border-transparent hover:border-army-green/30 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-army-green/10 flex items-center justify-center text-army-green group-hover:bg-army-green group-hover:text-white transition-all">
                                    <i class="fas fa-headset text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-black text-white">Customer Support</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">Get help with your account</p>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                            </a>
                        @endif

                        {{-- Profile & Logout — always shown --}}
                        <a href="{{ route('profile.edit') }}" @click="servicesOpen = false"
                           class="flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 hover:bg-dark-border border border-transparent transition-all group">
                            <div class="w-11 h-11 rounded-2xl bg-dark-surface flex items-center justify-center text-gray-400 group-hover:bg-gray-700 group-hover:text-white transition-all">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-black text-white">My Profile</p>
                                <p class="text-[10px] text-emerald-100/60 font-medium">Account settings</p>
                            </div>
                            <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-4 p-4 rounded-2xl bg-dark-bg/50 hover:bg-red-900/20 border border-transparent hover:border-red-500/30 transition-all group">
                                <div class="w-11 h-11 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-all">
                                    <i class="fas fa-sign-out-alt"></i>
                                </div>
                                <div class="flex-1 text-left">
                                    <p class="text-sm font-black text-white">Sign Out</p>
                                    <p class="text-[10px] text-emerald-100/60 font-medium">Log out of your account</p>
                                </div>
                            </button>
                        </form>
                        <div class="pt-2">
                             <button @click="servicesOpen = false"
                                    class="w-full py-4 bg-dark-bg text-gray-400 font-black uppercase tracking-[0.2em] text-[10px] rounded-2xl border border-dark-border transition active:scale-95 hover:bg-dark-border flex items-center justify-center gap-2">
                                <i class="fas fa-times text-[9px]"></i>
                                <span>Close</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>


            </div> <!-- Close relative z-10 -->
        </div>
        <div class="fixed bottom-24 sm:bottom-5 right-5 z-50 flex flex-col gap-3 pointer-events-none"
             x-data="{ 
                notifications: [],
                add(message, type = 'success') {
                    this.notifications.push({ id: Date.now(), message, type });
                    setTimeout(() => { this.remove(this.notifications[this.notifications.length - 1].id) }, 5000);
                },
                remove(id) {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                }
             }"
             @notify.window="add($event.detail.message, $event.detail.type)"
             x-init='
                @if(session("success")) add(@json(session("success")), "success"); @endif
                @if(session("error")) add(@json(session("error")), "error"); @endif
             '>
            <template x-for="notification in notifications" :key="notification.id">
                <div x-show="true"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     class="pointer-events-auto px-6 py-4 rounded-xl shadow-xl flex items-center gap-3 min-w-[300px] border border-dark-border"
                     :class="{
                        'bg-dark-surface border-l-4 border-green-500 text-white': notification.type === 'success',
                        'bg-dark-surface border-l-4 border-red-500 text-white': notification.type === 'error'
                     }">
                     <div class="h-8 w-8 rounded-full flex items-center justify-center shrink-0"
                          :class="{
                              'bg-green-100 text-green-600': notification.type === 'success',
                              'bg-red-100 text-red-600': notification.type === 'error'
                          }">
                        <i class="fas" :class="{
                            'fa-check': notification.type === 'success',
                            'fa-exclamation': notification.type === 'error'
                        }"></i>
                     </div>
                     <div>
                        <p class="font-black text-xs uppercase tracking-widest opacity-50" x-text="notification.type"></p>
                        <p class="font-bold text-sm" x-text="notification.message"></p>
                     </div>
                </div>
            </template>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Global Loading State for Forms
                document.body.addEventListener('submit', function(e) {
                    const form = e.target;
                    // Don't show loading if validation prevents submission (HTML5)
                    if (!form.checkValidity()) return;

                    const btn = form.querySelector('button[type=\'submit\']');
                    if (btn && !btn.classList.contains('no-loading')) {
                        // Store original content
                        if (!btn.dataset.originalContent) {
                            btn.dataset.originalContent = btn.innerHTML;
                        }
                        
                        // Style updates
                        btn.style.width = getComputedStyle(btn).width; // Prevent resizing
                        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
                        btn.classList.add('opacity-75', 'cursor-not-allowed');
                        
                        // Disable strictly after a small tick to allow form data to be gathered
                        setTimeout(() => btn.disabled = true, 0);
                    }
                }, true); // Use capture phase
            });
        </script>
    </body>
</html>
