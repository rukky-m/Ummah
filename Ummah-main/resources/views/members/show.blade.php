<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white tracking-tight flex items-center gap-3">
            <a href="{{ route('members.index') }}" class="w-8 h-8 rounded-full bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all text-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            {{ $member->full_name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Member Details Card -->
                <div class="md:col-span-1">
                    <div class="bg-[#0E211A] overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900 opacity-50"></div>
                        <div class="p-8">
                            <div class="flex flex-col items-center pb-8 border-b border-emerald-900/50">
                                @if($member->user?->profile_photo_path)
                                    <img src="{{ asset('storage/' . $member->user->profile_photo_path) }}" alt="{{ $member->full_name }}" class="w-28 h-28 object-cover rounded-3xl shadow-[0_0_15px_rgba(0,0,0,0.5)] border-2 border-emerald-900/50 mb-5">
                                @elseif($member->passport_photo_path)
                                    <img src="{{ asset('storage/' . $member->passport_photo_path) }}" alt="{{ $member->full_name }}" class="w-28 h-28 object-cover rounded-3xl shadow-[0_0_15px_rgba(0,0,0,0.5)] border-2 border-emerald-900/50 mb-5">
                                @else
                                    <div class="w-28 h-28 rounded-3xl bg-[#0B1A14] border-2 border-emerald-900/50 flex items-center justify-center text-emerald-500/50 font-black text-4xl uppercase mb-5 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                                        {{ substr($member->full_name, 0, 1) }}
                                    </div>
                                @endif
                                <h3 class="text-2xl font-black text-white text-center tracking-tight">{{ $member->title }} {{ $member->full_name }}</h3>
                                <p class="text-[11px] font-black uppercase tracking-widest text-emerald-600/70 mt-1">{{ $member->occupation }}</p>
                                <span class="mt-4 px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border
                                    {{ $member->status == 'active' ? 'bg-emerald-900/30 text-emerald-400 border-emerald-500/30' : 'bg-gold/10 text-gold border-gold/30' }}">
                                    {{ ucfirst($member->status) }}
                                </span>
                            </div>

                            <div class="mt-8 space-y-6">
                                <div class="bg-[#0B1A14] p-4 rounded-2xl border border-emerald-900/50 flex flex-col items-center justify-center text-center group hover:border-emerald-500/30 transition-colors">
                                    <label class="text-[9px] text-emerald-600/50 uppercase font-black tracking-widest mt-1 group-hover:text-emerald-400/80 transition-colors">File Number</label>
                                    <p class="text-gold font-mono font-bold text-lg tracking-tight">{{ $member->file_number ?? 'Not assigned' }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[9px] text-emerald-600/50 uppercase font-black tracking-widest">Phone</label>
                                        <p class="text-emerald-100 font-bold text-sm mt-0.5">{{ $member->phone }}</p>
                                    </div>
                                    <div class="text-right">
                                        <label class="text-[9px] text-emerald-600/50 uppercase font-black tracking-widest">Gender / DOB</label>
                                        <p class="text-emerald-100 font-bold text-sm mt-0.5">{{ $member->gender }} / {{ $member->dob ? $member->dob->format('d M Y') : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="bg-[#0B1A14] p-4 rounded-xl border border-emerald-900/50 flex flex-col group hover:border-emerald-500/30 transition-colors">
                                    <label class="text-[9px] text-emerald-600/50 uppercase font-black tracking-widest group-hover:text-emerald-400/80 transition-colors">Account Number</label>
                                    <p class="text-emerald-100 font-mono font-bold text-lg mt-0.5">{{ $member->account_number ?? 'Not Assigned' }}</p>
                                </div>
                                <div>
                                    <label class="text-[9px] text-emerald-600/50 uppercase font-black tracking-widest">Address</label>
                                    <p class="text-emerald-100 font-medium text-sm mt-0.5 leading-relaxed">{{ $member->address }}</p>
                                </div>
                                <div class="bg-emerald-900/10 p-4 rounded-xl border border-emerald-900/30">
                                    <label class="text-[9px] text-emerald-600/50 uppercase font-black tracking-widest">Next of Kin</label>
                                    <p class="text-emerald-100 font-bold text-sm mt-0.5">{{ $member->next_of_kin_name }}</p>
                                    <p class="text-[11px] text-emerald-600/70 font-medium mt-0.5"><i class="fas fa-phone mr-1"></i> {{ $member->next_of_kin_phone }}</p>
                                </div>
                            </div>

                             <div class="mt-8 pt-8 border-t border-emerald-900/50 flex flex-col gap-4">
                                <a href="{{ route('members.statement', $member) }}" class="text-center bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-4 rounded-xl text-[10px] uppercase tracking-[0.2em] shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-file-invoice-dollar text-base"></i>
                                    Financial Report
                                </a>
                                <a href="{{ route('members.edit', $member) }}" class="text-center bg-[#0B1A14] hover:bg-emerald-900/30 border border-emerald-900/50 text-emerald-400 font-black py-3.5 rounded-xl text-[10px] uppercase tracking-widest hover:border-emerald-500/50 transition-all">
                                    <i class="fas fa-edit mr-1"></i> Edit Basic Details
                                </a>
                                
                                 @if($member->status == 'pending')
                                    <div class="bg-gradient-to-br from-[#0B1A14] to-emerald-950 border border-gold/30 rounded-2xl p-6 mt-4 shadow-[0_0_20px_rgba(251,191,36,0.1)] relative overflow-hidden group">
                                        <div class="absolute top-0 -left-[100%] w-1/2 h-full bg-gradient-to-r from-transparent via-white/5 to-transparent transform -skew-x-12 group-hover:left-[200%] transition-all duration-1000"></div>
                                        <h4 class="text-[10px] font-black text-gold uppercase tracking-[0.2em] mb-5 text-center flex items-center justify-center gap-2"><i class="fas fa-shield-alt"></i> Approval Terminal</h4>
                                        <div class="grid grid-cols-1 gap-4 relative z-10">
                                            <form action="{{ route('members.approve', $member) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full bg-gradient-to-r from-gold to-yellow-600 hover:from-yellow-400 hover:to-gold text-[#0B1A14] font-black py-4 rounded-xl shadow-[0_0_15px_rgba(251,191,36,0.3)] hover:shadow-[0_0_20px_rgba(251,191,36,0.4)] hover:-translate-y-0.5 transition-all uppercase tracking-widest text-[10px] active:scale-95 flex items-center justify-center gap-2">
                                                    <i class="fas fa-check-double text-base"></i>
                                                    Approve Membership
                                                </button>
                                            </form>
                                            <button type="button" onclick="openMemberRejectModal({{ $member->id }})" class="w-full bg-rose-950/30 text-rose-500 border border-rose-900/50 font-black py-4 rounded-xl transition-all hover:bg-rose-900/50 hover:text-rose-400 hover:border-rose-500/50 active:scale-95 flex items-center justify-center gap-2 uppercase tracking-widest text-[10px]">
                                                <i class="fas fa-times-circle text-base"></i>
                                                Reject Application
                                            </button>
                                        </div>
                                        <p class="text-[9px] text-emerald-100/60 mt-4 text-center leading-relaxed font-medium">By approving, the user will be granted full member access and an account number will be generated automatically.</p>
                                    </div>
                                @endif
                             </div>
                         </div>
                     </div>

                     <!-- KYD Documents -->
                     <div class="bg-[#0E211A] overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl mt-8">
                        <div class="p-8">
                            <h4 class="text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-6 flex items-center gap-2 pb-4 border-b border-emerald-900/30">
                                <i class="fas fa-id-card text-emerald-500/70"></i>
                                Verification Documents
                            </h4>
                            
                            <div class="space-y-8">
                                <div>
                                    <p class="text-[9px] font-black text-white uppercase tracking-wider mb-3">Identification Card <span class="text-emerald-600/70">({{ $member->id_type }})</span></p>
                                    @if($member->id_card_path)
                                        <a href="{{ Storage::url($member->id_card_path) }}" target="_blank" class="block group">
                                            <div class="relative rounded-2xl overflow-hidden border border-emerald-900/50 aspect-[16/9] bg-[#0B1A14] flex items-center justify-center shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                                                <img src="{{ Storage::url($member->id_card_path) }}" alt="ID Card" class="max-h-full object-contain group-hover:scale-105 transition-transform duration-500">
                                                <div class="absolute inset-0 bg-[#0B1A14]/0 group-hover:bg-[#0B1A14]/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all duration-300">
                                                    <div class="w-12 h-12 rounded-full bg-emerald-900/50 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shadow-[0_0_20px_rgba(16,185,129,0.3)]">
                                                        <i class="fas fa-expand-arrows-alt text-xl"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <div class="p-6 bg-[#0B1A14] rounded-2xl border border-dashed border-emerald-900/50 text-center text-[10px] font-black uppercase tracking-widest text-emerald-600/50">
                                            No ID card uploaded
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <p class="text-[9px] font-black text-white uppercase tracking-wider mb-3 w-32 mx-auto text-center">Passport Photo</p>
                                    @if($member->passport_photo_path)
                                        <a href="{{ Storage::url($member->passport_photo_path) }}" target="_blank" class="block w-32 group mx-auto">
                                            <div class="relative rounded-2xl overflow-hidden border border-emerald-900/50 aspect-square bg-[#0B1A14] flex items-center justify-center shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                                                <img src="{{ Storage::url($member->passport_photo_path) }}" alt="Passport" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                <div class="absolute inset-0 bg-[#0B1A14]/0 group-hover:bg-[#0B1A14]/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all duration-300">
                                                    <i class="fas fa-search-plus text-emerald-400 text-2xl drop-shadow-[0_2px_5px_rgba(0,0,0,0.8)]"></i>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <div class="w-32 mx-auto p-6 aspect-square bg-[#0B1A14] rounded-2xl border border-dashed border-emerald-900/50 flex items-center justify-center text-center text-[9px] font-black uppercase tracking-widest text-emerald-600/50">
                                            No photo
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                     </div>
                 </div>

                <!-- Savings & Loans Summary -->
                <div class="md:col-span-2 space-y-8">
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-[#0E211A] p-8 shadow-[0_0_20px_rgba(16,185,129,0.05)] rounded-3xl border border-emerald-900/50 relative overflow-hidden group hover:border-emerald-500/50 transition-all duration-300 hover:-translate-y-1">
                            <div class="absolute -right-4 -bottom-4 text-emerald-900/30 text-8xl group-hover:scale-110 group-hover:text-emerald-900/40 transition-transform"><i class="fas fa-piggy-bank"></i></div>
                            <div class="relative z-10">
                                <div class="text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-2 flex items-center gap-2 group-hover:text-emerald-400 transition-colors"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Total Contributions</div>
                                <div class="text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight">₦{{ number_format($member->savings()->where('type', 'deposit')->where('status', 'approved')->sum('amount'), 2) }}</div>
                            </div>
                        </div>
                        <div class="bg-[#0E211A] p-8 shadow-[0_0_20px_rgba(251,191,36,0.05)] rounded-3xl border border-emerald-900/50 relative overflow-hidden group hover:border-gold/30 transition-all duration-300 hover:-translate-y-1">
                            <div class="absolute -right-4 -bottom-4 text-gold/5 text-8xl group-hover:scale-110 group-hover:text-gold/10 transition-transform"><i class="fas fa-hand-holding-usd"></i></div>
                            <div class="relative z-10">
                                <div class="text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-2 flex items-center gap-2 group-hover:text-gold transition-colors"><div class="w-1.5 h-1.5 rounded-full bg-gold"></div> Outstanding Loans</div>
                                 @php
                                     $loans = $member->loans()->whereIn('status', ['approved', 'active'])->get();
                                     $loanTotal = $loans->sum('total_repayment');
                                 @endphp
                                <div class="text-2xl sm:text-3xl md:text-4xl font-black text-white tracking-tight">₦{{ number_format($loanTotal, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Contribution Ledger -->
                    <div class="bg-[#0E211A] shadow-[0_0_20px_rgba(16,185,129,0.05)] rounded-3xl overflow-hidden border border-emerald-900/50">
                        <div class="border-b border-emerald-900/50 px-8 py-6 flex justify-between items-center bg-[#0B1A14]/50">
                            <h3 class="text-lg font-bold text-white flex items-center gap-3 tracking-tight">
                                <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-500/70"><i class="fas fa-calendar-check text-lg"></i></div>
                                Monthly Contribution Report
                            </h3>
                            <div class="bg-emerald-900/20 border border-emerald-500/30 px-4 py-2 rounded-lg text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] shadow-[inset_0_2px_5px_rgba(0,0,0,0.2)]">Year {{ date('Y') }}</div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-[#0B1A14] border-b border-emerald-900/50">
                                        <th class="px-8 py-5 text-[10px] font-black text-emerald-600/50 uppercase tracking-[0.2em]">Month/Year</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-emerald-600/50 uppercase tracking-[0.2em] text-right">Amount Contributed</th>
                                        <th class="px-8 py-5 text-[10px] font-black text-emerald-600/50 uppercase tracking-[0.2em] text-center w-32">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-emerald-900/30">
                                    @forelse($monthlyContributions as $month => $amount)
                                        <tr class="hover:bg-emerald-900/10 transition-colors group">
                                            <td class="px-8 py-5">
                                                <span class="font-bold text-emerald-100 text-sm group-hover:text-emerald-400 transition-colors">{{ $month }}</span>
                                            </td>
                                            <td class="px-8 py-5 text-right">
                                                <span class="font-black text-emerald-300 text-base">₦{{ number_format($amount, 2) }}</span>
                                            </td>
                                            <td class="px-8 py-5 text-center">
                                                @if($amount >= 2000)
                                                    <span class="inline-flex items-center justify-center w-full gap-1.5 px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest bg-emerald-900/30 text-emerald-400 border border-emerald-500/30">
                                                        <i class="fas fa-check-circle"></i> Active
                                                    </span>
                                                @elseif($amount > 0)
                                                    <span class="inline-flex items-center justify-center w-full gap-1.5 px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest bg-gold/10 text-gold border border-gold/30">
                                                        <i class="fas fa-exclamation-circle"></i> Partial
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center justify-center w-full gap-1.5 px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest bg-rose-900/20 text-rose-400 border border-rose-500/30">
                                                        <i class="fas fa-times-circle"></i> Missed
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-8 py-12 text-center text-emerald-600/50 text-[10px] font-black uppercase tracking-widest italic">
                                                <div class="text-3xl mb-3 opacity-30"><i class="fas fa-folder-open"></i></div>
                                                No monthly contributions recorded yet
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- Recent Activity -->
                    <div class="bg-[#0E211A] shadow-[0_0_20px_rgba(16,185,129,0.05)] rounded-3xl overflow-hidden border border-emerald-900/50">
                        <div class="border-b border-emerald-900/50 px-8 py-6 flex justify-between items-center bg-[#0B1A14]/50">
                            <h3 class="text-lg font-bold text-white flex items-center gap-3 tracking-tight">
                                <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-500/70"><i class="fas fa-stream text-lg"></i></div>
                                Recent Activity
                            </h3>
                            <span class="text-[10px] font-black text-emerald-600/70 uppercase tracking-widest px-3 py-1 rounded-lg bg-[#0E211A] border border-emerald-900/50">Savings & Loans</span>
                        </div>
                        <div class="p-0">
                            @php
                                $activities = collect();
                                foreach($member->savings as $s) {
                                    $activities->push([
                                        'id' => $s->id,
                                        'type' => 'Saving',
                                        'amount' => $s->amount,
                                        'date' => $s->transaction_date,
                                        'status' => $s->status ?? 'approved',
                                        'icon' => 'fa-piggy-bank',
                                        'color' => 'text-emerald-400 bg-emerald-900/20 border-emerald-500/30'
                                    ]);
                                }
                                foreach($member->loans as $l) {
                                    $activities->push([
                                        'id' => $l->id,
                                        'type' => 'Loan',
                                        'amount' => $l->amount,
                                        'date' => $l->created_at,
                                        'status' => $l->status,
                                        'icon' => 'fa-hand-holding-usd',
                                        'color' => 'text-gold bg-gold/10 border-gold/30'
                                    ]);
                                }
                                $activities = $activities->sortByDesc('date')->take(10);
                            @endphp

                            @if($activities->count() > 0)
                                <div class="divide-y divide-emerald-900/30">
                                    @foreach($activities as $activity)
                                        <div class="px-8 py-5 hover:bg-emerald-900/10 transition-colors flex justify-between items-center group/activity">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-xl border flex items-center justify-center {{ $activity['color'] }} shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] group-hover/activity:scale-105 transition-transform">
                                                    <i class="fas {{ $activity['icon'] }} text-lg"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-white">{{ $activity['type'] }}</p>
                                                    <p class="text-[10px] text-emerald-600/70 font-black uppercase tracking-widest mt-1">{{ $activity['date']->format('d M Y') }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center gap-6">
                                                @if(auth()->user()->isStaff() && $activity['type'] == 'Saving' && $activity['status'] == 'pending')
                                                    <div class="flex items-center gap-2 opacity-0 group-hover/activity:opacity-100 transition-opacity">
                                                        <form action="{{ route('savings.approve', $activity['id']) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="w-8 h-8 rounded-lg bg-emerald-900/30 text-emerald-400 hover:bg-emerald-500 hover:text-white transition-colors flex items-center justify-center border border-emerald-500/30" title="Approve">
                                                                <i class="fas fa-check text-xs"></i>
                                                            </button>
                                                        </form>
                                                        <button type="button" onclick="openSavingsRejectModal({{ $activity['id'] }})" class="w-8 h-8 rounded-lg bg-rose-900/20 text-rose-500 border border-rose-500/30 hover:bg-rose-500 hover:text-white transition-colors flex items-center justify-center" title="Reject">
                                                            <i class="fas fa-times text-xs"></i>
                                                        </button>
                                                    </div>
                                                @endif

                                                <div class="text-right">
                                                    <p class="text-lg font-black text-emerald-100 tracking-tight">₦{{ number_format($activity['amount'], 2) }}</p>
                                                    <span class="inline-block mt-1 text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded border {{ $activity['status'] == 'approved' || $activity['status'] == 'active' ? 'bg-emerald-900/30 text-emerald-400 border-emerald-500/30' : 'bg-gold/10 text-gold border-gold/30' }}">
                                                        {{ $activity['status'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-16 text-center text-emerald-600/50 text-[10px] font-black uppercase tracking-widest italic">
                                    <div class="text-4xl opacity-30 mb-4"><i class="fas fa-wind"></i></div>
                                    No recent transactions found
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Member Reject Modal -->
    <div id="memberRejectModal" class="fixed inset-0 z-[110] overflow-y-auto hidden">
        <div class="flex items-end sm:items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-[#0B1A14] bg-opacity-80 backdrop-blur-md transition-opacity" onclick="closeMemberRejectModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;

            <div class="relative inline-block align-middle bg-[#0E211A] border border-emerald-900/50 rounded-3xl text-left overflow-hidden shadow-[0_0_30px_rgba(16,185,129,0.1)] transform transition-all sm:my-8 sm:max-w-md w-full">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-rose-900 via-rose-500 to-rose-900 opacity-50"></div>
                <div class="p-8">
                    <div class="w-16 h-16 rounded-2xl bg-rose-900/20 border border-rose-500/30 text-rose-500 flex items-center justify-center text-3xl mx-auto mb-6 shadow-[inset_0_2px_10px_rgba(0,0,0,0.2)]">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white text-center tracking-tight mb-2">Reject Application</h3>
                    <p class="text-[10px] text-emerald-600/70 text-center font-black uppercase tracking-widest mb-6">Give a clear reason for rejecting this member.</p>
                    
                    <form id="memberRejectForm" method="POST">
                        @csrf
                        <textarea name="reason" rows="4" 
                            class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500/50 transition-all font-medium mb-6 text-emerald-100 placeholder:text-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" 
                            placeholder="e.g. invalid document, incomplete profile..."
                            required></textarea>
                        
                        <div class="flex gap-4">
                            <button type="button" onclick="closeMemberRejectModal()" class="flex-1 py-4 bg-[#0B1A14] border border-emerald-900/50 text-emerald-600/70 font-black uppercase tracking-widest text-[10px] rounded-xl hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 py-4 bg-gradient-to-r from-rose-600 to-rose-800 text-white font-black uppercase tracking-widest text-[10px] rounded-xl hover:from-rose-500 hover:to-rose-700 transition-all shadow-[0_0_15px_rgba(225,29,72,0.3)] active:scale-95 flex justify-center items-center gap-2">
                                <i class="fas fa-check-double text-base"></i> Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Savings Reject Modal -->
    <div id="savingsRejectModal" class="fixed inset-0 z-[110] overflow-y-auto hidden">
        <div class="flex items-end sm:items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-[#0B1A14] bg-opacity-80 backdrop-blur-md transition-opacity" onclick="closeSavingsRejectModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;

            <div class="relative inline-block align-middle bg-[#0E211A] border border-emerald-900/50 rounded-3xl text-left overflow-hidden shadow-[0_0_30px_rgba(16,185,129,0.1)] transform transition-all sm:my-8 sm:max-w-md w-full">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-rose-900 via-rose-500 to-rose-900 opacity-50"></div>
                
                <div class="p-8">
                    <div class="w-16 h-16 rounded-2xl bg-rose-900/20 border border-rose-500/30 text-rose-500 flex items-center justify-center text-3xl mx-auto mb-6 shadow-[inset_0_2px_10px_rgba(0,0,0,0.2)]">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white text-center tracking-tight mb-2">Reject Deposit</h3>
                    <p class="text-[10px] text-emerald-600/70 text-center font-black uppercase tracking-widest mb-6">Give a clear reason for rejecting this deposit.</p>
                    
                    <form id="savingsRejectForm" method="POST">
                        @csrf
                        <textarea name="reason" rows="4" 
                            class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500/50 transition-all font-medium mb-6 text-emerald-100 placeholder:text-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" 
                            placeholder="Enter rejection reason..."
                            required></textarea>
                        
                        <div class="flex gap-4">
                            <button type="button" onclick="closeSavingsRejectModal()" class="flex-1 py-4 bg-[#0B1A14] border border-emerald-900/50 text-emerald-600/70 font-black uppercase tracking-widest text-[10px] rounded-xl hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 py-4 bg-gradient-to-r from-rose-600 to-rose-800 text-white font-black uppercase tracking-widest text-[10px] rounded-xl hover:from-rose-500 hover:to-rose-700 transition-all shadow-[0_0_15px_rgba(225,29,72,0.3)] active:scale-95 flex justify-center items-center gap-2">
                                <i class="fas fa-check-double text-base"></i> Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openMemberRejectModal(id) {
            const modal = document.getElementById('memberRejectModal');
            const form = document.getElementById('memberRejectForm');
            form.action = `/members/${id}/reject`;
            modal.classList.remove('hidden');
        }

        function closeMemberRejectModal() {
            const modal = document.getElementById('memberRejectModal');
            modal.classList.add('hidden');
        }

        function openSavingsRejectModal(id) {
            const modal = document.getElementById('savingsRejectModal');
            const form = document.getElementById('savingsRejectForm');
            form.action = `/savings/${id}/reject`;
            modal.classList.remove('hidden');
        }

        function closeSavingsRejectModal() {
            const modal = document.getElementById('savingsRejectModal');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
