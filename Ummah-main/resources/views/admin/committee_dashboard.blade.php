<x-app-layout>
    <x-slot name="header">
        {{-- Desktop: Welcome Message + Avatar + Date --}}
        <div class="hidden sm:flex justify-between items-center bg-[#0B1A14] p-6 rounded-[2rem] border border-emerald-900/50 shadow-sm transition-all duration-300">
            <div class="flex items-center gap-4">
                @if(Auth::user()->profile_photo_path)
                    <img class="w-14 h-14 rounded-2xl object-cover shadow-lg border-2 border-emerald-800/50" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-900 flex items-center justify-center text-white font-black text-2xl uppercase shadow-[0_0_15px_rgba(16,185,129,0.3)] border-2 border-emerald-500/30">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="font-black text-2xl text-white leading-tight tracking-tight uppercase">
                        Committee Hub: <span class="text-emerald-400">{{ explode(' ', Auth::user()->name)[0] }}</span>
                    </h2>
                    <p class="text-sm font-bold text-emerald-100/60 mt-0.5">
                        <i class="fas fa-shield-alt mr-1 text-gold"></i>
                        <span class="uppercase tracking-widest text-[11px] font-black">Loan Committee Review System</span>
                    </p>
                </div>
            </div>
            
            <div x-data="{ 
                date: new Date(), 
                formatDate(date) {
                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    return date.toLocaleDateString('en-GB', options);
                }
            }" x-init="setInterval(() => date = new Date(), 60000)" class="text-[10px] font-black text-gold bg-gold/10 px-5 py-3 rounded-xl border border-gold/20 uppercase tracking-widest shadow-[0_0_15px_rgba(234,179,8,0.1)]">
                <span x-text="formatDate(date)">{{ now()->format('l, jS F Y') }}</span>
            </div>
        </div>

        {{-- Mobile-only header --}}
        <div class="flex sm:hidden justify-between items-center bg-[#0B1A14] p-4 rounded-3xl border border-emerald-900/50">
            <div class="flex items-center gap-3">
                @if(Auth::user()->profile_photo_path)
                    <img class="w-10 h-10 rounded-2xl object-cover shadow-sm border border-emerald-800/50" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-10 h-10 rounded-2xl bg-emerald-600 flex items-center justify-center text-white font-black text-base uppercase border border-emerald-500/30">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="text-sm font-black text-white leading-none mb-1 uppercase tracking-tight">Committee Dashboard</h2>
                    <p class="text-[9px] text-emerald-400 font-black uppercase tracking-widest leading-none">Admin View</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-transparent">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Overall Statistics -->
            @if(!auth()->user()->canManageAnnouncements())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Pending -->
                <div class="relative overflow-hidden bg-[#0B1A14] border border-gold/20 shadow-sm sm:rounded-3xl p-6 hover:-translate-y-1 hover:border-gold/40 hover:shadow-lg hover:shadow-gold/10 transition-all duration-300 group">
                    <div class="absolute -right-6 -bottom-6 opacity-[0.03] group-hover:scale-110 transition-transform duration-500 flex items-center justify-center">
                        <i class="fas fa-clock text-9xl text-gold"></i>
                    </div>
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gold/10 border border-gold/20 flex items-center justify-center text-gold group-hover:scale-110 transition-transform">
                            <i class="fas fa-clock text-xl shadow-[0_0_15px_rgba(234,179,8,0.3)]"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-yellow-600/70">Pending Approval</p>
                            <h3 class="text-3xl font-black text-white tracking-tight leading-none mt-1">{{ $totalPending }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Approved -->
                <div class="relative overflow-hidden bg-[#0B1A14] border border-emerald-900/50 shadow-sm sm:rounded-3xl p-6 hover:-translate-y-1 hover:border-emerald-500/40 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 group">
                    <div class="absolute -right-6 -bottom-6 opacity-[0.03] group-hover:scale-110 transition-transform duration-500 flex items-center justify-center">
                        <i class="fas fa-check-circle text-9xl text-emerald-500"></i>
                    </div>
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600/70">Approved</p>
                            <h3 class="text-3xl font-black text-white tracking-tight leading-none mt-1">{{ $totalApproved }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Rejected -->
                <div class="relative overflow-hidden bg-[#0B1A14] border border-red-900/50 shadow-sm sm:rounded-3xl p-6 hover:-translate-y-1 hover:border-red-500/40 hover:shadow-lg hover:shadow-red-500/10 transition-all duration-300 group">
                    <div class="absolute -right-6 -bottom-6 opacity-[0.03] group-hover:scale-110 transition-transform duration-500 flex items-center justify-center">
                        <i class="fas fa-times-circle text-9xl text-red-500"></i>
                    </div>
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-red-600/70">Rejected</p>
                            <h3 class="text-3xl font-black text-white tracking-tight leading-none mt-1">{{ $totalRejected }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Disbursed -->
                <div class="relative overflow-hidden bg-[#0B1A14] border border-blue-900/50 shadow-sm sm:rounded-3xl p-6 hover:-translate-y-1 hover:border-blue-500/40 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 group">
                    <div class="absolute -right-6 -bottom-6 opacity-[0.03] group-hover:scale-110 transition-transform duration-500 flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-9xl text-blue-500"></i>
                    </div>
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                            <i class="fas fa-money-bill-wave text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600/70">Disbursed</p>
                            <h3 class="text-3xl font-black text-white tracking-tight leading-none mt-1">{{ $totalDisbursed }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Committee Pipeline -->
            <div class="relative overflow-hidden bg-[#0B1A14] shadow-sm border border-emerald-900/50 sm:rounded-3xl">
                <div class="px-8 py-6 border-b border-emerald-900/50 bg-[#0E211A]/50">
                    <h3 class="text-base font-black text-emerald-400 tracking-widest uppercase flex items-center gap-3">
                        <i class="fas fa-layer-group text-gold"></i>
                        Approval Committee Pipeline
                    </h3>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-emerald-100/40 mt-1">Sequential validation process · Each stage requires clearance before proceeding</p>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($stats as $stat)
                            <div class="group relative overflow-hidden bg-[#0E211A] rounded-2xl border border-emerald-900/30 p-6 hover:shadow-lg hover:shadow-[0_0_20px_rgba(16,185,129,0.1)] transition-all duration-300 hover:border-emerald-500/30 hover:-translate-y-1 flex flex-col justify-between">
                                
                                <div class="flex items-center gap-4 mb-6 relative z-10">
                                    <div class="w-14 h-14 rounded-2xl bg-emerald-900/30 border border-emerald-800/50 text-emerald-500 flex items-center justify-center font-black text-2xl shadow-inner group-hover:scale-110 group-hover:text-gold transition-all duration-300 group-hover:border-gold/30 group-hover:bg-gold/10">
                                        <i class="fas {{ $stat['icon'] }}"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-black text-white tracking-tight uppercase">{{ $stat['title'] }}</h4>
                                        <p class="text-[10px] text-emerald-100/50 font-bold uppercase tracking-widest mb-1">{{ $stat['admin']?->name ?? 'Unassigned' }}</p>
                                        <span class="text-[9px] font-black text-gold bg-gold/10 border border-gold/20 px-2.5 py-0.5 rounded shadow-sm uppercase tracking-widest">Stage {{ $stat['stage'] }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-3 relative z-10">
                                    <div class="bg-[#0B1A14] border border-gold/20 rounded-xl p-3 text-center transition-all group-hover:border-gold/40">
                                        <p class="text-[9px] font-black text-yellow-600 uppercase tracking-widest mb-1">Waiting</p>
                                        <p class="text-xl font-black text-gold">{{ $stat['waiting'] }}</p>
                                    </div>
                                    <div class="bg-[#0B1A14] border border-emerald-900/50 rounded-xl p-3 text-center transition-all group-hover:border-emerald-500/40">
                                        <p class="text-[9px] font-black text-emerald-600/70 uppercase tracking-widest mb-1">Approved</p>
                                        <p class="text-xl font-black text-emerald-400">{{ $stat['approved'] }}</p>
                                    </div>
                                    <div class="bg-[#0B1A14] border border-red-900/50 rounded-xl p-3 text-center transition-all group-hover:border-red-500/40">
                                        <p class="text-[9px] font-black text-red-600/70 uppercase tracking-widest mb-1">Rejected</p>
                                        <p class="text-xl font-black text-red-400">{{ $stat['rejected'] }}</p>
                                    </div>
                                </div>

                                @if($stat['waiting'] > 0)
                                    <a href="{{ route('admin.loans.index') }}" class="mt-6 block w-full bg-gold hover:bg-yellow-500 border border-yellow-400 shadow-[0_0_15px_rgba(234,179,8,0.2)] hover:shadow-[0_0_20px_rgba(234,179,8,0.4)] text-[#0B1A14] py-3.5 rounded-xl text-center font-black text-[10px] uppercase tracking-widest transition duration-300 flex items-center justify-center gap-2 active:scale-95">
                                        <i class="fas fa-search"></i> Review Loans
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Visual Pipeline Flow -->
            <div class="relative overflow-hidden bg-[#0B1A14] shadow-sm border border-emerald-900/50 sm:rounded-3xl">
                <div class="px-8 py-6 border-b border-emerald-900/50 bg-[#0E211A]/50">
                    <h3 class="text-base font-black text-emerald-400 tracking-widest uppercase flex items-center gap-3">
                        <i class="fas fa-project-diagram text-gold"></i>
                        Approval Flow Visualization
                    </h3>
                </div>

                <div class="p-8">
                    <div class="flex items-center justify-between gap-6 overflow-x-auto pb-6 scrollbar-hide">
                        @foreach($stats as $index => $stat)
                            <div class="flex items-center gap-6">
                                <div class="flex flex-col items-center min-w-[120px] group">
                                    <div class="w-16 h-16 rounded-full {{ $stat['waiting'] > 0 ? 'bg-gold/10 border-2 border-gold text-gold shadow-[0_0_20px_rgba(234,179,8,0.3)]' : 'bg-[#0E211A] border-2 border-emerald-900/50 text-emerald-600/50' }} flex items-center justify-center font-black text-xl mb-4 transition-all duration-300 group-hover:scale-110" title="{{ $stat['title'] }}">
                                        {{ $stat['stage'] }}
                                    </div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-white mb-1 px-2 text-center">{{ $stat['title'] }}</p>
                                    <p class="text-[9px] font-bold uppercase tracking-widest text-emerald-500/50 text-center mb-3 line-clamp-1">{{ $stat['admin']?->name ?? 'Unassigned' }}</p>
                                    
                                    @if($stat['waiting'] > 0)
                                        <span class="px-3 py-1 bg-gold border border-gold shadow-[0_0_10px_rgba(234,179,8,0.4)] text-[#0B1A14] rounded-md text-[9px] font-black uppercase tracking-wider relative">
                                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                                            {{ $stat['waiting'] }} Pending
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-[#0E211A] border border-emerald-900/50 text-emerald-100/40 rounded-md text-[9px] font-black uppercase tracking-wider">All Clear</span>
                                    @endif
                                </div>
                                
                                @if($index < count($stats) - 1)
                                    <div class="flex items-center -mt-8">
                                        <div class="w-8 h-0.5 bg-emerald-900/50 mx-2 relative">
                                            <i class="fas fa-chevron-right absolute -right-2 -top-2 text-[10px] text-emerald-900/80"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
