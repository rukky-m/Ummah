<x-app-layout>
    <x-slot name="header">
        {{-- Mobile Header --}}
        <div class="flex sm:hidden justify-between items-center mb-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-500 hover:bg-emerald-900/30 hover:text-emerald-400 active:scale-95 transition-all">
                    <i class="fas fa-chevron-left text-sm"></i>
                </a>
                <div>
                    <p class="text-[9px] text-emerald-600/70 font-black uppercase tracking-widest leading-none mb-1">Directory</p>
                    <h1 class="text-xl font-black text-white leading-tight tracking-tight">Members</h1>
                </div>
            </div>
            @can('manage-members')
            <a href="{{ route('members.create') }}"
               class="flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-800 text-white text-[10px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.3)] active:scale-95 transition-all">
                <i class="fas fa-plus text-xs"></i> Add
            </a>
            @endcan
        </div>
        
        {{-- Desktop Header --}}
        <div class="hidden sm:flex justify-between items-center bg-[#0E211A] p-7 rounded-3xl border border-emerald-900/50 shadow-[0_0_20px_rgba(16,185,129,0.05)] transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900 opacity-50"></div>
            <div class="flex items-center gap-5 relative z-10">
                @if(Auth::user()->profile_photo_path)
                    <img class="w-16 h-16 rounded-2xl object-cover shadow-[0_0_15px_rgba(0,0,0,0.5)] border-2 border-emerald-900/50" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-16 h-16 rounded-2xl bg-[#0B1A14] border-2 border-emerald-900/50 flex items-center justify-center text-emerald-500/50 font-black text-2xl uppercase shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="font-black text-3xl text-white leading-tight tracking-tight uppercase">Member Directory</h2>
                    <p class="text-[10px] text-emerald-600/70 font-black uppercase tracking-widest mt-1">Manage and verify community memberships</p>
                </div>
            </div>
            
            @can('manage-members')
            <a href="{{ route('members.create') }}" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-3.5 px-6 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:-translate-y-0.5 transition-all uppercase tracking-widest text-[10px] relative z-10">
                <i class="fas fa-plus mr-1.5 text-xs"></i> Add Member
            </a>
            @endcan
        </div>
    </x-slot>


    <div class="py-6 bg-transparent min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-900/20 border border-emerald-500/30 text-emerald-400 px-5 py-4 rounded-2xl flex items-center gap-3 text-sm font-bold shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                    <i class="fas fa-check-circle text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- SEARCH & FILTERS --}}
            <div class="flex flex-col md:flex-row gap-5 justify-between items-start md:items-center">
                <form action="{{ route('members.index') }}" method="GET" class="relative group w-full md:w-auto">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-emerald-600/50 group-focus-within:text-gold transition-colors text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search Name, Phone, File NO..." 
                        class="pl-12 pr-6 py-4 w-full md:w-[400px] bg-[#0B1A14] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-emerald-100 placeholder-emerald-900/50 text-xs font-black uppercase tracking-widest transition-all shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]">
                </form>

                @php $pendingCount = \App\Models\Member::where('status', 'pending')->count(); @endphp
                <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide bg-[#0B1A14] p-1.5 rounded-2xl border border-emerald-900/50 shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)] w-full md:w-auto">
                    <a href="{{ route('members.index', ['status' => 'all']) }}"
                       class="whitespace-nowrap shrink-0 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all
                              {{ request('status') == 'all' || !request('status') ? 'bg-[#0E211A] text-emerald-400 shadow-[0_0_10px_rgba(16,185,129,0.1)] border border-emerald-500/30' : 'text-emerald-600/70 hover:bg-emerald-900/20 hover:text-emerald-400' }}">
                        All Members
                    </a>
                    <a href="{{ route('members.index', ['status' => 'active']) }}"
                       class="whitespace-nowrap shrink-0 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all
                              {{ request('status') == 'active' ? 'bg-[#0E211A] text-emerald-400 shadow-[0_0_10px_rgba(16,185,129,0.1)] border border-emerald-500/30' : 'text-emerald-600/70 hover:bg-emerald-900/20 hover:text-emerald-400' }}">
                        Active
                    </a>
                    <a href="{{ route('members.index', ['status' => 'pending']) }}"
                       class="whitespace-nowrap shrink-0 flex items-center gap-2 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all
                              {{ request('status') == 'pending' ? 'bg-[#0E211A] text-gold shadow-[0_0_10px_rgba(251,191,36,0.1)] border border-gold/30' : 'text-emerald-600/70 hover:bg-emerald-900/20 hover:text-emerald-400' }}">
                        Pending
                        @if($pendingCount > 0)
                            <span class="w-5 h-5 rounded-full {{ request('status') == 'pending' ? 'bg-gold/20 text-gold border border-gold/30' : 'bg-gold/10 text-gold border border-gold/20' }} text-[9px] font-black flex items-center justify-center">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>

            {{-- MEMBER LIST --}}
            <div class="space-y-4">
                @forelse($members as $member)
                    <div class="group bg-[#0B1A14] rounded-3xl border border-emerald-900/50 shadow-sm hover:shadow-[0_0_20px_rgba(16,185,129,0.1)] hover:border-emerald-500/50 transition-all duration-300 overflow-hidden relative hover:-translate-y-0.5 mt-2">
                        <div class="flex items-center gap-5 p-5">
                            {{-- Avatar --}}
                            <div class="shrink-0 w-14 h-14 rounded-2xl bg-[#0E211A] border-2 border-emerald-900/50 text-emerald-500/50 flex items-center justify-center font-black text-xl uppercase overflow-hidden shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)] transition-all group-hover:border-emerald-500/50">
                                @if($member->user?->profile_photo_path)
                                    <img src="{{ asset('storage/' . $member->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                @elseif($member->passport_photo_path)
                                    <img src="{{ asset('storage/' . $member->passport_photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($member->full_name, 0, 1)) }}
                                @endif
                            </div>

                            {{-- Main Info --}}
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('members.show', $member) }}" class="block">
                                    <p class="font-bold text-lg text-white truncate tracking-tight group-hover:text-emerald-400 transition-colors">{{ $member->full_name }}</p>
                                    <p class="text-[10px] text-emerald-600/70 font-black uppercase tracking-widest truncate mt-1">{{ $member->occupation ?? $member->phone }}</p>
                                </a>
                            </div>

                            {{-- Status badge --}}
                            <div class="shrink-0 flex flex-col items-end gap-3">
                                <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border
                                    {{ $member->status == 'active' ? 'bg-emerald-900/30 text-emerald-400 border-emerald-500/30' : 'bg-gold/10 text-gold border-gold/30' }}">
                                    {{ $member->status }}
                                </span>

                                {{-- Actions --}}
                                @can('manage-members')
                                <div class="flex items-center gap-2">
                                    @if($member->status == 'pending')
                                        <a href="{{ route('members.show', $member) }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] active:scale-95">
                                            <i class="fas fa-eye text-xs"></i> Review
                                        </a>
                                    @else
                                        <a href="{{ route('members.show', $member) }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0E211A] hover:bg-emerald-900/30 border border-emerald-900/50 text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all hover:border-emerald-500/50 hover:shadow-[0_0_10px_rgba(16,185,129,0.1)]">
                                            <i class="fas fa-eye text-xs"></i> View
                                        </a>
                                        <a href="{{ route('members.edit', $member) }}"
                                           class="w-10 h-10 rounded-xl bg-[#0E211A] border border-emerald-900/50 text-emerald-600/70 flex items-center justify-center hover:bg-gold/10 hover:text-gold hover:border-gold/30 transition-all active:scale-90">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                    @endif
                                </div>
                                @endcan
                            </div>
                        </div>

                        {{-- Bottom detail strip --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 px-6 py-3.5 bg-[#0E211A] border-t border-emerald-900/50">
                            <div class="flex items-center gap-2 text-[10px] font-black text-emerald-600/70 uppercase tracking-widest group-hover:text-emerald-400/80 transition-colors">
                                <i class="fas fa-phone"></i>
                                {{ $member->phone ?? '—' }}
                            </div>
                            <div class="hidden sm:block w-1 h-1 rounded-full bg-emerald-900/50"></div>
                            <div class="flex items-center gap-2 text-[10px] font-black text-emerald-600/70 uppercase tracking-widest group-hover:text-emerald-400/80 transition-colors">
                                <i class="fas fa-university"></i>
                                {{ $member->account_number ?? 'No acct.' }}
                            </div>
                            <a href="{{ route('members.statement', $member) }}" class="sm:ml-auto text-[10px] font-black text-gold uppercase tracking-widest flex items-center gap-1.5 hover:text-yellow-400 hover:tracking-[0.15em] transition-all bg-gold/10 px-3 py-1.5 rounded-lg border border-gold/20">
                                Statement <i class="fas fa-external-link-alt text-[9px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-[#0B1A14] rounded-3xl border border-dashed border-emerald-900/50 p-16 text-center">
                        <div class="w-20 h-20 bg-[#0E211A] border border-emerald-900/50 rounded-2xl flex items-center justify-center mx-auto mb-6 text-emerald-500/50 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                            <i class="fas fa-users-slash text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white tracking-tight mb-2">No Members Found</h3>
                        <p class="text-xs font-black text-emerald-600/70 uppercase tracking-widest">Try adjusting your search criteria</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8 pagination-dark text-emerald-400">
                {{ $members->links() }}
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="memberRejectModal" class="fixed inset-0 z-[110] overflow-y-auto hidden">
        <div class="flex items-end sm:items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-[#0B1A14] bg-opacity-80 backdrop-blur-md transition-opacity" onclick="closeMemberRejectModal()"></div>
            <div class="relative bg-[#0E211A] border border-emerald-900/50 rounded-3xl w-full max-w-md overflow-hidden shadow-[0_0_30px_rgba(16,185,129,0.1)] transform transition-all">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-rose-900 via-rose-500 to-rose-900 opacity-50"></div>
                <div class="p-8">
                    <div class="w-16 h-16 rounded-2xl bg-rose-900/20 border border-rose-500/30 text-rose-500 flex items-center justify-center text-3xl mx-auto mb-6 shadow-[inset_0_2px_10px_rgba(0,0,0,0.2)]">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white text-center tracking-tight mb-2">Reject Application</h3>
                    <p class="text-xs text-emerald-600/70 text-center font-black uppercase tracking-widest mb-6">Give a clear reason for rejecting this member.</p>

                    <form id="memberRejectForm" method="POST">
                        @csrf
                        <textarea name="reason" rows="3"
                            class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500/50 transition-all font-medium mb-6 text-emerald-100 placeholder:text-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]"
                            placeholder="e.g. Incomplete documents, invalid ID..."
                            required></textarea>
                        <div class="flex gap-4">
                            <button type="button" onclick="closeMemberRejectModal()"
                                class="flex-1 py-4 bg-[#0B1A14] border border-emerald-900/50 text-emerald-600/70 font-black uppercase tracking-widest text-[10px] rounded-xl hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 py-4 bg-gradient-to-r from-rose-600 to-rose-800 text-white font-black uppercase tracking-widest text-[10px] rounded-xl hover:from-rose-500 hover:to-rose-700 transition-all shadow-[0_0_15px_rgba(225,29,72,0.3)] active:scale-95 flex justify-center items-center gap-2">
                                <i class="fas fa-check-double text-base"></i> Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Pagination Styling for Dark Theme */
        .pagination-dark nav [aria-label="Pagination"] {
            border-radius: 1rem;
        }
        .pagination-dark nav [aria-current="page"] span {
            background-color: #047857; /* emerald-700 */
            border-color: #047857;
            color: white;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.3);
        }
        .pagination-dark nav a, .pagination-dark nav span.relative.inline-flex {
            background-color: #0E211A;
            border-color: rgba(6, 78, 59, 0.5); /* emerald-900/50 */
            color: rgba(52, 211, 153, 0.7); /* emerald-400/70 */
            border-radius: 0.5rem;
            margin: 0 2px;
        }
        .pagination-dark nav a:hover {
            background-color: rgba(6, 78, 59, 0.3);
            color: #34d399; /* emerald-400 */
            border-color: rgba(16, 185, 129, 0.3);
        }
        .pagination-dark nav svg {
            color: rgba(52, 211, 153, 0.7);
        }
    </style>

    <script>
        function openMemberRejectModal(id) {
            document.getElementById('memberRejectForm').action = `/members/${id}/reject`;
            document.getElementById('memberRejectModal').classList.remove('hidden');
        }
        function closeMemberRejectModal() {
            document.getElementById('memberRejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
