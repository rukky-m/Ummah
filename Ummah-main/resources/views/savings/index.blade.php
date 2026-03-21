<x-app-layout>
    <x-slot name="header">
        {{-- Mobile Header --}}
        <div class="flex sm:hidden justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="w-9 h-9 rounded-full bg-emerald-900/30 border border-emerald-800/50 flex items-center justify-center text-emerald-500 active:scale-95 transition">
                    <i class="fas fa-chevron-left text-sm"></i>
                </a>
                <div>
                    <p class="text-[9px] text-emerald-500/70 font-black uppercase tracking-widest leading-none">Financials</p>
                    <h1 class="text-base font-black text-white leading-tight tracking-tight uppercase">
                        {{ request('category') == 'Contribution' ? 'Contributions' : 'Savings' }}
                    </h1>
                </div>
            </div>
            @if(auth()->user()->canManageSavings())
                <a href="{{ route('savings.create') }}"
                   class="flex items-center gap-2 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl shadow-lg shadow-emerald-900/20 active:scale-95 transition">
                    <i class="fas fa-plus text-xs"></i> Record
                </a>
            @elseif(auth()->user()->member)
                <a href="{{ route('savings.deposit', ['category' => 'Personal Savings']) }}"
                   class="flex items-center gap-2 bg-gold text-white text-[10px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl shadow-[0_0_15px_rgba(234,179,8,0.3)] active:scale-95 transition">
                    <i class="fas fa-piggy-bank text-xs"></i> Save
                </a>
            @endif
        </div>

        {{-- Desktop Header --}}
        <div class="hidden sm:flex justify-between items-center bg-[#0B1A14] p-6 rounded-3xl border border-emerald-900/50 shadow-sm transition-all duration-300">
            <div class="flex items-center gap-4">
                @if(Auth::user()->profile_photo_path)
                    <img class="w-14 h-14 rounded-2xl object-cover shadow-lg border-2 border-emerald-800" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-900 flex items-center justify-center text-white font-black text-2xl uppercase shadow-lg border-2 border-emerald-800">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="font-black text-2xl text-white leading-tight tracking-tight uppercase">
                        @if(auth()->user()->canManageSavings())
                            {{ request('category') == 'Contribution' ? __('Contributions Management') : __('Savings Management') }}
                        @else
                            {{ __('My Savings Portfolio') }}
                        @endif
                    </h2>
                    <p class="text-xs text-emerald-200/50 font-bold uppercase tracking-widest mt-1">
                        @if(auth()->user()->canManageSavings())
                            Manage member financial data and track group stability.
                        @else
                            Track your savings growth and view history.
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="flex gap-3">
                @if(auth()->user()->canManageSavings())
                    <a href="{{ route('savings.create') }}" class="bg-gradient-to-r from-emerald-600 to-emerald-800 border border-emerald-500 text-white font-black py-3 px-6 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] transition-all uppercase tracking-widest text-[10px] active:scale-95">
                        <i class="fas fa-plus mr-1"></i> Record Transaction
                    </a>
                @elseif(auth()->user()->member)
                    <a href="{{ route('savings.deposit', ['category' => 'Personal Savings']) }}" class="bg-gold hover:bg-yellow-500 border border-yellow-400 text-white font-black py-3 px-6 rounded-xl shadow-[0_0_15px_rgba(234,179,8,0.3)] hover:shadow-[0_0_25px_rgba(234,179,8,0.5)] transition-all uppercase tracking-widest text-[10px] flex justify-center items-center gap-2">
                        <i class="fas fa-piggy-bank"></i> Add Saving
                    </a>
                    <a href="{{ route('savings.withdraw') }}" class="bg-transparent border border-red-500/50 text-red-500 hover:bg-red-500/10 font-black py-3 px-6 rounded-xl shadow-[0_0_15px_rgba(239,68,68,0.1)] hover:shadow-[0_0_25px_rgba(239,68,68,0.2)] transition-all uppercase tracking-widest text-[10px] flex justify-center items-center gap-2">
                        <i class="fas fa-hand-holding-dollar"></i> Withdraw
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-[#0B1A14] border border-emerald-500/50 text-emerald-400 px-4 py-3 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-[0_0_15px_rgba(16,185,129,0.2)] animate-pulse">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- STATISTICS GRID --}}
            @if(!auth()->user()->canManageAnnouncements())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Total Balance Hero --}}
                <div class="bg-emerald-600 rounded-3xl p-6 text-white shadow-[0_0_25px_rgba(16,185,129,0.3)] relative overflow-hidden group border border-emerald-500/50">
                    <div class="absolute -right-6 -bottom-6 opacity-[0.15] rotate-12 group-hover:scale-110 transition-transform duration-500 flex items-center justify-center">
                        <i class="fas fa-wallet text-9xl"></i>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-100/70 mb-1">Total Balance</p>
                    <h3 class="text-3xl font-black tracking-tight leading-none mb-4">₦{{ number_format($stats['total_savings'] ?? 0, 2) }}</h3>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse shadow-[0_0_10px_rgba(110,231,183,1)]"></span>
                        <span class="text-[9px] font-bold text-emerald-100/70 uppercase tracking-widest">Active Growth</span>
                    </div>
                </div>

                {{-- Deposits card --}}
                <div class="bg-[#0B1A14] rounded-3xl p-6 border border-gold/20 shadow-sm relative overflow-hidden group hover:border-gold/40 transition-colors">
                    <div class="absolute -right-4 -top-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-arrow-down-long text-8xl text-gold"></i>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-gold/10 border border-gold/20 flex items-center justify-center text-gold mb-4 transition-transform group-hover:scale-110">
                        <i class="fas fa-calendar-alt text-sm"></i>
                    </div>
                    <p class="text-[9px] font-black uppercase tracking-widest text-yellow-600/70 mb-1">This Month Deposits</p>
                    <h3 class="text-xl font-black text-white tracking-tight leading-none">₦{{ number_format($stats['monthly_deposits'] ?? 0, 2) }}</h3>
                </div>

                {{-- Pending card --}}
                <div class="bg-[#0B1A14] rounded-3xl p-6 border border-blue-900/50 shadow-sm relative overflow-hidden group hover:border-blue-500/40 transition-colors">
                    <div class="absolute -right-4 -top-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-clock text-8xl text-blue-500"></i>
                    </div>
                    <div class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 mb-4 transition-transform group-hover:scale-110">
                        <i class="fas fa-hourglass-half text-sm"></i>
                    </div>
                    <p class="text-[9px] font-black uppercase tracking-widest text-blue-600/70 mb-1">Pending Approvals</p>
                    <h3 class="text-xl font-black text-white tracking-tight leading-none">{{ $stats['pending_count'] ?? 0 }} Transactions</h3>
                </div>
            </div>
            @endif

            {{-- TRANSACTION HISTORY SECTION --}}
            <div class="space-y-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <h3 class="text-sm font-black text-emerald-500 uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-history text-emerald-600"></i>
                        Recent Transactions
                    </h3>

                    {{-- Scrollable Filters --}}
                    @if(auth()->user()->canManageSavings())
                        <div class="flex bg-emerald-900/20 p-1 rounded-2xl border border-emerald-800/30 overflow-x-auto pb-1 scrollbar-hide">
                            <a href="{{ route('savings.index', ['status' => 'all', 'category' => request('category')]) }}" 
                               class="shrink-0 px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all
                                      {{ request('status') == 'all' || !request('status') ? 'bg-[#0B1A14] text-emerald-400 border border-emerald-800/50 shadow-sm' : 'text-emerald-600/70 hover:text-emerald-400' }}">
                                All
                            </a>
                            <a href="{{ route('savings.index', ['status' => 'pending', 'category' => request('category')]) }}" 
                               class="shrink-0 px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all
                                      {{ request('status') == 'pending' ? 'bg-[#0B1A14] text-gold border border-gold/40 shadow-sm' : 'text-emerald-600/70 hover:text-emerald-400' }}">
                                Pending
                            </a>
                            <a href="{{ route('savings.index', ['status' => 'approved', 'category' => request('category')]) }}" 
                               class="shrink-0 px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all
                                      {{ request('status') == 'approved' ? 'bg-[#0B1A14] text-emerald-400 border border-emerald-800/50 shadow-sm' : 'text-emerald-600/70 hover:text-emerald-400' }}">
                                Approved
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Search Bar --}}
                <form action="{{ route('savings.index') }}" method="GET" class="relative group">
                    @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search members or reference..."
                           class="w-full bg-[#0B1A14] text-white placeholder-emerald-700/50 border border-emerald-900/50 rounded-2xl pl-12 pr-4 py-4 text-sm font-medium focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 transition-all shadow-sm">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-600/70 group-focus-within:text-emerald-400 transition-colors">
                        <i class="fas fa-search text-base"></i>
                    </div>
                </form>

                {{-- CARD LIST --}}
                <div class="space-y-3">
                    @forelse($savings as $saving)
                        <div class="bg-[#0B1A14] rounded-3xl border border-emerald-900/50 shadow-sm overflow-hidden hover:border-emerald-500/40 transition-colors group">
                            <div class="p-4 flex items-center gap-4">
                                {{-- Icon/Avatar --}}
                                <div class="shrink-0 w-12 h-12 rounded-2xl bg-emerald-900/30 border border-emerald-800/50 text-emerald-600/70 flex items-center justify-center font-black relative overflow-hidden group-hover:border-emerald-500/50 transition-colors">
                                    @if($saving->member?->user?->profile_photo_path)
                                        <img src="{{ asset('storage/' . $saving->member->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                    @elseif($saving->member?->passport_photo_path)
                                        <img src="{{ asset('storage/' . $saving->member->passport_photo_path) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($saving->member?->full_name ?? '?', 0, 1) }}
                                    @endif
                                    {{-- Sub-icon for type --}}
                                    <div class="absolute bottom-1 right-1 w-4 h-4 rounded-full border border-[#0B1A14] flex items-center justify-center
                                                {{ $saving->type == 'deposit' ? 'bg-emerald-500 shadow-[0_0_5px_rgba(16,185,129,0.8)]' : 'bg-red-500 shadow-[0_0_5px_rgba(239,68,68,0.8)]' }}">
                                        <i class="fas fa-arrow-{{ $saving->type == 'deposit' ? 'down' : 'up' }} text-[6px] text-white"></i>
                                    </div>
                                </div>

                                {{-- Details --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-black text-emerald-50 group-hover:text-emerald-300 transition-colors truncate tracking-tight">{{ $saving->member?->full_name ?? 'Deleted Member' }}</p>
                                    <p class="text-[10px] text-emerald-500/60 font-bold uppercase tracking-widest mt-0.5">
                                        {{ $saving->transaction_date->format('d M, Y') }} · <span class="capitalize">{{ $saving->category ?: $saving->type }}</span>
                                    </p>
                                </div>

                                {{-- Amount & Status --}}
                                <div class="shrink-0 flex flex-col items-end gap-2">
                                    <p class="text-sm font-black {{ $saving->type == 'deposit' ? 'text-emerald-400' : 'text-red-400' }}">
                                        {{ $saving->type == 'deposit' ? '+' : '-' }}₦{{ number_format($saving->amount, 0) }}
                                    </p>
                                    <span class="px-2 py-0.5 border rounded-full text-[8px] font-black uppercase tracking-widest shadow-sm
                                        {{ $saving->status == 'approved' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : ($saving->status == 'pending' ? 'bg-gold/10 text-gold border-gold/20' : 'bg-red-500/10 text-red-400 border-red-500/20') }}">
                                        {{ $saving->status }}
                                    </span>
                                </div>
                            </div>

                            {{-- Expanded footer details (Desktop/Staff actions) --}}
                            <div class="px-4 py-3 bg-[#0E211A]/50 border-t border-emerald-900/30 flex items-center gap-4">
                                <span class="text-[9px] font-bold text-emerald-600/70 uppercase tracking-widest flex items-center gap-2">
                                    <i class="fas fa-hashtag text-[8px]"></i>
                                    {{ $saving->reference ?: 'No reference' }}
                                </span>
                                
                                <div class="ml-auto flex items-center gap-2">
                                    @if($saving->payment_proof_path)
                                        <a href="{{ asset('storage/' . $saving->payment_proof_path) }}" target="_blank"
                                           class="w-7 h-7 rounded-lg bg-emerald-900/30 border border-emerald-800/50 text-gold flex items-center justify-center hover:bg-gold hover:text-white transition active:scale-95 shadow-sm hover:shadow-[0_0_10px_rgba(234,179,8,0.3)]">
                                            <i class="fas fa-receipt text-[10px]"></i>
                                        </a>
                                    @endif

                                    @if(auth()->user()->canManageSavings())
                                        @if($saving->status === 'pending')
                                            <a href="{{ route('savings.show', $saving) }}"
                                               class="inline-flex items-center gap-1.5 px-3 py-2 bg-amber-500/20 border border-amber-500/30 hover:bg-amber-500 hover:text-white text-gold text-[10px] font-black uppercase tracking-widest rounded-xl transition hover:shadow-lg hover:shadow-[0_0_15px_rgba(245,158,11,0.3)] active:scale-95">
                                                <i class="fas fa-eye"></i> Review
                                            </a>
                                        @else
                                            <a href="{{ route('savings.show', $saving) }}"
                                               class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-900/30 border border-emerald-800/50 text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-800/60 transition">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-[#0B1A14] rounded-3xl border border-emerald-900/50 p-16 text-center shadow-sm">
                            <div class="w-20 h-20 bg-emerald-900/20 border border-emerald-800/30 rounded-full flex items-center justify-center mx-auto mb-6 text-emerald-700/50">
                                <i class="fas fa-folder-open text-3xl"></i>
                            </div>
                            <h4 class="text-sm font-black text-emerald-100 uppercase tracking-widest mb-1">No Transactions</h4>
                            <p class="text-[10px] text-emerald-500/60 font-medium">Try adjusting your filters or search terms.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $savings->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal (Bottom-Sheet style) --}}
    <div id="rejectModal" class="fixed inset-0 z-[110] overflow-y-auto hidden">
        <div class="flex items-end sm:items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-[#0B1A14]/90 backdrop-blur-sm" onclick="closeRejectModal()"></div>
            <div class="relative bg-[#0B1A14] border border-emerald-900/50 rounded-t-[2.5rem] sm:rounded-3xl w-full max-w-md overflow-hidden shadow-2xl transition-all">
                <div class="p-8">
                    <div class="w-16 h-1 bg-emerald-900/50 rounded-full mx-auto mb-6 sm:hidden"></div>
                    <div class="w-14 h-14 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-500 flex items-center justify-center text-2xl mx-auto mb-6 shadow-[0_0_15px_rgba(239,68,68,0.2)]">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h3 class="text-lg font-black text-white text-center uppercase tracking-tight mb-1">Reject Deposit</h3>
                    <p class="text-xs text-emerald-500/60 text-center font-medium mb-6">Explain why this transaction is being rejected.</p>

                    <form id="rejectForm" method="POST">
                        @csrf
                        <textarea name="reason" rows="3"
                            class="w-full bg-[#0E211A] text-white placeholder-emerald-700/50 border border-emerald-900/50 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition font-medium mb-5"
                            placeholder="e.g. Invalid proof of payment, incorrect amount..."
                            required></textarea>
                        <div class="flex gap-3">
                            <button type="button" onclick="closeRejectModal()"
                                class="flex-1 py-4 bg-[#0E211A] border border-emerald-900/50 text-emerald-500/70 font-black uppercase tracking-widest text-[10px] rounded-2xl hover:bg-emerald-800/40 hover:text-emerald-400 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 py-4 bg-red-600 border border-red-500 text-white font-black uppercase tracking-widest text-[10px] rounded-2xl hover:bg-red-500 transition shadow-[0_0_15px_rgba(220,38,38,0.3)] active:scale-95">
                                Confirm Rejection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            document.getElementById('rejectForm').action = `/savings/${id}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }
        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
