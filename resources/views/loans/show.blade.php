<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('loans.index') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-gold leading-tight tracking-tight uppercase">
                        Loan Details <span class="text-white/50 text-xl ml-2">#{{ $loan->id }}</span>
                    </h2>
                    <p class="text-[10px] text-emerald-500/60 font-black uppercase tracking-[0.2em] mt-1">
                        Application Ref: {{ $loan->application_number ?? 'N/A' }}
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="px-5 py-2.5 rounded-2xl text-[10px] font-black tracking-[0.25em] uppercase shadow-2xl border backdrop-blur-md
                    {{ $loan->status == 'approved' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : '' }}
                    {{ $loan->status == 'disbursed' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : '' }}
                    {{ $loan->status == 'pending' ? 'bg-gold/10 text-gold border-gold/20' : '' }}
                    {{ $loan->status == 'rejected' ? 'bg-red-500/10 text-red-400 border-red-500/20' : '' }}
                    {{ $loan->status == 'paid' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30 shadow-[0_0_20px_rgba(16,185,129,0.2)]' : '' }}">
                    <i class="fas {{ in_array($loan->status, ['approved', 'disbursed']) ? 'fa-check-circle' : ($loan->status == 'pending' ? 'fa-clock' : ($loan->status == 'paid' ? 'fa-crown' : 'fa-times-circle')) }} mr-2"></i>
                    {{ $loan->status }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Column: Financial Summary & Actions -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Financial Overview Card -->
                    <div class="bg-[#0B1A14] overflow-hidden shadow-2xl rounded-[2.5rem] border border-emerald-900/50">
                        <div class="p-10 text-center border-b border-emerald-900/30 bg-emerald-950/20">
                            <div class="mb-3">
                                <span class="text-[10px] text-emerald-600/70 font-black uppercase tracking-[0.3em]">Principal Amount</span>
                            </div>
                            <h3 class="text-5xl font-black text-gold tracking-tighter shadow-sm">₦{{ number_format($loan->amount, 2) }}</h3>
                            <div class="mt-6 flex items-center justify-center gap-3 text-[10px] font-black text-emerald-500/80 uppercase tracking-widest bg-emerald-900/30 inline-flex px-4 py-2 rounded-full border border-emerald-800/20 mx-auto">
                                <i class="fas fa-percentage text-gold text-xs"></i>
                                <span>{{ $loan->interest_rate }}% Interest Rate</span>
                            </div>
                        </div>
                        
                        <div class="p-8 space-y-6">
                            <div class="group p-6 bg-[#0E211A] rounded-3xl transition-all border border-emerald-900/50 shadow-inner">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-emerald-600/70 text-[10px] font-black uppercase tracking-widest">Total Repayment</span>
                                    <span class="font-black text-white text-sm">₦{{ number_format($loan->total_repayment, 2) }}</span>
                                </div>
                                <div class="h-2 w-full bg-emerald-950 rounded-full overflow-hidden border border-emerald-900/30 p-0.5">
                                    @php
                                        $paid = $loan->repayments->sum('amount');
                                        $total = $loan->total_repayment;
                                        $percent = $total > 0 ? ($paid / $total) * 100 : 0;
                                    @endphp
                                    <div class="h-full bg-gradient-to-r from-emerald-600 to-gold rounded-full transition-all duration-1000 shadow-[0_0_10px_rgba(255,215,0,0.3)]" style="width: {{ $percent }}%"></div>
                                </div>
                                <div class="flex justify-between mt-3">
                                    <span class="text-[9px] font-black text-emerald-800 uppercase tracking-widest">{{ round($percent) }}% Recovered</span>
                                    <span class="text-[9px] font-black text-emerald-800 uppercase tracking-widest">{{ round(100 - $percent) }}% Remaining</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                <div class="p-6 bg-emerald-900/20 rounded-2xl border border-emerald-500/20 flex justify-between items-center group">
                                    <div>
                                        <span class="block text-[9px] font-black text-emerald-500 uppercase tracking-widest mb-1">Total Paid</span>
                                        <span class="text-xl font-black text-white group-hover:text-emerald-400 transition-colors">₦{{ number_format($paid, 2) }}</span>
                                    </div>
                                    <div class="w-10 h-10 rounded-xl bg-emerald-800/30 flex items-center justify-center text-emerald-400">
                                        <i class="fas fa-check-double text-xs"></i>
                                    </div>
                                </div>
                                <div class="p-6 bg-gold/5 rounded-2xl border border-gold/20 flex justify-between items-center group">
                                    <div>
                                        <span class="block text-[9px] font-black text-gold/70 uppercase tracking-widest mb-1">Outstanding Balance</span>
                                        <span class="text-xl font-black text-white group-hover:text-gold transition-colors">₦{{ number_format($total - $paid, 2) }}</span>
                                    </div>
                                    <div class="w-10 h-10 rounded-xl bg-gold/10 flex items-center justify-center text-gold">
                                        <i class="fas fa-hourglass-half text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Actions Panel -->
                    @if(auth()->user()->isStaff())
                        @if($loan->status == 'pending')
                            <div class="bg-[#0B1A14] p-8 shadow-2xl rounded-[2.5rem] border border-emerald-900/50">
                                <h4 class="font-black text-white mb-8 uppercase text-[10px] tracking-[0.3em] border-b border-emerald-900/30 pb-6 flex items-center gap-3">
                                    <i class="fas fa-gavel text-gold text-xs"></i> Decision Terminal
                                </h4>
                                <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                    @csrf
                                    <div>
                                        <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-4">Security Signature Scan</label>
                                        <div class="relative group">
                                            <input type="file" name="signature_image" id="signature_image" class="sr-only" required onchange="document.getElementById('sig-name').textContent = this.files[0].name; document.getElementById('sig-name').classList.add('text-gold')">
                                            <label for="signature_image" class="flex flex-col items-center justify-center w-full p-6 bg-[#0E211A] border-2 border-dashed border-emerald-900/50 rounded-2xl cursor-pointer hover:bg-emerald-950/20 hover:border-gold/30 transition-all">
                                                <i class="fas fa-signature text-xl text-emerald-900 group-hover:text-gold mb-3 transition-colors"></i>
                                                <span id="sig-name" class="text-[10px] font-black text-emerald-800 uppercase tracking-widest">Select Signature Image</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <button name="status" value="approved" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-5 px-6 rounded-2xl transition-all shadow-[0_10px_30px_rgba(16,185,129,0.2)] hover:shadow-[0_15px_40px_rgba(16,185,129,0.3)] hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 uppercase tracking-[0.2em] text-[11px]">
                                            <i class="fas fa-check-circle"></i> Approve Loan
                                        </button>
                                        <button name="status" value="rejected" class="w-full bg-[#0E211A] text-red-600 border border-red-900/30 font-black py-5 px-6 rounded-2xl transition-all hover:bg-red-950/20 hover:border-red-500/50 flex items-center justify-center gap-3 uppercase tracking-[0.2em] text-[11px] active:scale-95">
                                            <i class="fas fa-times-circle"></i> Reject Application
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        @if($loan->status == 'approved' || $loan->status == 'disbursed')
                            <div class="bg-[#0B1A14] p-8 shadow-2xl rounded-[2.5rem] border border-emerald-900/50">
                                <h4 class="font-black text-white mb-8 uppercase text-[10px] tracking-[0.3em] flex items-center gap-3 border-b border-emerald-900/30 pb-6">
                                    <i class="fas fa-keyboard text-gold text-xs"></i> Record Payment
                                </h4>
                                <form id="repaymentForm" action="{{ route('repayments.store') }}" method="POST" class="space-y-6">
                                    @csrf
                                    <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                                    <div>
                                        <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-4">Amount to pay (₦)</label>
                                        <div class="relative group">
                                            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-600/70 font-black text-xl transition-colors group-focus-within:text-gold">₦</div>
                                            <input id="amount" type="text" name="amount" 
                                                inputmode="numeric"
                                                oninput="
                                                    let val = this.value.replace(/[^0-9.]/g, '');
                                                    if (val.split('.').length > 2) val = val.replace(/\.+$/, '');
                                                    let parts = val.split('.');
                                                    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                                    this.value = parts.join('.');
                                                "
                                                onblur="
                                                    let val = this.value.replace(/,/g, '');
                                                    if (val && !isNaN(val)) {
                                                        this.value = parseFloat(val).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                                    }
                                                "
                                                class="w-full pl-14 pr-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-black text-2xl tracking-tighter transition-all focus:outline-none placeholder-emerald-900/30" 
                                                placeholder="0,000.00" required>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-3">
                                            <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest">Date</label>
                                            <input type="date" name="paid_at" value="{{ date('Y-m-d') }}" class="w-full px-5 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 text-[11px] font-black text-white uppercase tracking-wider focus:outline-none" required>
                                        </div>
                                        <div class="space-y-3">
                                            <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-widest">Method</label>
                                            <select name="payment_method" class="w-full px-5 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 text-[11px] font-black text-white uppercase tracking-wider focus:outline-none cursor-pointer appearance-none">
                                                <option value="Cash">Cash</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="Deduction">Deduction</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full bg-gradient-to-r from-gold to-yellow-600 hover:from-yellow-700 hover:to-gold text-[#0B1A14] font-black py-5 px-6 rounded-2xl transition-all shadow-[0_10px_30px_rgba(255,215,0,0.15)] hover:shadow-[0_15px_40px_rgba(255,215,0,0.25)] hover:-translate-y-1 active:scale-95 uppercase tracking-[0.25em] text-[11px] mt-4 flex items-center justify-center gap-3">
                                        <i class="fas fa-save mb-0.5"></i>
                                        Post Repayment
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif

                    <!-- Member Actions -->
                    @if(!auth()->user()->isStaff() && in_array($loan->status, ['approved', 'disbursed', 'pending_payout']))
                        <div class="bg-[#0B1A14] p-8 shadow-2xl rounded-[2.5rem] border border-emerald-900/50 relative overflow-hidden group">
                            <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                                <i class="fas fa-hand-holding-usd text-8xl text-gold"></i>
                            </div>
                            <h4 class="font-black text-white mb-6 uppercase text-[10px] tracking-[0.3em] border-b border-emerald-900/30 pb-6 flex items-center gap-3">
                                <i class="fas fa-rocket text-gold text-xs"></i> Repayment Action
                            </h4>
                            <p class="text-[11px] text-emerald-600/70 mb-8 font-black uppercase tracking-widest leading-relaxed">Submit your proof of payment for this month's installment to keep your account in good standing.</p>
                            <a href="{{ route('repayments.create') }}" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-6 px-6 rounded-2xl transition-all shadow-2xl shadow-emerald-900/50 hover:shadow-emerald-500/40 hover:-translate-y-1.5 active:scale-95 flex items-center justify-center gap-4 uppercase tracking-[0.25em] text-[11px]">
                                <i class="fas fa-upload mb-0.5"></i>
                                Upload Payment Proof
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Context & History -->
                <div class="lg:col-span-2 space-y-10">
                    <!-- Identity & Basic Info -->
                    <div class="bg-[#0B1A14] overflow-hidden shadow-2xl rounded-[3rem] border border-emerald-900/50">
                        <div class="p-10 md:p-12">
                            <div class="flex flex-col md:flex-row items-center gap-8 mb-12">
                                <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-emerald-900/40 to-[#0B1A14] border border-emerald-500/20 flex items-center justify-center text-5xl text-gold shadow-2xl shadow-emerald-900/50 relative group">
                                    <div class="absolute inset-0 bg-gold/5 rounded-[2rem] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="text-center md:text-left">
                                    <span class="text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.4em]">Borrower Profile</span>
                                    <h3 class="text-4xl font-black text-white tracking-tight mt-1">{{ $loan->member->full_name }}</h3>
                                    <div class="flex items-center justify-center md:justify-start gap-4 mt-2">
                                        <span class="text-xs text-emerald-500 font-black uppercase tracking-widest">ID: {{ $loan->member->account_number }}</span>
                                        <div class="w-1.5 h-1.5 rounded-full bg-gold/30"></div>
                                        <span class="text-xs text-emerald-700 font-bold uppercase tracking-widest">Active Member</span>
                                    </div>
                                </div>
                                <div class="md:ml-auto">
                                    <a href="{{ route('members.show', $loan->member) }}" class="px-8 py-4 bg-emerald-950/30 hover:bg-[#0E211A] rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 hover:text-gold border border-emerald-900/50 transition-all flex items-center gap-3 group active:scale-95">
                                        <i class="fas fa-external-link-alt group-hover:rotate-12 transition-transform"></i> View Profile
                                    </a>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-10">
                                <div class="space-y-2">
                                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-[0.3em]">Tenure</span>
                                    <p class="text-2xl font-black text-white">{{ $loan->duration_months }} <span class="text-[10px] text-emerald-800 ml-1">Months</span></p>
                                </div>
                                <div class="space-y-2">
                                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-[0.3em]">Applied</span>
                                    <p class="text-2xl font-black text-white">{{ $loan->created_at->format('d M') }} <span class="text-[10px] text-emerald-800 ml-1">{{ $loan->created_at->format('Y') }}</span></p>
                                </div>
                                <div class="space-y-2">
                                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-[0.3em]">Rate</span>
                                    <p class="text-2xl font-black text-gold">{{ $loan->interest_rate }}<span class="text-[10px] text-gold/40 ml-1">%</span></p>
                                </div>
                                <div class="space-y-2">
                                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-[0.3em]">Monthly PI</span>
                                    <p class="text-2xl font-black text-emerald-400">₦{{ number_format($loan->total_repayment / $loan->duration_months, 2) }}</p>
                                </div>
                            </div>

                            <div class="mt-12 p-8 bg-emerald-950/20 rounded-[2rem] border border-emerald-900/30 relative">
                                <div class="absolute -top-3 left-8 px-4 py-1 bg-[#0B1A14] border border-emerald-900/50 rounded-full">
                                    <span class="text-[8px] font-black text-gold uppercase tracking-[0.4em]">Application Purpose</span>
                                </div>
                                <p class="text-[13px] text-emerald-100/80 leading-relaxed font-bold italic tracking-wide">"{{ $loan->purpose ?? 'Financial assistance for personal development and cooperative growth.' }}"</p>
                            </div>
                        </div>
                    </div>

                    <!-- Asset Photos (NEW) -->
                    @php
                        $assetPhotos = $loan->documents->where('document_type', 'Asset Image');
                    @endphp

                    @if($assetPhotos->count() > 0)
                        <div class="bg-[#0B1A14] overflow-hidden shadow-2xl rounded-[3rem] border border-emerald-900/50 p-10 md:p-12">
                            <h3 class="text-2xl font-black text-white flex items-center gap-4 uppercase tracking-tight mb-8">
                                <i class="fas fa-camera text-gold text-xl"></i>
                                Asset Photos
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                @foreach($assetPhotos as $photo)
                                    <div class="relative aspect-square rounded-2xl overflow-hidden border border-emerald-900/50 group">
                                        <img src="{{ Storage::url($photo->file_path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Asset Photo">
                                        <a href="{{ Storage::url($photo->file_path) }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xl">
                                            <i class="fas fa-expand-alt"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Repayment Statement -->
                    <div class="bg-[#0B1A14] overflow-hidden shadow-2xl rounded-[3rem] border border-emerald-900/50">
                        <div class="p-10 md:p-12">
                            <div class="flex items-center justify-between mb-10 border-b border-emerald-900/30 pb-8">
                                <h3 class="text-2xl font-black text-white flex items-center gap-4 uppercase tracking-tight">
                                    <i class="fas fa-receipt text-gold text-xl shadow-sm"></i>
                                    Repayment Ledger
                                </h3>
                                @if(!$loan->repayments->isEmpty())
                                    <button class="px-6 py-3 bg-[#0E211A] hover:bg-emerald-950 text-[10px] font-black uppercase tracking-[0.3em] text-emerald-500 rounded-xl border border-emerald-900/50 transition-all flex items-center gap-3 group active:scale-95">
                                        <i class="fas fa-file-pdf group-hover:scale-110 transition-transform"></i> Export Ledger
                                    </button>
                                @endif
                            </div>

                             @if($loan->repayments->isEmpty())
                                <div class="text-center py-20 bg-emerald-950/10 rounded-[2rem] border-2 border-dashed border-emerald-900/30">
                                    <div class="w-20 h-20 rounded-full bg-emerald-900/20 shadow-inner flex items-center justify-center text-emerald-900 mx-auto mb-6">
                                        <i class="fas fa-layer-group text-3xl"></i>
                                    </div>
                                    <p class="text-[10px] text-emerald-600 font-black uppercase tracking-[0.4em]">No Transactions Recorded</p>
                                    <p class="text-xs text-emerald-900 mt-2 font-bold">The repayment ledger will populate once payments are verified.</p>
                                </div>
                            @else
                                <div class="overflow-hidden rounded-[2rem] border border-emerald-900/30 shadow-2xl">
                                    <table class="min-w-full text-left">
                                        <thead>
                                            <tr class="bg-emerald-950/40 border-b border-emerald-900/50">
                                                <th class="px-8 py-6 text-[10px] font-black text-emerald-700 uppercase tracking-[0.3em]">Posting Date</th>
                                                <th class="px-8 py-6 text-[10px] font-black text-emerald-700 uppercase tracking-[0.3em]">Method</th>
                                                <th class="px-8 py-6 text-right text-[10px] font-black text-emerald-700 uppercase tracking-[0.3em]">Amount Recovered</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-emerald-900/20 bg-[#0E211A]/30">
                                            @foreach($loan->repayments->sortByDesc('paid_at') as $repayment)
                                                <tr class="group hover:bg-emerald-900/10 transition-all">
                                                    <td class="px-8 py-6 whitespace-nowrap">
                                                        <div class="flex items-center gap-4">
                                                            <div class="w-10 h-10 rounded-xl bg-emerald-900/40 border border-emerald-800/30 text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-all">
                                                                <i class="fas fa-calendar-check text-xs"></i>
                                                            </div>
                                                            <div>
                                                                <span class="text-xs font-black text-white group-hover:text-gold transition-colors">{{ $repayment->paid_at->format('d M, Y') }}</span>
                                                                <span class="block text-[8px] text-emerald-800 font-black uppercase tracking-widest mt-0.5">Post Confirmed</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-8 py-6 whitespace-nowrap">
                                                        <span class="px-4 py-2 bg-[#0B1A14] border border-emerald-900/50 rounded-xl text-[9px] font-black text-emerald-600 uppercase tracking-[0.2em] group-hover:border-gold/30 transition-all">
                                                            {{ $repayment->payment_method }}
                                                        </span>
                                                    </td>
                                                    <td class="px-8 py-6 whitespace-nowrap text-right">
                                                        <span class="text-lg font-black text-emerald-400 group-hover:text-white transition-colors">₦{{ number_format($repayment->amount, 2) }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-emerald-950/60 border-t border-emerald-900/50">
                                            <tr>
                                                <td colspan="2" class="px-8 py-8 text-right text-[10px] font-black text-emerald-700 uppercase tracking-[0.3em]">Cumulative Principal + Interest Recovered</td>
                                                <td class="px-8 py-8 text-right text-3xl font-black text-gold tracking-tighter shadow-sm">₦{{ number_format($loan->repayments->sum('amount'), 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const repaymentForm = document.getElementById('repaymentForm');
        if (repaymentForm) {
            repaymentForm.addEventListener('submit', function() {
                const amountInput = document.getElementById('amount');
                if (amountInput) {
                    amountInput.value = amountInput.value.replace(/,/g, '');
                }
            });
        }
    </script>
</x-app-layout>
