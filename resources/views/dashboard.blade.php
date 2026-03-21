<x-app-layout>
    {{-- Mobile-only top header: avatar + name on left, notification bell on right --}}
    <x-slot name="header">
        {{-- Desktop: Welcome Message + Avatar + Date --}}
        <div class="hidden sm:flex justify-between items-center bg-dark-surface p-6 rounded-3xl border border-dark-border shadow-md transition-all duration-300">
            <div class="flex items-center gap-4">
                @if(Auth::user()->profile_photo_path)
                    <img class="w-14 h-14 rounded-2xl object-cover shadow-lg border-2 border-dark-border" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-gold to-yellow-600 flex items-center justify-center text-dark-bg font-black text-2xl uppercase shadow-lg border-2 border-dark-border">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="font-black text-2xl text-white leading-tight tracking-tight">
                        Welcome back, {{ explode(' ', Auth::user()->name)[0] }}!
                    </h2>
                    <p class="text-sm font-bold text-emerald-100/60 italic mt-0.5">
                        <i class="fas fa-calendar-alt mr-1 text-gold"></i>
                        <span x-data="{ 
                            date: new Date(), 
                            formatDate(date) {
                                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                                return date.toLocaleDateString('en-GB', options);
                            }
                        }" x-init="setInterval(() => date = new Date(), 60000)">
                            <span x-text="formatDate(date)">{{ now()->format('l, jS F Y') }}</span>
                        </span>
                    </p>
                </div>
            </div>
            
            {{-- Quick Stats / Status indicator for Admin/Staff --}}
            @if(Auth::user()->isStaff())
                <div class="flex items-center gap-3">
                    <div class="text-right mr-3 hidden lg:block">
                        <p class="text-[10px] font-black text-emerald-100/60 uppercase tracking-widest">System Status</p>
                        <p class="text-[11px] font-bold text-gold flex items-center justify-end gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-gold animate-ping"></span>
                            Operational
                        </p>
                    </div>
                    <div class="h-10 w-[1px] bg-dark-border mx-2 hidden lg:block"></div>
                </div>
            @endif
        </div>
        {{-- Mobile-only: Avatar + First Name + Notification Bell --}}
        <div class="flex sm:hidden justify-between items-center">
            {{-- Avatar + First Name --}}
            <div class="flex items-center gap-3">
                @if(Auth::user()->profile_photo_path)
                    <img class="w-10 h-10 rounded-full object-cover shadow-sm border border-dark-border" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gold to-yellow-600 flex items-center justify-center text-dark-bg font-black text-base uppercase shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex flex-col">
                    <p class="text-[10px] text-emerald-100/60 font-medium leading-none mb-0.5">Welcome back,</p>
                    <p class="text-sm font-black text-white leading-none">{{ explode(' ', Auth::user()->name)[0] }}</p>
                </div>
            </div>

            {{-- Notification Bell --}}
            <a href="{{ url('/notifications') }}" class="relative w-10 h-10 rounded-full bg-dark-surface border border-dark-border shadow-sm flex items-center justify-center text-emerald-100/60 hover:text-gold transition-colors active:scale-95">
                <i class="fas fa-bell text-base"></i>
                @php
                    $unreadCount = Auth::user()->notifications()->whereNull('read_at')->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ showContributionRules: false }" @open-contribution-rules.window="showContributionRules = true">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(!Auth::user()->isStaff() && Auth::user()->member)
                <!-- Dynamic Hero Balance Card (Member Only) -->
                <div class="relative overflow-hidden bg-gradient-to-br from-dark-surface to-dark-bg border border-gold/20 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-gold/5 mb-6 group" x-data="{ showBalance: true }">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gold/10 rounded-full -mr-20 -mt-20 blur-3xl group-hover:bg-gold/20 transition-all duration-700"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-army-green/10 rounded-full -ml-10 -mb-10 blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-[0.25em] text-emerald-100/60 mb-1 leading-none">NSUK UMMAH COOPERATIVE</h4>
                                <div class="h-1 w-8 bg-gold rounded-full"></div>
                            </div>
                            <div class="px-3 py-1 bg-dark-bg/50 backdrop-blur-md rounded-full border border-gold/20 flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-gold animate-pulse"></div>
                                <span class="text-[9px] font-black uppercase tracking-widest text-gold text-white">Member #{{ Auth::user()->id + 1000 }}</span>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs font-bold text-emerald-100/60 tracking-wide">Total Savings Hub</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-black text-gold">₦</span>
                                <span class="text-5xl font-black tracking-tighter text-white" x-text="showBalance ? '{{ number_format($data['closing_balance'] ?? 0, 2) }}' : '****.**'">
                                    {{ number_format($data['closing_balance'] ?? 0, 2) }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-dark-border flex items-center justify-between">
                            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-100/50 leading-none">Active Financial Member</p>
                            <div @click="showBalance = !showBalance" class="w-10 h-10 bg-dark-bg/50 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-gold/10 hover:border-gold/30 hover:text-gold transition-all cursor-pointer">
                                <i class="far" :class="showBalance ? 'fa-eye' : 'fa-eye-slash'" class="text-emerald-100/60 hover:text-gold transition-colors"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Error/Success Messages -->
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-bold">Error</p>
                            <p class="text-sm text-red-600">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 font-bold">Success</p>
                            <p class="text-sm text-green-600">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Announcements Section --}}
            @if(isset($announcements) && count($announcements) > 0)
                <div class="space-y-4 mb-6">
                    @foreach($announcements as $announcement)
                        @php
                            $styles = [
                                'info' => 'bg-blue-50 border-blue-200 text-blue-800 icon-blue-500',
                                'warning' => 'bg-red-50 border-red-200 text-red-800 icon-red-500',
                                'meeting' => 'bg-gold/10 border-gold/30 text-yellow-800 icon-gold',
                                'program' => 'bg-green-50 border-green-200 text-green-800 icon-green-500',
                            ];
                            $icons = [
                                'info' => 'fa-info-circle',
                                'warning' => 'fa-exclamation-triangle',
                                'meeting' => 'fa-users',
                                'program' => 'fa-calendar-alt',
                            ];
                            $style = $styles[$announcement->type] ?? $styles['info'];
                            $icon = $icons[$announcement->type] ?? 'fa-bullhorn';
                        @endphp
                        <div class="border-l-4 {{ explode(' ', $style)[1] }} {{ explode(' ', $style)[0] }} p-4 rounded-r-xl shadow-sm flex items-start gap-4">
                            <div class="shrink-0 mt-1">
                                <i class="fas {{ $icon }} text-xl {{ explode(' ', $style)[3] ?? 'text-gray-500' }}"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-sm uppercase tracking-wide mb-1 opacity-90">{{ $announcement->title }}</h4>
                                <p class="text-sm font-medium leading-relaxed opacity-80">{{ $announcement->message }}</p>
                                <p class="text-[10px] mt-2 font-bold opacity-60 uppercase tracking-widest">
                                    Posted {{ $announcement->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Loan Repayment Reminders --}}
            @if(!Auth::user()->isStaff() && isset($data['overdue_repayments']) && count($data['overdue_repayments']) > 0)
                <div class="space-y-4">
                    @foreach($data['overdue_repayments'] as $reminder)
                        <div class="bg-dark-surface border-l-4 {{ $reminder['status'] == 'pending' ? 'border-gold bg-yellow-900/10' : 'border-red-500 bg-red-900/10' }} p-6 rounded-3xl shadow-md border-y border-dark-border border-r flex flex-col md:flex-row justify-between items-center gap-4 transition-all hover:shadow-lg">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl {{ $reminder['status'] == 'pending' ? 'bg-gold/10 text-gold' : 'bg-red-500/10 text-red-500' }} flex items-center justify-center shrink-0 border {{ $reminder['status'] == 'pending' ? 'border-gold/20' : 'border-red-500/20' }}">
                                    <i class="fas {{ $reminder['status'] == 'pending' ? 'fa-clock' : 'fa-exclamation-triangle' }} text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-black text-white uppercase tracking-tight">
                                        Repayment Reminder: {{ $reminder['month'] }} {{ $reminder['year'] }}
                                    </h4>
                                    <p class="text-[11px] text-emerald-100/60 font-medium mt-1">
                                        @if($reminder['status'] == 'pending')
                                            Your proof for <span class="text-gold font-bold">₦{{ number_format($reminder['amount'], 2) }}</span> is waiting for admin verification.
                                        @else
                                            Monthly repayment of <span class="text-red-400 font-bold">₦{{ number_format($reminder['amount'], 2) }}</span> is due for your loan {{ $reminder['loan']->application_number }}.
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @if($reminder['status'] != 'pending')
                                <a href="{{ route('repayments.create', ['loan_id' => $reminder['loan']->id]) }}" class="bg-red-500 text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-red-900/20 hover:-translate-y-0.5 transition whitespace-nowrap border border-red-400">
                                    Submit Proof Now
                                </a>
                            @else
                                <span class="text-[10px] font-black uppercase tracking-widest text-gold bg-gold/10 border border-gold/20 px-4 py-2 rounded-full">Proof Submitted</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            @if(Auth::user()->isStaff())
                <!-- ADMIN DASHBOARD -->
                @if(!Auth::user()->canManageAnnouncements())
                    {{-- HERO BALANCE CARD --}}
                    {{-- PREMIUM HERO BALANCE CARD (ADMIN) --}}
                    <div class="relative overflow-hidden rounded-[2.5rem] bg-emerald-600 text-white p-8 shadow-2xl shadow-emerald-900/40 mb-6 group"
                         x-data="{ visible: true }">
                        {{-- Subtle pattern overlay --}}
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-20 -mt-20 blur-3xl group-hover:bg-white/10 transition-all duration-700"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-black/10 rounded-full -ml-10 -mb-10 blur-2xl"></div>

                        <div class="relative z-10">
                            {{-- Org name + members pill --}}
                            <div class="flex justify-between items-start mb-8">
                                <div>
                                    <h4 class="text-[10px] font-black uppercase tracking-[0.25em] text-emerald-100/80 mb-1 leading-none">NSUK UMMAH COOPERATIVE</h4>
                                    <div class="h-1 w-8 bg-gold rounded-full"></div>
                                </div>
                                <div class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-full border border-white/10 flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></div>
                                    <span class="text-[9px] font-black uppercase tracking-widest text-emerald-50">{{ $data['total_members'] ?? 0 }} Members</span>
                                </div>
                            </div>

                            {{-- Label and Balance --}}
                            <div class="space-y-1">
                                <p class="text-xs font-bold text-emerald-100/70 tracking-wide">Total Portfolio Value</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-2xl font-black text-emerald-200">₦</span>
                                        <span class="text-5xl font-black tracking-tighter" x-show="visible">{{ number_format(($data['total_savings'] ?? 0) + ($data['total_loans_balance'] ?? 0) + ($data['total_contributions'] ?? 0), 2) }}</span>
                                        <span x-show="!visible" class="text-5xl font-black tracking-[0.3em] text-white/50">••••••••</span>
                                    </div>
                                    <button @click="visible = !visible"
                                        class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center backdrop-blur-sm border border-white/5 hover:bg-white/20 transition-all">
                                        <i class="fas text-sm text-emerald-200" :class="visible ? 'fa-eye' : 'fa-eye-slash'"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Progress bar --}}
                            <div class="mt-8 pt-6 border-t border-white/10">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-100/60 leading-none">Active Financial Members</p>
                                    <span class="text-[10px] font-black text-emerald-100/40 tracking-widest">{{ $data['total_members'] ?? 0 }}</span>
                                </div>
                                <div class="w-full bg-black/10 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-gold h-full rounded-full" style="width: {{ min(100, (($data['total_members'] ?? 0) / max(1, 100)) * 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2×2 COMPACT STATS GRID --}}
                    {{-- 2×2 COMPACT STATS GRID (PREMIUM) --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        {{-- Savings --}}
                        <a href="{{ route('savings.index') }}"
                           class="bg-dark-surface rounded-[2rem] p-6 shadow-sm border border-dark-border transition-all hover:border-gold group flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 border border-emerald-500/20 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-piggy-bank text-sm"></i>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-700 group-hover:text-emerald-500 transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2 ml-1">Personal Savings</p>
                                <p class="text-xl font-black text-white tracking-tight ml-1">₦{{ number_format($data['total_savings'] ?? 0, 0) }}</p>
                            </div>
                        </a>

                        {{-- Contributions --}}
                        <a href="{{ route('contributions.index') }}"
                           class="bg-dark-surface rounded-[2rem] p-6 shadow-sm border border-dark-border transition-all hover:border-gold group flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-gold/10 flex items-center justify-center text-gold border border-gold/20 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-hand-holding-heart text-sm"></i>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-700 group-hover:text-gold transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2 ml-1">Contributions</p>
                                <p class="text-xl font-black text-white tracking-tight ml-1">₦{{ number_format($data['total_contributions'] ?? 0, 0) }}</p>
                            </div>
                        </a>

                        {{-- Active Loans --}}
                        <a href="{{ route('admin.loans.index') }}"
                           class="bg-dark-surface rounded-[2rem] p-6 shadow-sm border border-dark-border transition-all hover:border-gold group flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 border border-blue-500/20 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-hand-holding-usd text-sm"></i>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-700 group-hover:text-blue-500 transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2 ml-1">Loan Portfolio</p>
                                <p class="text-xl font-black text-white tracking-tight ml-1">₦{{ number_format($data['total_loans_balance'] ?? 0, 0) }}</p>
                            </div>
                        </a>

                        {{-- Pending Apps --}}
                        <a href="{{ route('admin.loans.index') }}"
                           class="bg-dark-surface rounded-[2rem] p-6 shadow-sm border border-dark-border transition-all hover:border-gold group flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500 border border-red-500/20 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-clock text-sm"></i>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-700 group-hover:text-red-500 transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-2 ml-1">Pending Apps</p>
                                <p class="text-xl font-black text-white tracking-tight ml-1">{{ $data['pending_loans'] ?? 0 }}</p>
                            </div>
                        </a>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div class="bg-dark-surface overflow-hidden shadow-2xl rounded-[2rem] p-8 border border-dark-border relative">
                        <h3 class="font-black text-sm mb-6 text-white flex items-center gap-2 uppercase tracking-[0.2em] opacity-80">
                            <i class="fas fa-tools text-gold text-xs"></i>
                            Admin Control Panel
                        </h3>
                        <div class="grid grid-cols-2 gap-4 relative z-10">
                            @if(!Auth::user()->canManageAnnouncements())
                                <a href="{{ route('members.index') }}" class="grid place-items-center content-center p-6 bg-dark-bg/50 rounded-2xl hover:bg-gold hover:text-white transition-all duration-300 group border border-dark-border hover:border-gold hover:shadow-xl hover:-translate-y-1 text-center">
                                    <i class="fas fa-users mb-2 text-2xl group-hover:scale-110 transition text-emerald-100/60 group-hover:text-white"></i>
                                    <span class="font-black text-[10px] text-white uppercase tracking-widest">Manage Members</span>
                                </a>
                                <a href="{{ route('savings.index') }}" class="grid place-items-center content-center p-6 bg-dark-bg/50 rounded-2xl hover:bg-gold hover:text-white transition-all duration-300 group border border-dark-border hover:border-gold hover:shadow-xl hover:-translate-y-1 text-center">
                                    <i class="fas fa-piggy-bank mb-2 text-2xl group-hover:scale-110 transition text-emerald-100/60 group-hover:text-white"></i>
                                    <span class="font-black text-[10px] text-white uppercase tracking-widest">Manage Savings</span>
                                </a>
                            @endif
                            
                            @can('manage-contributions')
                                <a href="{{ route('contributions.index') }}" class="grid place-items-center content-center p-6 bg-dark-bg/50 rounded-2xl hover:bg-gold hover:text-white transition-all duration-300 group border border-dark-border hover:border-gold hover:shadow-xl hover:-translate-y-1 text-center">
                                    <i class="fas fa-hand-holding-heart mb-2 text-2xl group-hover:scale-110 transition text-emerald-100/60 group-hover:text-white"></i>
                                    <span class="font-black text-[10px] text-white uppercase tracking-widest text-center">Contributions</span>
                                </a>
                            @endcan
                            
                            @can('manage-announcements')
                                <a href="{{ route('admin.announcements.index') }}" class="grid place-items-center content-center p-6 bg-dark-bg/50 rounded-2xl hover:bg-gold hover:text-white transition-all duration-300 group border border-dark-border hover:border-gold hover:shadow-xl hover:-translate-y-1 text-center {{ Auth::user()->canManageAnnouncements() ? 'col-span-2' : '' }}">
                                    <i class="fas fa-bullhorn mb-2 text-2xl group-hover:scale-110 transition text-emerald-100/60 group-hover:text-white"></i>
                                    <span class="font-black text-[10px] text-white uppercase tracking-widest">Announcements</span>
                                </a>
                            @endcan
                            
                            @can('view-cashbook')
                                <a href="{{ route('cashbook.index') }}" class="grid place-items-center content-center p-6 bg-dark-bg/50 rounded-2xl hover:bg-gold hover:text-white transition-all duration-300 group border border-dark-border hover:border-gold hover:shadow-xl hover:-translate-y-1 text-center">
                                    <i class="fas fa-book mb-2 text-2xl group-hover:scale-110 transition text-emerald-100/60 group-hover:text-white"></i>
                                    <span class="font-black text-[10px] text-white uppercase tracking-widest">Cashbook</span>
                                </a>
                            @endcan
                            
                            @can('manage-repayments')
                                <a href="{{ route('repayments.index') }}" class="grid place-items-center content-center p-6 bg-dark-bg/50 rounded-2xl hover:bg-gold hover:text-white transition-all duration-300 group border border-dark-border hover:border-gold hover:shadow-xl hover:-translate-y-1 text-center col-span-2">
                                    <i class="fas fa-hand-holding-usd mb-2 text-2xl group-hover:scale-110 transition text-emerald-100/60 group-hover:text-white"></i>
                                    <span class="font-black text-[10px] text-white uppercase tracking-widest">Loan Repayments Management</span>
                                </a>
                            @endcan

                            @can('manage-loans')
                                <div class="col-span-2 grid grid-cols-3 gap-4">
                                    <a href="{{ route('admin.loan-products.index', ['category' => 'asset']) }}" class="grid place-items-center content-center p-4 bg-purple-500/10 rounded-2xl border border-purple-500/20 hover:bg-gold hover:border-gold hover:text-white transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1">
                                        <i class="fas fa-couch mb-2 text-xl text-purple-400 group-hover:text-white transition"></i>
                                        <span class="font-black text-[9px] text-white uppercase tracking-tight">Post Assets</span>
                                    </a>
                                    <a href="{{ route('admin.loan-products.index', ['category' => 'ramadan']) }}" class="grid place-items-center content-center p-4 bg-gold/10 rounded-2xl border border-gold/20 hover:bg-gold hover:text-white transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1">
                                        <i class="fas fa-star-and-crescent mb-2 text-xl text-gold group-hover:text-white transition"></i>
                                        <span class="font-black text-[9px] text-white uppercase tracking-tight">Post Commodities</span>
                                    </a>
                                    <a href="{{ route('admin.loan-products.index', ['category' => 'motorcycle']) }}" class="grid place-items-center content-center p-4 bg-blue-500/10 rounded-2xl border border-blue-500/20 hover:bg-gold hover:border-gold hover:text-white transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1">
                                        <i class="fas fa-motorcycle mb-2 text-xl text-blue-400 group-hover:text-white transition"></i>
                                        <span class="font-black text-[9px] text-white uppercase tracking-tight">Post Motorcycles</span>
                                    </a>
                                    </a>
                                </div>
                            @endcan
                            @if(Auth::user()->isAdmin() && !Auth::user()->canManageAnnouncements())
                                <a href="{{ route('committee.dashboard') }}" class="grid place-items-center content-center p-6 bg-gradient-to-br from-gold/50 to-gold text-white rounded-2xl hover:from-gold hover:to-yellow-500 transition-all duration-300 group shadow-xl shadow-gold/20 hover:-translate-y-1 text-center col-span-2 relative overflow-hidden">
                                    <div class="absolute -right-4 -bottom-4 opacity-10">
                                        <i class="fas fa-users-cog text-6xl"></i>
                                    </div>
                                    <i class="fas fa-users-cog mb-2 text-2xl group-hover:scale-110 transition relative z-10 text-dark-bg"></i>
                                    <span class="font-black text-[10px] text-dark-bg uppercase tracking-widest relative z-10">Committee Dashboard</span>
                                    <span class="text-[8px] text-dark-bg/70 opacity-75 mt-1 relative z-10 font-bold tracking-widest">5-Step Approval Pipeline</span>
                                </a>
                            @elseif(!Auth::user()->isStaff())
                                <a href="{{ route('members.statement', Auth::user()->member) }}" class="grid place-items-center content-center p-6 bg-dark-bg/50 rounded-2xl hover:bg-gold hover:text-white transition-all duration-300 group border border-dark-border hover:border-gold hover:shadow-xl hover:-translate-y-1 text-center col-span-2">
                                    <i class="fas fa-file-invoice mb-2 text-2xl group-hover:scale-110 transition text-emerald-100/60 group-hover:text-white"></i>
                                    <span class="font-black text-[10px] text-white uppercase tracking-widest">View My Activities Report</span>
                                </a>
                            @endif
                        </div>
                     </div>

                     @if(!Auth::user()->canManageAnnouncements())
                         <div class="bg-dark-surface overflow-hidden shadow-2xl rounded-[2rem] p-8 border border-dark-border">
                            <h3 class="font-black text-sm mb-6 text-white flex items-center justify-between uppercase tracking-[0.2em] opacity-80">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-chart-line text-emerald-400 text-xs"></i>
                                    Cashflow Overview
                                </span>
                                <span class="text-[10px] font-black text-gray-500">{{ now()->format('F Y') }}</span>
                            </h3>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-emerald-500/5 p-5 rounded-2xl border border-emerald-500/10 transition-all hover:bg-emerald-500/10 group">
                                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-1 opacity-70">Inflow</p>
                                    <p class="text-2xl font-black text-white tracking-tighter">₦{{ number_format($data['monthly_income'] ?? 0, 0) }}</p>
                                </div>
                                <div class="bg-red-500/5 p-5 rounded-2xl border border-red-500/10 transition-all hover:bg-red-500/10 group">
                                    <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1 opacity-70">Outflow</p>
                                    <p class="text-2xl font-black text-white tracking-tighter">₦{{ number_format($data['monthly_expense'] ?? 0, 0) }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center bg-white/5 p-6 rounded-2xl border border-white/5 group hover:bg-white/10 transition-all">
                                 <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Balance</span>
                                 <span class="text-2xl font-black text-emerald-400 tracking-tighter">₦{{ number_format($data['closing_balance'] ?? 0, 2) }}</span>
                            </div>
                            </div>

                            <!-- Recent Transactions Mini-List -->
                            @if(isset($data['recent_transactions']) && $data['recent_transactions']->count() > 0)
                                <div class="mt-8 border-t border-white/10 pt-6">
                                    <h4 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                                        <i class="fas fa-history text-gray-600"></i> Latest Telemetry
                                    </h4>
                                    <div class="space-y-4">
                                        @foreach($data['recent_transactions'] as $tx)
                                            <div class="flex justify-between items-center text-sm group/tx">
                                                <div class="flex items-center gap-3">
                                                    <span class="w-8 h-8 rounded-xl flex items-center justify-center {{ $tx->type == 'income' ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }} border {{ $tx->type == 'income' ? 'border-green-500/20' : 'border-red-500/20' }}">
                                                        <i class="fas {{ $tx->type == 'income' ? 'fa-plus' : 'fa-minus' }} text-xs"></i>
                                                    </span>
                                                    <span class="text-[11px] font-bold text-gray-300 uppercase tracking-wider truncate max-w-[120px] group-hover/tx:text-white transition-colors">{{ $tx->category }}</span>
                                                </div>
                                                <span class="font-black {{ $tx->type == 'income' ? 'text-green-400' : 'text-red-400' }} tracking-tight">
                                                    {{ $tx->type == 'income' ? '+' : '-' }}₦{{ number_format($tx->amount, 0) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a href="{{ route('cashbook.index') }}" class="block text-center text-xs font-black uppercase tracking-widest text-emerald-400 hover:text-emerald-300 mt-6 transition">
                                        View Full Cashbook
                                        <i class="fas fa-arrow-right ml-2 text-[8px]"></i>
                                    </a>
                                    </a>
                                </div>
                            @endif
                         </div>
                     @endif
                </div>

                @if(!Auth::user()->canManageAnnouncements())
                    <!-- Global Member Activity Report (Admin) -->
                    <div id="member-activity-report" class="bg-dark-surface shadow-2xl rounded-[2rem] border border-dark-border overflow-hidden mt-6">
                        <div class="border-b border-white/5 px-8 py-6 flex justify-between items-center bg-white/5">
                            <h3 class="text-[10px] font-black text-white flex items-center gap-2 uppercase tracking-[0.2em] opacity-80">
                                <i class="fas fa-chart-pie text-emerald-400"></i>    
                                Global Member Activity Report
                            </h3>
                            <span class="text-[9px] font-black text-gray-500 uppercase tracking-widest">{{ now()->year }} Summary</span>
                        </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-white/5 border-b border-white/5">
                                        <th class="px-8 py-4 text-[9px] font-black text-gray-500 uppercase tracking-widest">Month/Year</th>
                                        <th class="px-8 py-4 text-[9px] font-black text-gray-500 uppercase tracking-widest text-right">Deposits Received</th>
                                        <th class="px-8 py-4 text-[9px] font-black text-gray-500 uppercase tracking-widest text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @forelse($globalMonthlySummary as $month => $amount)
                                        <tr class="hover:bg-white/5 transition-colors group">
                                            <td class="px-8 py-4">
                                                <span class="font-black text-white text-xs opacity-90">{{ $month }}</span>
                                            </td>
                                            <td class="px-8 py-4 text-right">
                                                <span class="font-black text-emerald-400 text-xs">₦{{ number_format($amount, 2) }}</span>
                                            </td>
                                            <td class="px-8 py-4 text-center">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                    <div class="w-1 h-1 rounded-full bg-emerald-400 animate-pulse"></div>
                                                    Active
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center text-gray-500">
                                                    <i class="fas fa-satellite-dish text-3xl mb-3 opacity-50"></i>
                                                    <span class="text-xs font-bold uppercase tracking-widest">No Telemetry Detected</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            @else
                <!-- MEMBER DASHBOARD -->
                
                @if(isset($data) && count($data) > 0)
                    <!-- Rejection Alert -->
                    @php
                        $latestLoan = $data['loans']->first();
                    @endphp
                    @if($latestLoan && $latestLoan->status == 'rejected')
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm mb-6 flex items-start gap-4">
                            <div class="shrink-0"><i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5"></i></div>
                            <div>
                                <h4 class="font-bold text-red-800">Loan Application Rejected</h4>
                                <p class="text-sm text-red-700 mt-1">
                                    Your loan application ({{ $latestLoan->application_number }}) was rejected. 
                                    @if($latestLoan->committeeApprovals->where('status', 'rejected')->last())
                                        Reason: <span class="font-bold">"{{ $latestLoan->committeeApprovals->where('status', 'rejected')->last()->comment }}"</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Summary Stats Grid -->
                    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                        <!-- My Contributions -->
                        <a href="{{ route('contributions.index') }}" class="bg-dark-surface rounded-[2rem] p-6 shadow-sm border border-dark-border transition-all hover:border-gold group block">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 border border-emerald-500/20 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-hand-holding-heart text-sm"></i>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-700 group-hover:text-emerald-500 transition-colors"></i>
                            </div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-1">Contributions</p>
                            <div class="text-xl font-black text-white tracking-tight ml-1">
                                ₦{{ number_format($data['my_contributions'] ?? 0, 0) }}
                            </div>
                        </a>

                        <!-- Outstanding Loan Balance -->
                        <div class="bg-dark-surface shadow-sm rounded-[2rem] p-6 border border-dark-border relative group">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500 border border-red-500/20">
                                    <i class="fas fa-hand-holding-usd text-sm"></i>
                                </div>
                            </div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-1">Loan Balance</p>
                            <div class="text-xl font-black text-white tracking-tight ml-1">
                                ₦{{ number_format($data['active_loans_balance'] ?? 0, 0) }}
                            </div>
                        </div>

                        <!-- Loan Balance -->
                        <a href="{{ route('loans.index') }}" class="bg-dark-surface rounded-[2rem] p-6 shadow-sm border border-dark-border transition-all hover:border-gold group block">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500 border border-red-500/20 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-hand-holding-usd text-sm"></i>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-700 group-hover:text-red-500 transition-colors"></i>
                            </div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-1">Loan Portfolio</p>
                            <div class="text-xl font-black text-white tracking-tight ml-1">
                                ₦{{ number_format($data['active_loans_balance'] ?? 0, 0) }}
                            </div>
                        </a>

                        <!-- Opening Balance -->
                        <a href="{{ route('savings.index') }}" class="bg-dark-surface rounded-[2rem] p-6 shadow-sm border border-dark-border transition-all hover:border-gold group block">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 border border-blue-500/20 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-calendar-check text-sm"></i>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-700 group-hover:text-blue-500 transition-colors"></i>
                            </div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-1">Opening Balance</p>
                            <div class="text-xl font-black text-white tracking-tight ml-1">
                                ₦{{ number_format($data['opening_balance'] ?? 0, 0) }}
                            </div>
                        </a>

                        <!-- Personal Savings -->
                        <a href="{{ route('savings.index', ['category' => 'Personal Savings']) }}" class="bg-dark-surface rounded-[2rem] p-6 shadow-sm border border-dark-border transition-all hover:border-gold group block">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-gold/10 flex items-center justify-center text-gold border border-gold/20 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-piggy-bank text-sm"></i>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-700 group-hover:text-gold transition-colors"></i>
                            </div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-1">Personal Savings</p>
                            <div class="text-xl font-black text-white tracking-tight ml-1">
                                ₦{{ number_format($data['my_savings'] ?? 0, 0) }}
                            </div>
                        </a>

                        <!-- Next Repayment / Active Apps -->
                        <a href="{{ route('repayments.create') }}" class="bg-dark-surface rounded-[2rem] p-6 shadow-sm border border-dark-border transition-all hover:border-gold group col-span-2 lg:col-span-1 block">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 border border-emerald-500/20 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-history text-sm"></i>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-gray-700 group-hover:text-emerald-500 transition-colors"></i>
                            </div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-3 ml-1">Next Repayment</p>
                            <div class="text-xl font-black text-white tracking-tight ml-1">
                                ₦{{ number_format($data['next_payment_amount'] ?? 0, 0) }}
                            </div>
                        </a>
                    </div>
                
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Quick Actions -->
                        <div class="lg:col-span-2 bg-dark-surface border border-dark-border overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="font-black text-lg mb-6 text-white flex items-center gap-2 uppercase tracking-widest">
                                <i class="fas fa-bolt text-gold"></i> Quick Actions
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                                <a href="{{ route('loans.create') }}" class="grid place-items-center content-center p-4 sm:p-6 bg-dark-bg/50 rounded-2xl border border-dark-border hover:border-gold hover:bg-dark-surface transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1">
                                    <i class="fas fa-file-signature text-3xl text-emerald-100/60 group-hover:text-gold mb-3 transition"></i>
                                    <span class="font-black text-[10px] sm:text-xs uppercase tracking-wider text-white group-hover:text-gold transition break-words w-full">Apply for Loan</span>
                                </a>
                                <a href="{{ route('loans.apply.motorcycle') }}" class="grid place-items-center content-center p-4 sm:p-6 bg-dark-bg/50 rounded-2xl border border-dark-border hover:border-gold hover:bg-dark-surface transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1">
                                    <i class="fas fa-motorcycle text-3xl text-emerald-100/60 group-hover:text-gold mb-3 transition"></i>
                                    <span class="font-black text-[10px] sm:text-xs uppercase tracking-wider text-white group-hover:text-gold transition break-words w-full">Buy Motorcycle</span>
                                </a>
                                <a href="{{ route('loans.apply.ramadan_sallah') }}" class="grid place-items-center content-center p-4 sm:p-6 bg-dark-bg/50 rounded-2xl border border-dark-border hover:border-gold hover:bg-dark-surface transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1">
                                    <i class="fas fa-star-and-crescent text-3xl text-emerald-100/60 group-hover:text-gold mb-3 transition"></i>
                                    <span class="font-black text-[10px] sm:text-xs uppercase tracking-wider text-white group-hover:text-gold transition break-words w-full">Ramadan / Sallah</span>
                                </a>
                                <a href="{{ route('loans.apply.asset') }}" class="grid place-items-center content-center p-4 sm:p-6 bg-dark-bg/50 rounded-2xl border border-dark-border hover:border-gold hover:bg-dark-surface transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1">
                                    <i class="fas fa-couch text-3xl text-emerald-100/60 group-hover:text-gold mb-3 transition"></i>
                                    <span class="font-black text-[10px] sm:text-xs uppercase tracking-wider text-white group-hover:text-gold transition break-words w-full">Asset Loan</span>
                                </a>
                                <a href="{{ route('contributions.deposit') }}" class="grid place-items-center content-center p-4 sm:p-6 bg-dark-bg/50 rounded-2xl border border-dark-border hover:border-gold hover:bg-dark-surface transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1">
                                    <i class="fas fa-hand-holding-heart text-3xl text-emerald-100/60 group-hover:text-gold mb-3 transition"></i>
                                    <span class="font-black text-[10px] sm:text-xs uppercase tracking-wider text-white group-hover:text-gold transition break-words w-full">Contribution</span>
                                </a>
                                <a href="{{ route('savings.deposit', ['category' => 'Personal Savings']) }}" class="grid place-items-center content-center p-4 sm:p-6 bg-dark-bg/50 rounded-2xl border border-dark-border hover:border-gold hover:bg-dark-surface transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1">
                                    <i class="fas fa-piggy-bank text-3xl text-emerald-100/60 group-hover:text-gold mb-3 transition"></i>
                                    <span class="font-black text-[10px] sm:text-xs uppercase tracking-wider text-white group-hover:text-gold transition break-words w-full">Add Savings</span>
                                </a>
                                <a href="{{ route('repayments.create') }}" class="grid place-items-center content-center p-4 sm:p-6 bg-dark-bg/50 rounded-2xl border border-dark-border hover:border-gold hover:bg-dark-surface transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1">
                                    <i class="fas fa-hand-holding-usd text-3xl text-emerald-100/60 group-hover:text-gold mb-3 transition"></i>
                                    <span class="font-black text-[10px] sm:text-xs uppercase tracking-wider text-white group-hover:text-gold transition break-words w-full">Repay Loan</span>
                                </a>
                                <a href="{{ route('members.statement', Auth::user()->member) }}" class="grid place-items-center content-center p-4 sm:p-6 bg-dark-bg/50 rounded-2xl border border-dark-border hover:border-gold hover:bg-dark-surface transition-all duration-300 group text-center hover:shadow-xl hover:-translate-y-1 col-span-2 md:col-span-2">
                                    <i class="fas fa-file-invoice text-3xl text-emerald-100/60 group-hover:text-gold mb-3 transition"></i>
                                    <span class="font-black text-[10px] sm:text-xs uppercase tracking-wider text-white group-hover:text-gold transition break-words w-full">Statement</span>
                                </a>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-dark-surface border border-dark-border overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="font-bold text-lg mb-4 text-white">Recent Transactions</h3>
                            <div class="space-y-4">
                                @if(isset($recentActivity) && $recentActivity->count() > 0)
                                    @foreach($recentActivity as $activity)
                                        <div class="grid grid-cols-[auto,1fr] items-center gap-4 border-b border-dark-border pb-4 last:border-0 last:pb-0">
                                            <div class="w-10 h-10 rounded-2xl flex items-center justify-center {{ $activity['type'] == 'saving' ? 'bg-green-500/10 text-green-500' : ($activity['type'] == 'contribution' ? 'bg-gold/10 text-gold' : 'bg-red-500/10 text-red-500') }}">
                                                <i class="fas {{ $activity['type'] == 'saving' ? 'fa-piggy-bank' : ($activity['type'] == 'contribution' ? 'fa-hand-holding-heart' : 'fa-hand-holding-usd') }} text-sm"></i>
                                            </div>
                                            <div class="grid grid-cols-1">
                                                <p class="text-sm font-black text-white leading-none mb-1">{{ $activity['description'] }}</p>
                                                <p class="text-[10px] text-emerald-100/60 font-black uppercase tracking-widest">{{ \Carbon\Carbon::parse($activity['date'])->format('d M, Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-emerald-100/60 italic text-center py-4">No recent transactions.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Member Monthly Activity Ledger -->
                    <div id="member-activity-ledger" class="bg-dark-surface shadow-sm rounded-2xl border border-dark-border overflow-hidden mt-6">
                        <div class="border-b border-dark-border px-6 py-4 flex justify-between items-center bg-dark-bg/50">
                            <h3 class="text-sm font-black text-white flex items-center gap-2 uppercase tracking-widest">
                                <i class="fas fa-calendar-check text-gold"></i>    
                                My Monthly Activity Report
                            </h3>
                            <span class="text-[10px] font-black text-emerald-100/60 uppercase tracking-widest">Savings History Summary</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-dark-bg border-b border-dark-border">
                                        <th class="px-6 py-3 text-[10px] font-black text-emerald-100/60 uppercase tracking-widest">Month/Year</th>
                                        <th class="px-6 py-3 text-[10px] font-black text-emerald-100/60 uppercase tracking-widest text-right">Amount Contributed</th>
                                        <th class="px-6 py-3 text-[10px] font-black text-emerald-100/60 uppercase tracking-widest text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-dark-border">
                                    @forelse($monthlyContributions as $month => $amount)
                                        <tr class="hover:bg-dark-bg/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <span class="font-bold text-white text-sm">{{ $month }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="font-black text-gold text-sm">₦{{ number_format($amount, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if($amount >= 2000)
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-500/10 border border-green-500/20 text-green-400">
                                                        <i class="fas fa-check-circle"></i> Active
                                                    </span>
                                                @elseif($amount > 0)
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-gold/10 border border-gold/20 text-gold">
                                                        <i class="fas fa-exclamation-circle"></i> Partial
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-red-500/10 border border-red-500/20 text-red-400">
                                                        <i class="fas fa-times-circle"></i> Missed
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-emerald-100/60 text-sm italic">No contribution data available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Bank Details Management -->
                    <div class="bg-dark-surface border border-dark-border overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                        <h3 class="text-lg font-bold text-white mb-4">Bank Account Details</h3>
                        <form action="{{ route('profile.bank.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="bank_name" :value="__('Bank Name')" class="text-white" />
                                    <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full bg-dark-bg border-dark-border text-white" :value="old('bank_name', Auth::user()->member->bank_name)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
                                </div>
                                <div>
                                    <x-input-label for="account_number" :value="__('Account Number')" class="text-white" />
                                    <x-text-input id="account_number" name="account_number" type="text" class="mt-1 block w-full bg-dark-bg border-dark-border text-white" :value="old('account_number', Auth::user()->member->account_number)" required maxlength="10" />
                                    <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
                                </div>
                                <div>
                                    <x-input-label for="account_name" :value="__('Account Name')" class="text-white" />
                                    <x-text-input id="account_name" name="account_name" type="text" class="mt-1 block w-full bg-dark-bg border-dark-border text-white" :value="old('account_name', Auth::user()->member->account_name)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('account_name')" />
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="submit" class="bg-gold text-dark-bg px-4 py-2 rounded-md font-bold hover:bg-opacity-90 transition-opacity">
                                    Update Bank Details
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- No Member Profile State -->
                    <div class="bg-dark-surface border border-dark-border overflow-hidden shadow-sm sm:rounded-lg p-10 text-center">
                        <div class="mb-4 text-6xl">⚠️</div>
                        <h3 class="text-2xl font-bold text-white mb-2">Member Profile Not Found</h3>
                        <p class="text-emerald-100/60 max-w-md mx-auto mb-6"> It seems your user account is not linked to a member profile. Please contact the administrator to complete your registration or link your account.</p>
                        <a href="#" class="inline-block bg-gold text-dark-bg px-6 py-2 rounded-md font-semibold hover:bg-opacity-90 transition-opacity">Contact Support</a>
                    </div>
                @endif
                
            @endif
        </div>
    </div>

    <!-- Contribution Rules Modal -->
    <div x-show="showContributionRules" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showContributionRules" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity" @click="showContributionRules = false">
                <div class="absolute inset-0 bg-[#0f172a]/90 backdrop-blur-sm"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;

            <div x-show="showContributionRules" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-middle bg-dark-surface rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-dark-border">
                
                <div class="bg-gradient-to-r from-dark-bg to-dark-surface border-b border-dark-border px-6 py-5 flex justify-between items-center text-white">
                    <h3 class="text-xl font-black flex items-center gap-3 tracking-wide">
                        <span class="bg-gold/10 p-2 rounded-lg backdrop-blur-sm">
                            <i class="fas fa-hand-holding-heart text-gold"></i>
                        </span>
                        Operational Guidelines
                    </h3>
                    <button @click="showContributionRules = false" class="text-gray-500 hover:text-white transition bg-white/5 hover:bg-red-500 hover:border-red-500 border border-white/10 p-2 rounded-full h-8 w-8 flex items-center justify-center group">
                        <i class="fas fa-times group-hover:rotate-90 transition-transform"></i>
                    </button>
                </div>

                <div class="bg-dark-surface px-8 pt-6 pb-8">
                    <div class="space-y-8">
                        <div class="p-5 bg-gold/10 border-l-4 border-gold text-gold rounded-r-xl">
                            <p class="text-sm font-bold flex items-start gap-3">
                                <i class="fas fa-info-circle mt-0.5 text-gold"></i>
                                <span>Please review the cooperative guidelines below before proceeding with your contribution.</span>
                            </p>
                        </div>
                            </p>
                        </div>

                        <div class="space-y-6">
                            <div class="flex gap-5 group">
                                <div class="shrink-0 w-10 h-10 rounded-xl bg-dark-bg text-emerald-100/60 group-hover:bg-gold group-hover:text-dark-bg flex items-center justify-center font-black text-lg transition-all duration-300 shadow-sm border border-dark-border group-hover:border-gold">1</div>
                                <div>
                                    <h4 class="font-bold text-white mb-1">Monthly Obligation</h4>
                                    <p class="text-emerald-100/60 text-sm leading-relaxed">This is a mandatory monthly financial commitment to your cooperative account, ensuring active membership status.</p>
                                </div>
                            </div>
                                </div>
                            </div>

                            <div class="flex gap-5 group">
                                <div class="shrink-0 w-10 h-10 rounded-xl bg-dark-bg text-emerald-100/60 group-hover:bg-gold group-hover:text-dark-bg flex items-center justify-center font-black text-lg transition-all duration-300 shadow-sm border border-dark-border group-hover:border-gold">2</div>
                                <div>
                                    <h4 class="font-bold text-white mb-1">Minimum Contribution</h4>
                                    <p class="text-emerald-100/60 text-sm leading-relaxed">The minimum acceptable contribution amount is fixed at <span class="bg-gold/20 text-gold px-2 py-0.5 rounded font-bold">₦2,000</span>.</p>
                                </div>
                            </div>
                                </div>
                            </div>

                            <div class="flex gap-5 group">
                                <div class="shrink-0 w-10 h-10 rounded-xl bg-dark-bg text-emerald-100/60 group-hover:bg-gold group-hover:text-dark-bg flex items-center justify-center font-black text-lg transition-all duration-300 shadow-sm border border-dark-border group-hover:border-gold">3</div>
                                <div>
                                    <h4 class="font-bold text-white mb-1">Withdrawal Policy</h4>
                                    <p class="text-emerald-100/60 text-sm leading-relaxed">Contributions constitute your primary savings capital and are subject to specific withdrawal restrictions outlined in the bye-laws.</p>
                                </div>
                            </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-dark-border flex flex-col sm:flex-row gap-4">
                            <button @click="showContributionRules = false" class="flex-1 px-6 py-4 bg-dark-bg text-emerald-100/60 font-bold rounded-xl hover:bg-dark-surface hover:text-white transition border border-dark-border hover:border-gold uppercase tracking-wider text-xs">
                                Cancel
                            </button>
                            <a href="{{ route('contributions.deposit') }}" class="flex-1 px-6 py-4 bg-gold text-dark-bg font-bold rounded-xl hover:bg-yellow-500 transition text-center shadow-lg shadow-gold/30 uppercase tracking-wider text-xs flex items-center justify-center gap-2">
                                <span>I Accept & Contribute</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
