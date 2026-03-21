<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <a href="{{ route('repayments.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition text-sm font-bold flex items-center gap-1">
                        <i class="fas fa-arrow-left text-xs"></i> Repayments
                    </a>
                    <span class="text-gray-300 dark:text-gray-600">/</span>
                    <span class="text-xs font-black text-gray-500 uppercase tracking-widest">Verification</span>
                </div>
                <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight tracking-tight">
                    Repayment Verification
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Submitted {{ $repayment->created_at->format('l, d F Y') }}
                    &bull; ID #RP-{{ $repayment->id }}
                </p>
            </div>

            <span class="px-4 py-2 text-sm font-black uppercase tracking-widest rounded-2xl
                {{ $repayment->status === 'approved' ? 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' :
                   ($repayment->status === 'rejected' ? 'bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400' :
                   'bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400') }}">
                <i class="fas {{ $repayment->status === 'approved' ? 'fa-check-circle' : ($repayment->status === 'rejected' ? 'fa-times-circle' : 'fa-clock') }} mr-1.5"></i>
                {{ ucfirst($repayment->status) }}
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ===== LEFT COLUMN: Main Details ===== --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Member & Loan Info Card --}}
                    <div class="relative overflow-hidden bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 rounded-3xl p-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/3 via-transparent to-transparent"></div>
                        <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-4 relative z-10">Member & Loan Context</h3>
                        <div class="flex items-center gap-5 relative z-10">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-700 flex items-center justify-center text-white font-black text-2xl uppercase shadow-lg shadow-emerald-500/20 flex-shrink-0">
                                {{ strtoupper(substr($repayment->loan->member->full_name ?? 'M', 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="text-xl font-black text-gray-900 dark:text-white tracking-tight">
                                    {{ $repayment->loan->member->full_name ?? 'Unknown Member' }}
                                </p>
                                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                        Loan #ID: <span class="font-black text-gray-700 dark:text-gray-300">{{ $repayment->loan->application_number ?? 'N/A' }}</span>
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                        Member ID: <span class="font-black text-gray-700 dark:text-gray-300">{{ $repayment->loan->member->member_id ?? 'N/A' }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Repayment Amount</p>
                                <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400">
                                    ₦{{ number_format($repayment->amount, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Repayment Details --}}
                    <div class="bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 rounded-3xl p-6">
                        <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-5">Accounting Period & Meta</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                            <div class="bg-gray-50/80 dark:bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Month</p>
                                <p class="font-black text-gray-800 dark:text-gray-200">{{ $repayment->month }}</p>
                            </div>
                            <div class="bg-gray-50/80 dark:bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Year</p>
                                <p class="font-black text-gray-800 dark:text-gray-200">{{ $repayment->year }}</p>
                            </div>
                            <div class="bg-gray-50/80 dark:bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Method</p>
                                <p class="font-black text-gray-800 dark:text-gray-200 capitalize">{{ $repayment->payment_method ?? 'Bank Transfer' }}</p>
                            </div>
                            <div class="bg-gray-50/80 dark:bg-white/5 rounded-2xl p-4">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Paid At</p>
                                <p class="font-black text-gray-800 dark:text-gray-200">{{ $repayment->paid_at ? $repayment->paid_at->format('d M Y') : 'N/A' }}</p>
                            </div>
                        </div>

                        @if($repayment->admin_comment)
                            <div class="mt-5 {{ $repayment->status === 'rejected' ? 'bg-red-50/80 dark:bg-red-500/10 ring-red-500/20 text-red-700 dark:text-red-400' : 'bg-gray-50/80 dark:bg-white/5 ring-gray-900/5 text-gray-700 dark:text-gray-300' }} rounded-2xl p-4 ring-1">
                                <p class="text-[10px] font-black uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                    <i class="fas fa-comment-dots"></i> Admin Commentary
                                </p>
                                <p class="text-sm italic leading-relaxed">
                                    "{{ $repayment->admin_comment }}"
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Payment Proof --}}
                    <div class="bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 rounded-3xl p-6">
                        <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
                            <i class="fas fa-receipt text-emerald-500"></i>
                            Evidence of Payment (Bank Receipt)
                        </h3>

                        @if($repayment->proof_path)
                            @php
                                $ext = strtolower(pathinfo($repayment->proof_path, PATHINFO_EXTENSION));
                                $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                                $isPdf = $ext === 'pdf';
                            @endphp

                            @if($isImage)
                                <div class="rounded-2xl overflow-hidden ring-1 ring-gray-900/5 dark:ring-white/10 bg-gray-50 dark:bg-gray-800 relative group text-center">
                                    <img
                                        src="{{ asset('storage/' . $repayment->proof_path) }}"
                                        alt="Payment Proof"
                                        class="inline-block max-h-[500px] object-contain bg-gray-100 dark:bg-gray-800"
                                    >
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <a href="{{ asset('storage/' . $repayment->proof_path) }}" target="_blank"
                                           class="bg-white text-gray-800 text-xs font-black uppercase tracking-widest px-4 py-2 rounded-xl shadow-lg hover:shadow-xl transition transform hover:scale-105">
                                            <i class="fas fa-external-link-alt mr-1.5"></i> Launch Full-Size Viewer
                                        </a>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $repayment->proof_path) }}" target="_blank"
                                   class="mt-3 flex items-center justify-center gap-2 text-xs font-black text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition">
                                    <i class="fas fa-cloud-download-alt"></i> Download Original Proof
                                </a>

                            @elseif($isPdf)
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-10 flex flex-col items-center justify-center gap-6 ring-1 ring-gray-900/5 dark:ring-white/10 min-h-[250px]">
                                    <div class="w-20 h-20 rounded-3xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center text-red-500 text-4xl">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="text-center">
                                        <p class="font-black text-gray-800 dark:text-gray-200 text-lg">PDF Evidence Detected</p>
                                        <p class="text-sm text-gray-400 mt-1">Please open the document to verify the payment authenticity.</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $repayment->proof_path) }}" target="_blank"
                                       class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black uppercase tracking-[0.2em] px-10 py-4 rounded-2xl transition shadow-xl shadow-emerald-900/20 flex items-center gap-3">
                                        <i class="fas fa-external-link-square-alt"></i> Launch Document Viewer
                                    </a>
                                </div>
                            @else
                                <a href="{{ asset('storage/' . $repayment->proof_path) }}" target="_blank"
                                   class="flex items-center gap-4 p-6 bg-gray-50 dark:bg-gray-800 rounded-3xl ring-1 ring-gray-900/5 dark:ring-white/10 hover:ring-emerald-500/30 transition group">
                                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-paperclip text-2xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-black text-gray-800 dark:text-gray-200 text-base">Verified Attachment</p>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">{{ strtoupper($ext) }} DOCUMENT • CLICK TO INSPECT</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-300 group-hover:text-emerald-500 transition"></i>
                                </a>
                            @endif
                        @else
                            <div class="bg-rose-50 dark:bg-rose-500/5 rounded-3xl p-12 text-center ring-1 ring-dashed ring-rose-200 dark:ring-rose-500/20">
                                <div class="w-20 h-20 rounded-[2rem] bg-rose-100 dark:bg-rose-500/10 flex items-center justify-center text-rose-300 dark:text-rose-600 mx-auto mb-5">
                                    <i class="fas fa-exclamation-triangle text-3xl"></i>
                                </div>
                                <h4 class="font-black text-rose-900 dark:text-rose-400 uppercase tracking-tight text-lg mb-1">Physical Proof Missing</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">This transaction cannot be verified without a valid bank receipt.</p>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- ===== RIGHT COLUMN: Action Panel ===== --}}
                <div class="space-y-6">

                    {{-- Quick Accountability Card --}}
                    <div class="bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 rounded-3xl p-6">
                        <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-4">Accountability Summary</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Target Loan</span>
                                <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-lg uppercase tracking-tight">{{ $repayment->loan->application_number ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Amortization Period</span>
                                <span class="text-xs font-black text-gray-800 dark:text-gray-200">{{ $repayment->month }} {{ $repayment->year }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-white/5">
                                <span class="text-xs font-bold text-gray-500 dark:text-gray-400 italic">Verify and authorize this repayment to update the loan balance.</span>
                            </div>
                        </div>
                    </div>

                    {{-- Decision Panel --}}
                    @if($repayment->status === 'pending' && auth()->user()->canManageRepayments())
                        <div x-data="{ decision: 'approve' }" class="bg-white/70 dark:bg-gray-900/50 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 rounded-3xl p-6">
                            <h3 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-5">Ledger Authorization</h3>

                            {{-- Selector --}}
                            <div class="flex gap-2 mb-6 p-1 bg-gray-100 dark:bg-white/5 rounded-2xl">
                                <button
                                    @click="decision = 'approve'"
                                    :class="decision === 'approve' ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-900/20' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                                    class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle text-xs"></i> Authorize
                                </button>
                                <button
                                    @click="decision = 'reject'"
                                    :class="decision === 'reject' ? 'bg-rose-600 text-white shadow-xl shadow-rose-900/20' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                                    class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-times-circle text-xs"></i> Revoke
                                </button>
                            </div>

                            {{-- Approve Workflow --}}
                            <form x-show="decision === 'approve'" x-cloak
                                  action="{{ route('repayments.approve', $repayment) }}"
                                  method="POST" class="space-y-4">
                                @csrf
                                <div class="bg-emerald-50 dark:bg-emerald-500/10 rounded-2xl p-5 ring-1 ring-emerald-500/20 text-center">
                                    <i class="fas fa-shield-alt text-emerald-500 text-2xl mb-3 block"></i>
                                    <p class="text-xs font-bold text-emerald-800 dark:text-emerald-400 leading-relaxed">
                                        Authorizing this payment will subtract ₦{{ number_format($repayment->amount, 2) }} from the outstanding loan balance.
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Audit Notes (Optional)</label>
                                    <textarea name="comment" rows="2"
                                              class="w-full text-sm rounded-2xl border-gray-100 dark:border-white/10 focus:border-emerald-500 focus:ring-emerald-500 bg-gray-50/50 dark:bg-white/5 dark:text-white placeholder-gray-300 dark:placeholder-gray-700"
                                              placeholder="Any notes for the member record..."></textarea>
                                </div>
                                <button type="submit"
                                        onclick="return confirm('Officially authorize this ₦{{ number_format($repayment->amount, 2) }} repayment?')"
                                        class="w-full bg-emerald-600 hover:bg-emerald-500 text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all shadow-xl shadow-emerald-900/20 hover:shadow-2xl hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle"></i> Authorize and Commit
                                </button>
                            </form>

                            {{-- Reject Workflow --}}
                            <form x-show="decision === 'reject'" x-cloak
                                  action="{{ route('repayments.reject', $repayment) }}"
                                  method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest mb-3">
                                        <i class="fas fa-exclamation-circle mr-1"></i> Rejection Rationale *
                                    </label>
                                    <textarea name="comment" rows="4" required
                                              class="w-full text-sm rounded-2xl border-rose-100 dark:border-rose-500/20 focus:border-rose-500 focus:ring-rose-500 bg-rose-50/30 dark:bg-rose-500/5 dark:text-white placeholder-rose-200 dark:placeholder-rose-900"
                                              placeholder="Why is this proof being rejected? (e.g. proof mismatch, blurry image, etc.)"></textarea>
                                    <p class="text-[9px] text-gray-400 mt-2 font-medium">Note: The member will be notified of this reason.</p>
                                </div>
                                <button type="submit"
                                        class="w-full bg-rose-600 hover:bg-rose-700 text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] transition-all shadow-xl shadow-rose-900/20 active:scale-95 flex items-center justify-center gap-2">
                                    <i class="fas fa-times-circle"></i> VOID SUBMISSION
                                </button>
                            </form>
                        </div>

                    @elseif($repayment->status === 'approved')
                        <div class="bg-emerald-600 dark:bg-emerald-500/20 shadow-xl shadow-emerald-900/20 rounded-3xl p-8 text-center ring-1 ring-white/10">
                            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-white mx-auto mb-4">
                                <i class="fas fa-check-double text-2xl"></i>
                            </div>
                            <h4 class="font-black text-white text-lg uppercase tracking-tight mb-1">Authenticated</h4>
                            <p class="text-xs text-white/70 font-medium">Repayment successfully integrated into the ledger.</p>
                        </div>

                    @elseif($repayment->status === 'rejected')
                        <div class="bg-rose-600 dark:bg-rose-500/20 shadow-xl shadow-rose-900/20 rounded-3xl p-8 text-center ring-1 ring-white/10">
                            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-white mx-auto mb-4">
                                <i class="fas fa-times text-2xl"></i>
                            </div>
                            <h4 class="font-black text-white text-lg uppercase tracking-tight mb-1">Revoked</h4>
                            <p class="text-xs text-white/70 font-medium">Submission was not authenticated by the audit team.</p>
                        </div>
                    @endif

                    {{-- Contextual Ledger Link --}}
                    <a href="{{ route('repayments.index') }}"
                       class="flex items-center justify-center gap-2 w-full py-4 bg-white/50 dark:bg-gray-800/40 backdrop-blur-xl border border-gray-100 dark:border-white/5 rounded-2xl text-[10px] font-black text-gray-400 hover:text-gray-900 dark:hover:text-white uppercase tracking-[0.2em] transition-all">
                        <i class="fas fa-arrow-left"></i> Return to Registry
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
