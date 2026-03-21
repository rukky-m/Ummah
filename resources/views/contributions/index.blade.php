<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-gold leading-tight tracking-tight uppercase">
                    {{ auth()->user()->canManageContributions() ? __('Contributions Management') : __('My Contributions') }}
                </h2>
                <p class="text-sm text-emerald-200/60 mt-1 font-medium italic">
                    {{ auth()->user()->canManageContributions() ? 'Manage member monthly contributions and track capital growth.' : 'Track your mandatory monthly contributions and cooperative capital.' }}
                </p>
            </div>
            
            <div class="flex gap-3">
                @if(auth()->user()->canManageContributions())
                    <a href="{{ route('savings.create', ['category' => 'Contribution']) }}" class="bg-gradient-to-r from-emerald-600 to-emerald-800 border border-emerald-500 hover:from-emerald-500 hover:to-emerald-700 text-white px-6 py-4 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] transition-all active:scale-95 flex items-center gap-2 font-black uppercase tracking-widest text-[10px]">
                        <i class="fas fa-plus-circle"></i> 
                        <span>Record Transaction</span>
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            @if(!auth()->user()->canManageAnnouncements())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-[#0B1A14] rounded-2xl shadow-sm border border-gold/20 p-6 relative overflow-hidden group hover:border-gold/40 transition-colors">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-hand-holding-heart text-8xl text-gold"></i>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gold/10 border border-gold/20 flex items-center justify-center text-gold">
                            <i class="fas fa-coins text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-yellow-600/70 uppercase tracking-wider">Total Contributions</p>
                            <h3 class="text-2xl font-black text-white">₦{{ number_format($stats['total_contributions'] ?? 0, 2) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-[#0B1A14] rounded-2xl shadow-sm border border-emerald-900/50 p-6 relative overflow-hidden group hover:border-emerald-500/40 transition-colors">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-calendar-check text-8xl text-emerald-500"></i>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-emerald-600/70 uppercase tracking-wider">This Month</p>
                            <h3 class="text-2xl font-black text-white">₦{{ number_format($stats['monthly_contributions'] ?? 0, 2) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-[#0B1A14] rounded-2xl shadow-sm border border-blue-900/50 p-6 relative overflow-hidden group hover:border-blue-500/40 transition-colors">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-hourglass-half text-8xl text-blue-500"></i>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-600/70 uppercase tracking-wider">Pending Approvals</p>
                            <h3 class="text-2xl font-black text-white">{{ $stats['pending_count'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(session('success'))
                <div class="mb-6 bg-[#0B1A14] border border-emerald-500/50 text-emerald-400 px-4 py-3 rounded-xl relative flex items-center gap-3 shadow-[0_0_15px_rgba(16,185,129,0.2)]" role="alert">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <span class="block sm:inline font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Contribution Table -->
            <div class="bg-[#0B1A14] rounded-2xl shadow-sm border border-emerald-900/50 overflow-hidden">
                <div class="p-6 border-b border-emerald-900/30 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2 uppercase tracking-wide">
                            <i class="fas fa-history text-gold text-sm"></i>
                            Contribution Ledger
                        </h3>
                        
                        @if(auth()->user()->canManageContributions())
                            <div class="flex bg-emerald-900/20 p-1 rounded-xl border border-emerald-800/30">
                                <a href="{{ route('contributions.index', ['status' => 'all']) }}" 
                                    class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'all' || !request('status') ? 'bg-[#0B1A14] text-gold shadow-sm border border-emerald-800/50' : 'text-emerald-600/70 hover:text-emerald-400' }}">All</a>
                                <a href="{{ route('contributions.index', ['status' => 'pending']) }}" 
                                    class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'pending' ? 'bg-[#0B1A14] text-gold shadow-sm border border-emerald-800/50' : 'text-emerald-600/70 hover:text-emerald-400' }}">Pending</a>
                                <a href="{{ route('contributions.index', ['status' => 'approved']) }}" 
                                    class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'approved' ? 'bg-[#0B1A14] text-emerald-400 shadow-sm border border-emerald-800/50' : 'text-emerald-600/70 hover:text-emerald-400' }}">Approved</a>
                            </div>
                        @endif
                    </div>
                    
                    <form action="{{ route('contributions.index') }}" method="GET" class="relative w-full md:w-64">
                        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search member..." 
                            class="w-full pl-10 pr-4 py-2 border border-emerald-900/50 rounded-xl focus:ring-gold focus:border-gold transition-all text-sm font-medium bg-[#0B1A14] text-white placeholder-emerald-700/50">
                        <div class="absolute left-3 top-2.5 text-emerald-600/70">
                            <i class="fas fa-search"></i>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-emerald-900/10">
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30">Date</th>
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30">Member</th>
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30 text-right">Amount</th>
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30 text-center">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30">Notes</th>
                                @if(auth()->user()->canManageContributions())
                                    <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30 text-center">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-900/30">
                            @forelse($contributions as $contribution)
                                <tr class="hover:bg-[#0E211A] transition duration-150 group">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-white">{{ $contribution->transaction_date->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-gold/10 text-gold border border-gold/20 flex items-center justify-center font-bold text-xs uppercase">
                                                {{ substr($contribution->member->full_name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-bold text-emerald-100 group-hover:text-emerald-400 transition-colors">{{ $contribution->member->full_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-right">
                                        <span class="text-sm font-black text-emerald-400">
                                            ₦{{ number_format($contribution->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full shadow-sm border 
                                            {{ $contribution->status == 'approved' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : ($contribution->status == 'pending' ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20') }}">
                                            {{ $contribution->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-2 text-emerald-600/70">
                                            <span class="text-sm font-medium truncate max-w-[150px]">{{ $contribution->notes ?: '-' }}</span>
                                            @if($contribution->payment_proof_path)
                                                <a href="{{ asset('storage/' . $contribution->payment_proof_path) }}" target="_blank" class="text-gold hover:text-yellow-400 transition" title="View Proof">
                                                    <i class="fas fa-receipt"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    @if(auth()->user()->canManageContributions())
                                        <td class="px-6 py-5 whitespace-nowrap text-center">
                                            @if($contribution->status === 'pending')
                                                <a href="{{ route('contributions.show', $contribution) }}"
                                                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-amber-500/20 border border-amber-500/30 hover:bg-amber-500 hover:text-white text-gold text-[10px] font-black uppercase tracking-widest rounded-xl transition active:scale-95">
                                                    <i class="fas fa-eye"></i> Review
                                                </a>
                                            @else
                                                <a href="{{ route('contributions.show', $contribution) }}"
                                                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-900/30 border border-emerald-800/50 text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-800/60 transition">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-emerald-600/70 italic border-t border-emerald-900/30">No contributions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($contributions->hasPages())
                    <div class="px-6 py-4 bg-emerald-900/10 border-t border-emerald-900/30">
                        {{ $contributions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" onclick="closeRejectModal()">
                <div class="absolute inset-0 bg-[#0B1A14]/90 backdrop-blur-sm opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
            <div class="inline-block align-middle bg-[#0B1A14] border border-emerald-900/50 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-red-500/10 border-b border-red-500/20 px-6 py-5 flex justify-between items-center text-red-500">
                    <h3 class="text-lg font-black flex items-center gap-3">
                        <i class="fas fa-times-circle"></i>
                        Reject Contribution
                    </h3>
                    <button type="button" onclick="closeRejectModal()" class="text-red-500/70 hover:text-red-400 transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="px-8 pt-6 pb-8">
                    <form id="rejectForm" method="POST">
                        @csrf
                        <textarea name="reason" rows="4" class="w-full bg-[#0E211A] border border-emerald-900/50 rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm mb-6 text-emerald-100 placeholder-emerald-700/50" placeholder="Enter rejection reason..." required></textarea>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="button" onclick="closeRejectModal()" class="flex-1 px-6 py-4 bg-[#0E211A] text-emerald-500/70 hover:text-emerald-400 font-black uppercase tracking-widest text-[10px] rounded-xl border border-emerald-900/50 transition">Cancel</button>
                            <button type="submit" class="flex-1 px-6 py-4 bg-red-600 hover:bg-red-500 text-white font-black rounded-xl uppercase tracking-widest text-[10px] transition shadow-[0_0_15px_rgba(220,38,38,0.3)] shadow-red-500/30">Confirm Rejection</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/contributions/${id}/reject`;
            modal.classList.remove('hidden');
        }
        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
