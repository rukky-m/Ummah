<x-app-layout>
    <x-slot name="header">
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
                        @if(auth()->user()->canManageLoans())
                            {{ __('Loan Management') }}
                        @else
                            {{ __('My Loans') }}
                        @endif
                    </h2>
                    <p class="text-xs text-emerald-200/50 font-bold uppercase tracking-widest mt-1">
                        @if(auth()->user()->canManageLoans())
                            Track applications, approvals, disbursements and repayments.
                        @else
                            Manage your loan applications and track your repayment progress.
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="flex gap-3">
                @php
                    $activeLoans = auth()->user()->member ? auth()->user()->member->loans()->whereIn('status', ['approved', 'disbursed'])->get() : collect();
                    $firstLoan = $activeLoans->first();
                @endphp

                @if(auth()->user()->member)
                    @if($activeLoans->count() === 1)
                        <button type="button" 
                            @click="$dispatch('open-modal', 'repayment-modal'); 
                                    selectedLoanId = {{ $firstLoan->id }}; 
                                    selectedLoanAmount = '{{ number_format($firstLoan->monthlyRepaymentAmount(), 2, '.', '') }}';
                                    selectedLoanNumber = '{{ $firstLoan->application_number }}';
                                    selectedLoanPurpose = '{{ $firstLoan->purpose }}';
                                    selectedLoanPrincipal = '{{ number_format($firstLoan->amount, 0) }}';"
                            class="bg-gold text-white px-6 py-3 rounded-xl shadow-lg hover:bg-yellow-600 transition transform hover:-translate-y-1 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest">
                            <i class="fas fa-hand-holding-usd"></i> 
                            <span>Repay Loan</span>
                        </button>
                    @else
                        <a href="{{ route('repayments.create') }}" class="bg-gold text-white px-6 py-3 rounded-xl shadow-lg hover:bg-yellow-600 transition transform hover:-translate-y-1 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest">
                            <i class="fas fa-hand-holding-usd"></i> 
                            <span>Repay Loan</span>
                        </a>
                    @endif
                    <a href="{{ route('loans.create') }}" class="bg-emerald-600 border border-emerald-500 text-white px-6 py-3 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] hover:bg-emerald-500 transition transform hover:-translate-y-1 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest">
                        <i class="fas fa-plus"></i> 
                        <span>Apply for Loan</span>
                    </a>
                @endif
            </div>
        </div>

        {{-- Mobile Header --}}
        <div class="flex sm:hidden justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="w-9 h-9 rounded-full bg-emerald-900/30 border border-emerald-800/50 flex items-center justify-center text-emerald-500 active:scale-95 transition">
                    <i class="fas fa-chevron-left text-sm"></i>
                </a>
                <div>
                    <p class="text-[9px] text-emerald-500/70 font-black uppercase tracking-widest leading-none">Credit</p>
                    <h1 class="text-base font-black text-white leading-tight tracking-tight uppercase">
                        {{ auth()->user()->canManageLoans() ? 'Loan Admin' : 'My Loans' }}
                    </h1>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent" x-data="{ 
        selectedLoanId: null,
        selectedLoanAmount: 0,
        selectedLoanNumber: '',
        selectedLoanPurpose: '',
        selectedLoanPrincipal: ''
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            @if(!auth()->user()->canManageAnnouncements())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Active Balance -->
                <div class="bg-[#0B1A14] rounded-2xl shadow-sm border border-emerald-900/50 p-6 relative overflow-hidden group hover:border-emerald-500/40 transition-colors">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-hand-holding-usd text-8xl text-emerald-500"></i>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                            <i class="fas fa-university text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-emerald-600/70 uppercase tracking-wider">Remaining Loan Balance</p>
                            <h3 class="text-2xl font-black text-white">₦{{ number_format($stats['active_balance'] ?? 0, 2) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Repaid -->
                <div class="bg-[#0B1A14] rounded-2xl shadow-sm border border-gold/20 p-6 relative overflow-hidden group hover:border-gold/40 transition-colors">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-check-double text-8xl text-gold"></i>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gold/10 border border-gold/20 flex items-center justify-center text-gold">
                            <i class="fas fa-hand-holding-heart text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-yellow-600/70 uppercase tracking-wider">Total Repaid</p>
                            <h3 class="text-2xl font-black text-white">₦{{ number_format($stats['total_repaid'] ?? 0, 2) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Pending Applications -->
                <div class="bg-[#0B1A14] rounded-2xl shadow-sm border border-blue-900/50 p-6 relative overflow-hidden group hover:border-blue-500/40 transition-colors">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-file-invoice-dollar text-8xl text-blue-500"></i>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fas fa-clipboard-list text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-600/70 uppercase tracking-wider">Pending Apps</p>
                            <h3 class="text-2xl font-black text-white">{{ $stats['pending_count'] ?? 0 }} Pending</h3>
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

            @if(session('error'))
                <div class="mb-6 bg-[#0B1A14] border border-red-500/50 text-red-400 px-4 py-3 rounded-xl relative flex items-center gap-3 shadow-[0_0_15px_rgba(239,68,68,0.2)]" role="alert">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <span class="block sm:inline font-medium text-sm">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Loans Table -->
            <div class="bg-[#0B1A14] rounded-2xl shadow-sm border border-emerald-900/50 overflow-hidden">
                <div class="p-6 border-b border-emerald-900/30 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2 uppercase tracking-wide">
                        <i class="fas fa-briefcase text-emerald-500 text-sm"></i>
                        Loan Applications
                    </h3>
                    
                    @if(auth()->user()->canManageLoans())
                    <div class="flex gap-2">
                        <a href="{{ route('loans.index') }}" class="px-3 py-1 rounded-lg text-xs font-bold transition {{ !request('status') ? 'bg-emerald-600 border-emerald-500 text-white' : 'bg-emerald-900/30 text-emerald-500/70 hover:bg-emerald-800/40 border border-transparent' }}">All</a>
                        <a href="{{ route('loans.index', ['status' => 'pending']) }}" class="px-3 py-1 rounded-lg text-xs font-bold transition {{ request('status') == 'pending' ? 'bg-yellow-500 text-gray-900' : 'bg-emerald-900/30 text-emerald-500/70 hover:bg-emerald-800/40 border border-transparent' }}">Pending</a>
                        <a href="{{ route('loans.index', ['status' => 'approved']) }}" class="px-3 py-1 rounded-lg text-xs font-bold transition {{ request('status') == 'approved' ? 'bg-emerald-500 text-white' : 'bg-emerald-900/30 text-emerald-500/70 hover:bg-emerald-800/40 border border-transparent' }}">Approved</a>
                    </div>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-emerald-900/10">
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30">Date/ID</th>
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30">Member</th>
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30">Principal</th>
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30">Repayment</th>
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30 text-center">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/30 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-900/30">
                            @forelse($loans as $loan)
                                <tr class="hover:bg-[#0E211A] transition duration-150 group">
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-white">{{ $loan->created_at->format('d M Y') }}</span>
                                            <span class="text-[10px] text-emerald-500/60 uppercase tracking-wider font-bold">#LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gold/10 text-gold flex items-center justify-center font-bold text-xs overflow-hidden border border-gold/20">
                                                @if($loan->member->user?->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $loan->member->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                                @elseif($loan->member->passport_photo_path)
                                                    <img src="{{ asset('storage/' . $loan->member->passport_photo_path) }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ substr($loan->member->full_name, 0, 1) }}
                                                @endif
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-emerald-100 group-hover:text-emerald-400 transition-colors">{{ $loan->member->full_name }}</span>
                                                <span class="text-[10px] text-emerald-500/60 font-medium">{{ $loan->member->account_number }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-white">₦{{ number_format($loan->amount, 0) }}</span>
                                            <span class="text-[10px] text-emerald-500/60 font-bold uppercase">{{ $loan->duration_months }} Months @ {{ $loan->interest_rate }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-emerald-400">₦{{ number_format($loan->total_repayment, 2) }}</span>
                                            <span class="text-[10px] text-emerald-500/60 font-bold uppercase">₦{{ number_format($loan->monthlyRepaymentAmount(), 2) }} / mo</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-center">
                                        @php
                                            $statusClasses = [
                                                'approved' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                'disbursed' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                                'pending' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                                'rejected' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                                'paid' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full shadow-sm border {{ $statusClasses[$loan->status] ?? 'bg-emerald-900/30 text-emerald-500/70 border-emerald-800' }}">
                                            {{ $loan->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if(auth()->user()->member && in_array($loan->status, ['approved', 'disbursed']))
                                                <button type="button" 
                                                    @click="$dispatch('open-modal', 'repayment-modal'); 
                                                            selectedLoanId = {{ $loan->id }}; 
                                                            selectedLoanAmount = '{{ number_format($loan->monthlyRepaymentAmount(), 2, '.', '') }}';
                                                            selectedLoanNumber = '{{ $loan->application_number }}';
                                                            selectedLoanPurpose = '{{ $loan->purpose }}';
                                                            selectedLoanPrincipal = '{{ number_format($loan->amount, 0) }}';"
                                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-gold/10 border border-gold/20 text-gold hover:bg-gold hover:text-white rounded-lg transition-all text-[10px] font-black uppercase tracking-wider">
                                                    <i class="fas fa-hand-holding-usd"></i>
                                                    Repay
                                                </button>
                                            @endif
                                            @if(auth()->user()->canManageLoans() || (auth()->user()->member && $loan->member_id === auth()->user()->member->id))
                                                <a href="{{ route('loans.show', $loan) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-900/30 border border-emerald-800/50 text-emerald-400 hover:bg-emerald-600 hover:text-white rounded-lg transition-all text-[10px] font-black uppercase tracking-wider">
                                                    <i class="fas fa-eye"></i>
                                                    Details
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center border-b border-emerald-900/30">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-emerald-900/20 rounded-full flex items-center justify-center text-emerald-700/50 mb-4 border border-emerald-800/30">
                                                <i class="fas fa-envelope-open-text text-2xl"></i>
                                            </div>
                                            <p class="text-emerald-600/70 font-medium">No loan applications found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($loans->hasPages())
                    <div class="px-6 py-4 bg-emerald-900/10 border-t border-emerald-900/30">
                        {{ $loans->links() }}
                    </div>
                @endif
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
