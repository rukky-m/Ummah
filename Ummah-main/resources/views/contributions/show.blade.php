<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <a href="{{ route('contributions.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition text-sm font-bold flex items-center gap-1">
                        <i class="fas fa-arrow-left text-xs"></i> Contributions
                    </a>
                    <span class="text-gray-300 dark:text-gray-600">/</span>
                    <span class="text-xs font-black text-gray-500 uppercase tracking-widest">Review</span>
                </div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight tracking-tight">
                    Contribution Review
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Submitted {{ $contribution->transaction_date->format('l, d F Y') }}
                    &bull; Reference #{{ $contribution->id }}
                </p>
            </div>

            <span class="px-4 py-2 text-sm font-black uppercase tracking-widest rounded-2xl
                {{ $contribution->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' :
                   ($contribution->status === 'rejected' ? 'bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400' :
                   'bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400') }}">
                <i class="fas {{ $contribution->status === 'approved' ? 'fa-check-circle' : ($contribution->status === 'rejected' ? 'fa-times-circle' : 'fa-clock') }} mr-1.5"></i>
                {{ ucfirst($contribution->status) }}
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50/50 dark:bg-gray-900/30">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 px-5 py-4 rounded-2xl flex items-center gap-3 font-medium text-sm">
                    <i class="fas fa-check-circle text-lg flex-shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 px-5 py-4 rounded-2xl flex items-center gap-3 font-medium text-sm">
                    <i class="fas fa-exclamation-circle text-lg flex-shrink-0"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ===== LEFT COLUMN: Main Details ===== --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Member Info Card --}}
                    <div class="relative overflow-hidden bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 rounded-3xl p-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/3 via-transparent to-transparent"></div>
                        <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-4 relative z-10">Member Details</h3>
                        <div class="flex items-center gap-5 relative z-10">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-700 flex items-center justify-center text-white font-black text-2xl uppercase shadow-lg shadow-emerald-500/20 flex-shrink-0">
                                {{ strtoupper(substr($contribution->member->full_name ?? 'M', 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="text-xl font-black text-gray-900 dark:text-white tracking-tight">
                                    {{ $contribution->member->full_name ?? 'Unknown Member' }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mt-0.5">
                                    Member ID: <span class="font-black text-gray-700 dark:text-gray-300">{{ $contribution->member->member_id ?? 'N/A' }}</span>
                                </p>
                                @if($contribution->member?->user?->email)
                                    <p class="text-xs text-gray-400 mt-1">
                                        <i class="fas fa-envelope mr-1"></i>{{ $contribution->member->user->email }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Amount</p>
                                <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400">
                                    ₦{{ number_format($contribution->amount, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Contribution Details --}}
                    <div class="bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 rounded-3xl p-6">
                        <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-5">Contribution Details</h3>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="bg-gray-50/80 dark:bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Transaction Date</p>
                                <p class="font-black text-gray-800 dark:text-gray-200">{{ $contribution->transaction_date->format('d M Y') }}</p>
                            </div>
                            <div class="bg-gray-50/80 dark:bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Category</p>
                                <p class="font-black text-gray-800 dark:text-gray-200">{{ $contribution->category ?? 'Contribution' }}</p>
                            </div>
                            <div class="bg-gray-50/80 dark:bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Type</p>
                                <p class="font-black text-gray-800 dark:text-gray-200 capitalize">{{ $contribution->type ?? 'Deposit' }}</p>
                            </div>
                            <div class="bg-gray-50/80 dark:bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Submitted On</p>
                                <p class="font-black text-gray-800 dark:text-gray-200">{{ $contribution->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($contribution->notes)
                            <div class="mt-5 bg-amber-50/80 dark:bg-amber-500/10 rounded-2xl p-4 ring-1 ring-amber-500/20">
                                <p class="text-[10px] font-black text-amber-700 dark:text-amber-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                    <i class="fas fa-sticky-note"></i> Notes from Member
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300 italic leading-relaxed">
                                    "{{ $contribution->notes }}"
                                </p>
                            </div>
                        @endif

                        @if($contribution->rejection_reason)
                            <div class="mt-5 bg-red-50/80 dark:bg-red-500/10 rounded-2xl p-4 ring-1 ring-red-500/20">
                                <p class="text-[10px] font-black text-red-700 dark:text-red-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                    <i class="fas fa-exclamation-triangle"></i> Rejection Reason
                                </p>
                                <p class="text-sm text-red-700 dark:text-red-400 italic leading-relaxed">
                                    "{{ $contribution->rejection_reason }}"
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Payment Proof / Receipt --}}
                    <div class="bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 rounded-3xl p-6">
                        <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
                            <i class="fas fa-receipt text-emerald-500"></i>
                            Payment Proof / Receipt
                        </h3>

                        @if($contribution->payment_proof_path)
                            @php
                                $ext = strtolower(pathinfo($contribution->payment_proof_path, PATHINFO_EXTENSION));
                                $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                                $isPdf = $ext === 'pdf';
                            @endphp

                            @if($isImage)
                                <div class="rounded-2xl overflow-hidden ring-1 ring-gray-900/5 dark:ring-white/10 bg-gray-50 dark:bg-gray-800 relative group">
                                    <img
                                        src="{{ asset('storage/' . $contribution->payment_proof_path) }}"
                                        alt="Payment Proof"
                                        class="w-full max-h-96 object-contain bg-gray-100 dark:bg-gray-800"
                                    >
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <a href="{{ asset('storage/' . $contribution->payment_proof_path) }}" target="_blank"
                                           class="bg-white text-gray-800 text-xs font-black uppercase tracking-widest px-4 py-2 rounded-xl shadow-lg hover:shadow-xl transition transform hover:scale-105">
                                            <i class="fas fa-external-link-alt mr-1.5"></i> Open Full Image
                                        </a>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $contribution->payment_proof_path) }}" target="_blank"
                                   class="mt-3 flex items-center justify-center gap-2 text-xs font-black text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition">
                                    <i class="fas fa-download"></i> Download / Open in New Tab
                                </a>

                            @elseif($isPdf)
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-6 flex flex-col items-center justify-center gap-4 ring-1 ring-gray-900/5 dark:ring-white/10 min-h-[160px]">
                                    <div class="w-16 h-16 rounded-2xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center text-red-500">
                                        <i class="fas fa-file-pdf text-3xl"></i>
                                    </div>
                                    <div class="text-center">
                                        <p class="font-black text-gray-800 dark:text-gray-200 text-sm">PDF Document</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Click below to view the payment proof</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $contribution->payment_proof_path) }}" target="_blank"
                                       class="bg-red-500 hover:bg-red-600 text-white text-xs font-black uppercase tracking-widest px-6 py-2.5 rounded-xl transition hover:shadow-lg hover:shadow-red-500/20 flex items-center gap-2">
                                        <i class="fas fa-external-link-alt"></i> Open PDF
                                    </a>
                                </div>
                            @else
                                <a href="{{ asset('storage/' . $contribution->payment_proof_path) }}" target="_blank"
                                   class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl ring-1 ring-gray-900/5 dark:ring-white/10 hover:ring-emerald-500/30 transition group">
                                    <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-paperclip text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-gray-800 dark:text-gray-200 text-sm">View Attached Document</p>
                                        <p class="text-xs text-gray-400">{{ strtoupper($ext) }} file • Click to open</p>
                                    </div>
                                    <i class="fas fa-external-link-alt ml-auto text-gray-400 group-hover:text-emerald-500 transition"></i>
                                </a>
                            @endif
                        @else
                            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-8 text-center ring-1 ring-dashed ring-gray-300 dark:ring-white/10">
                                <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-300 dark:text-gray-600 mx-auto mb-3">
                                    <i class="fas fa-image text-2xl"></i>
                                </div>
                                <p class="font-black text-gray-400 dark:text-gray-500 text-sm">No payment proof attached</p>
                                <p class="text-xs text-gray-400 dark:text-gray-600 mt-1">Member did not upload a receipt.</p>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- ===== RIGHT COLUMN: Action Panel ===== --}}
                <div class="space-y-6">

                    {{-- Quick Summary --}}
                    <div class="bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 rounded-3xl p-6">
                        <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-4">Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Member</span>
                                <span class="text-xs font-black text-gray-800 dark:text-gray-200">{{ $contribution->member->full_name ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Amount</span>
                                <span class="text-sm font-black text-emerald-600 dark:text-emerald-400">₦{{ number_format($contribution->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Date</span>
                                <span class="text-xs font-black text-gray-800 dark:text-gray-200">{{ $contribution->transaction_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Status</span>
                                <span class="text-xs font-black uppercase
                                    {{ $contribution->status === 'approved' ? 'text-emerald-600' : ($contribution->status === 'rejected' ? 'text-red-600' : 'text-amber-600') }}">
                                    {{ $contribution->status }}
                                </span>
                            </div>
                            @if($contribution->recordedBy ?? null)
                                <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-white/5">
                                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Reviewed By</span>
                                    <span class="text-xs font-black text-gray-800 dark:text-gray-200">{{ $contribution->recordedBy->name ?? '—' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Action Panel --}}
                    @if($contribution->status === 'pending' && auth()->user()->canManageContributions())
                        <div x-data="{ action: 'approve' }" class="bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 rounded-3xl p-6">
                            <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-5">Your Decision</h3>

                            {{-- Toggle --}}
                            <div class="flex gap-2 mb-5 p-1 bg-gray-100 dark:bg-white/5 rounded-2xl">
                                <button
                                    @click="action = 'approve'"
                                    :class="action === 'approve' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                                    class="flex-1 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center gap-1.5">
                                    <i class="fas fa-check-circle"></i> Approve
                                </button>
                                <button
                                    @click="action = 'reject'"
                                    :class="action === 'reject' ? 'bg-red-500 text-white shadow-lg shadow-red-500/20' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                                    class="flex-1 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center gap-1.5">
                                    <i class="fas fa-times-circle"></i> Reject
                                </button>
                            </div>

                            {{-- Approve Form --}}
                            <form x-show="action === 'approve'" x-cloak
                                  action="{{ route('contributions.approve', $contribution) }}"
                                  method="POST" class="space-y-4">
                                @csrf
                                <div class="bg-emerald-50 dark:bg-emerald-500/10 rounded-2xl p-4 ring-1 ring-emerald-500/20 text-center">
                                    <i class="fas fa-check-double text-emerald-500 text-2xl mb-2 block"></i>
                                    <p class="text-xs font-bold text-emerald-700 dark:text-emerald-400">
                                        Approving will confirm receipt of ₦{{ number_format($contribution->amount, 2) }} and count it towards the member's contribution record.
                                    </p>
                                </div>
                                <button type="submit"
                                        onclick="return confirm('Confirm approval of ₦{{ number_format($contribution->amount, 2) }}?')"
                                        class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3.5 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all shadow-lg shadow-emerald-500/20 hover:shadow-xl hover:shadow-emerald-500/30 active:scale-95 flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle"></i> Confirm Approval
                                </button>
                            </form>

                            {{-- Reject Form --}}
                            <form x-show="action === 'reject'" x-cloak
                                  action="{{ route('contributions.reject', $contribution) }}"
                                  method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-black text-red-600 dark:text-red-400 uppercase tracking-widest mb-2">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Reason for Rejection *
                                    </label>
                                    <textarea name="reason" rows="4" required
                                              class="w-full text-sm rounded-2xl border-red-200 dark:border-red-500/30 focus:border-red-500 focus:ring-red-500 bg-red-50/50 dark:bg-red-500/5 dark:text-white placeholder-red-300 dark:placeholder-red-800 text-red-900"
                                              placeholder="State clearly why this contribution is being rejected (e.g. amount mismatch, invalid receipt, etc.)..."></textarea>
                                    <p class="text-[9px] text-gray-400 mt-1 italic">This reason will be visible to the member.</p>
                                </div>
                                <button type="submit"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white py-3.5 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all shadow-lg shadow-red-500/20 hover:shadow-xl hover:shadow-red-500/30 active:scale-95 flex items-center justify-center gap-2">
                                    <i class="fas fa-times-circle"></i> Confirm Rejection
                                </button>
                            </form>
                        </div>

                    @elseif($contribution->status === 'approved')
                        <div class="bg-emerald-50 dark:bg-emerald-500/10 backdrop-blur-2xl shadow-sm ring-1 ring-emerald-500/20 rounded-3xl p-6 text-center">
                            <div class="w-14 h-14 rounded-full bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mx-auto mb-3">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                            <p class="font-black text-emerald-700 dark:text-emerald-400 text-sm uppercase tracking-wide">Approved</p>
                            <p class="text-xs text-emerald-600/70 dark:text-emerald-500 mt-1">This contribution has been verified and recorded.</p>
                        </div>

                    @elseif($contribution->status === 'rejected')
                        <div class="bg-red-50 dark:bg-red-500/10 backdrop-blur-2xl shadow-sm ring-1 ring-red-500/20 rounded-3xl p-6 text-center">
                            <div class="w-14 h-14 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center text-red-600 dark:text-red-400 mx-auto mb-3">
                                <i class="fas fa-times-circle text-2xl"></i>
                            </div>
                            <p class="font-black text-red-700 dark:text-red-400 text-sm uppercase tracking-wide">Rejected</p>
                            <p class="text-xs text-red-600/70 dark:text-red-500 mt-1">This contribution was not approved.</p>
                        </div>
                    @endif

                    {{-- Back Button --}}
                    <a href="{{ route('contributions.index') }}"
                       class="flex items-center justify-center gap-2 w-full py-3 bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl ring-1 ring-gray-900/5 dark:ring-white/10 rounded-2xl text-xs font-black text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:ring-gray-300 dark:hover:ring-white/20 transition-all">
                        <i class="fas fa-arrow-left"></i> Back to All Contributions
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
