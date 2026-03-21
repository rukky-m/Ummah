<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-white tracking-tight">
            {{ __('Loan Approvals Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-hidden bg-[#0E211A] shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl">
                <!-- Decorative top gradient -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900 opacity-50"></div>
                
                <div class="p-7">
                    <!-- Search and Filters -->
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
                        <form method="GET" action="{{ route('admin.loans.index') }}" class="w-full md:w-auto flex-1 flex gap-3">
                             <div class="relative w-full md:w-80">
                                 <input type="text" name="search" value="{{ request('search') }}" placeholder="Search application..." 
                                    class="w-full pl-11 pr-4 py-3 bg-[#0B1A14] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 transition-all text-sm font-bold text-emerald-100 placeholder-emerald-900/50" />
                                 <div class="absolute left-4 top-3.5 text-emerald-600/50"><i class="fas fa-search"></i></div>
                             </div>
                             <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-3 px-6 rounded-xl transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:-translate-y-0.5 uppercase tracking-widest text-xs flex items-center gap-2">
                                Search
                             </button>
                        </form>
                        
                        <div class="flex bg-[#0B1A14] p-1.5 rounded-2xl border border-emerald-900/50 w-full md:w-auto overflow-x-auto shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)]">
                            <a href="{{ route('admin.loans.index') }}" class="whitespace-nowrap px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ !request('status') ? 'bg-[#0E211A] text-emerald-400 shadow-[0_0_10px_rgba(16,185,129,0.1)] border border-emerald-500/30' : 'text-emerald-600/70 hover:bg-emerald-900/20 hover:text-emerald-400' }}">My Queue</a>
                            <a href="{{ route('admin.loans.index', ['status' => 'pending']) }}" class="whitespace-nowrap px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'pending' ? 'bg-[#0E211A] text-amber-400 shadow-[0_0_10px_rgba(251,191,36,0.1)] border border-amber-500/30' : 'text-emerald-600/70 hover:bg-amber-900/20 hover:text-amber-400' }}">Pending</a>
                            <a href="{{ route('admin.loans.index', ['status' => 'approved']) }}" class="whitespace-nowrap px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'approved' ? 'bg-[#0E211A] text-emerald-400 shadow-[0_0_10px_rgba(16,185,129,0.1)] border border-emerald-500/30' : 'text-emerald-600/70 hover:bg-emerald-900/20 hover:text-emerald-400' }}">Approved</a>
                            <a href="{{ route('admin.loans.index', ['status' => 'rejected']) }}" class="whitespace-nowrap px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'rejected' ? 'bg-[#0E211A] text-rose-400 shadow-[0_0_10px_rgba(244,63,94,0.1)] border border-rose-500/30' : 'text-emerald-600/70 hover:bg-rose-900/20 hover:text-rose-400' }}">Rejected</a>
                            <a href="{{ route('admin.loans.index', ['status' => 'disbursed']) }}" class="whitespace-nowrap px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == 'disbursed' ? 'bg-[#0E211A] text-blue-400 shadow-[0_0_10px_rgba(59,130,246,0.1)] border border-blue-500/30' : 'text-emerald-600/70 hover:bg-blue-900/20 hover:text-blue-400' }}">Disbursed</a>
                        </div>
                    </div>

                    <!-- Loan List -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 mb-6">
                            <h3 class="text-xl font-bold text-white tracking-tight">
                                @if(!request('status')) My Queue @elseif(request('status') == 'pending') Pending Applications @elseif(request('status') == 'approved') Approved Loans @elseif(request('status') == 'rejected') Rejected Loans @elseif(request('status') == 'disbursed') Disbursed Loans @else All Applications @endif
                            </h3>
                            <span class="px-3 py-1 rounded-md bg-[#0B1A14] border border-emerald-900/50 text-emerald-400 text-xs font-black">{{ $loans->total() }}</span>
                        </div>

                        @if($loans->count() > 0)
                            <div class="grid grid-cols-1 gap-4">
                            @foreach($loans as $loan)
                                <div class="group relative overflow-hidden bg-[#0B1A14] p-5 sm:rounded-2xl border border-emerald-900/50 hover:border-emerald-500/50 hover:shadow-[0_0_20px_rgba(16,185,129,0.1)] transition-all duration-300 flex flex-col md:flex-row justify-between items-start md:items-center hover:-translate-y-1">
                                    <div class="mb-4 md:mb-0">
                                        <div class="flex items-center gap-3 mb-3">
                                            <span class="font-black text-[10px] tracking-widest text-emerald-400 bg-emerald-900/30 border border-emerald-500/30 px-2 py-1 rounded-md uppercase">{{ $loan->application_number ?? 'N/A' }}</span>
                                            <span class="text-xs font-bold text-emerald-600/70"><i class="far fa-clock mr-1.5 opacity-70"></i>{{ $loan->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <h4 class="font-bold text-xl text-white tracking-tight">{{ $loan->member->first_name ?? 'Unknown' }} {{ $loan->member->last_name ?? 'Member' }}</h4>
                                        <div class="text-sm font-medium text-emerald-600/70 mt-1">
                                            <span class="font-black text-emerald-400">₦{{ number_format($loan->amount, 0) }}</span> <span class="mx-1 opacity-50">•</span> {{ $loan->purpose }}
                                        </div>
                                        <div class="mt-4 flex items-center gap-2 text-sm">
                                            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50">Status:</span> 
                                            <span class="px-2 py-0.5 border rounded text-[10px] font-black uppercase tracking-widest {{ $loan->status == 'disbursed' ? 'bg-blue-900/30 border-blue-500/30 text-blue-400' : ($loan->status == 'approved' ? 'bg-emerald-900/30 border-emerald-500/30 text-emerald-400' : ($loan->status == 'rejected' ? 'bg-rose-900/30 border-rose-500/30 text-rose-400' : 'bg-amber-900/30 border-amber-500/30 text-amber-400')) }}">
                                                {{ $loan->current_stage_name }}
                                            </span>
                                            @if($loan->status == 'pending')
                                                <span class="text-emerald-600/70 text-[10px] font-black uppercase tracking-wider ml-1 bg-[#0E211A] border border-emerald-900/50 px-2 py-0.5 rounded-md">Step {{ $loan->stage }}/5</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-3">
                                        <a href="{{ route('admin.loans.show', $loan) }}" class="bg-[#0E211A] border border-emerald-900/50 text-emerald-400 px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-900/30 hover:shadow-[0_0_10px_rgba(16,185,129,0.2)] transition-all duration-300 flex items-center gap-2">
                                            <i class="fas fa-eye"></i>
                                            Review
                                        </a>
                                        @if($loan->status == 'approved' && auth()->user()->approval_order == 5)
                                         <form action="{{ route('admin.loans.disburse', $loan) }}" method="POST" onsubmit="return confirm('Disburse this loan?');">
                                             @csrf
                                             <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-3 px-6 rounded-xl transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:-translate-y-0.5 uppercase tracking-widest text-[10px] flex items-center gap-2">
                                                 <i class="fas fa-hand-holding-usd"></i>
                                                 Disburse
                                             </button>
                                         </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            
                            <div class="mt-8 pagination-dark text-emerald-400">
                                {{ $loans->links() }}
                            </div>
                        @else
                            <div class="text-center py-16 bg-[#0B1A14] rounded-2xl border border-dashed border-emerald-900/50">
                                <div class="w-16 h-16 bg-[#0E211A] rounded-2xl flex items-center justify-center text-emerald-500/50 mx-auto mb-5 border border-emerald-900/50 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                                    <i class="fas fa-search text-2xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white tracking-tight mb-2">No Applications Found</h3>
                                <p class="text-sm font-medium text-emerald-600/70">There are no loan applications matching your criteria.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Pagination Styling for Dark Theme */
        .pagination-dark nav [aria-label="Pagination"] {
            border-radius: 0.75rem;
        }
        .pagination-dark nav [aria-current="page"] span {
            background-color: #047857;
            border-color: #047857;
            color: white;
        }
        .pagination-dark nav a, .pagination-dark nav span.relative.inline-flex {
            background-color: #0E211A;
            border-color: rgba(6, 78, 59, 0.5);
            color: rgba(52, 211, 153, 0.7);
        }
        .pagination-dark nav a:hover {
            background-color: rgba(6, 78, 59, 0.3);
            color: #34d399;
        }
        .pagination-dark nav svg {
            color: rgba(52, 211, 153, 0.7);
        }
    </style>
</x-app-layout>
