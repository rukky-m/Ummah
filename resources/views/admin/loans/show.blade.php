<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white tracking-tight flex items-center gap-3">
            <a href="{{ route('admin.loans.index') }}" class="w-8 h-8 rounded-full bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all text-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            {{ __('Loan Application Review') }}: <span class="text-emerald-400 ml-1 bg-emerald-900/30 border border-emerald-500/30 px-3 py-1 rounded-lg text-lg">{{ $loan->application_number }}</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Applicant Info -->
            <div class="bg-[#0E211A] overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900 opacity-50"></div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div class="flex items-center gap-5">
                            <div class="w-20 h-20 rounded-full bg-[#0B1A14] border-2 border-emerald-900/50 flex flex-col items-center justify-center text-emerald-500/50 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                                <i class="fas fa-user text-2xl mb-1"></i>
                                <span class="text-[8px] font-black uppercase tracking-widest text-emerald-600/70">{{ $loan->member->member_id ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <h3 class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-1">Applicant Details</h3>
                                <p class="text-3xl font-bold text-white tracking-tight">{{ $loan->member->first_name ?? '' }} {{ $loan->member->last_name ?? '' }}</p>
                                <div class="flex items-center gap-3 mt-3 text-sm">
                                    <p class="text-emerald-600/70"><span class="font-bold text-emerald-400">Applied:</span> {{ $loan->created_at->format('M d, Y') }}</p>
                                    <span class="w-1 h-1 rounded-full bg-emerald-900/50"></span>
                                    <p><span class="uppercase tracking-widest text-[10px] font-black px-2 py-0.5 rounded-md border {{ $loan->status == 'disbursed' ? 'bg-blue-900/30 border-blue-500/30 text-blue-400' : ($loan->status == 'approved' ? 'bg-emerald-900/30 border-emerald-500/30 text-emerald-400' : ($loan->status == 'rejected' ? 'bg-rose-900/30 border-rose-500/30 text-rose-400' : 'bg-amber-900/30 border-amber-500/30 text-amber-400')) }}">{{ $loan->status }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="md:text-right bg-[#0B1A14] p-6 rounded-2xl border border-emerald-900/50">
                             <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-1">Amount Requested</p>
                             <p class="text-4xl font-black text-emerald-400 tracking-tight">₦{{ number_format($loan->amount, 2) }}</p>
                             <p class="text-sm font-medium text-emerald-100 mt-2 px-3 py-1 bg-emerald-900/20 inline-block rounded-lg border border-emerald-500/20">{{ $loan->purpose }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Main Details -->
                <div class="md:col-span-2 space-y-8">
                    
                    <!-- Application Details -->
                    <div class="bg-[#0E211A] overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl p-8">
                        <div class="flex justify-between items-center border-b border-emerald-900/30 pb-4 mb-6">
                            <h3 class="font-bold text-lg text-white tracking-tight">APPLICATION DETAILS</h3>
                            <span class="text-[10px] uppercase font-black text-emerald-400 bg-emerald-900/30 border border-emerald-500/30 px-3 py-1 rounded-lg tracking-widest">{{ $loan->type ?? 'Standard' }}</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6 text-sm mb-8">
                            <div class="bg-[#0B1A14] p-4 rounded-xl border border-emerald-900/50 flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50 mb-1">Duration</span>
                                <div class="font-bold text-lg text-emerald-100">{{ $loan->duration_months }} <span class="text-sm text-emerald-600/70">months</span></div>
                            </div>
                            <div class="bg-[#0B1A14] p-4 rounded-xl border border-emerald-900/50 flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50 mb-1">Repayment Frequency</span>
                                <div class="font-bold text-lg text-emerald-100 capitalize">{{ $loan->repayment_frequency }}</div>
                            </div>
                            <div class="bg-[#0B1A14] p-4 rounded-xl border border-emerald-900/50 flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50 mb-1">Monthly Payment (Est)</span>
                                <div class="font-bold text-lg text-emerald-100">₦{{ number_format($loan->total_repayment / $loan->duration_months, 2) }}</div>
                            </div>
                            <div class="bg-emerald-900/20 p-4 rounded-xl border border-emerald-500/30 flex flex-col shadow-[inset_0_2px_15px_rgba(16,185,129,0.1)]">
                                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-400 mb-1">Total Repayment</span>
                                <div class="font-black text-xl text-emerald-300">₦{{ number_format($loan->total_repayment, 2) }}</div>
                            </div>
                        </div>

                        <!-- Special Loan Details from Metadata -->
                        @if($loan->metadata)
                            <div class="bg-[#0B1A14] border border-emerald-900/50 p-6 rounded-2xl mb-8">
                                <h4 class="text-[10px] font-black text-emerald-600/70 uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fas fa-info-circle"></i> Request Specifics</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                    @foreach($loan->metadata as $key => $value)
                                        @if($key !== 'items' && $key !== 'guarantors' && !is_array($value))
                                            <div class="border-l-2 border-emerald-900/50 pl-3">
                                                <span class="text-emerald-600/50 block text-[10px] uppercase font-black tracking-widest mb-1">{{ str_replace('_', ' ', $key) }}</span>
                                                <span class="font-bold text-emerald-100 text-base">{{ $value }}</span>
                                            </div>
                                        @elseif($key === 'vendor' && is_array($value))
                                            <div class="col-span-2 bg-[#0E211A] p-4 rounded-xl border border-emerald-900/50">
                                                <span class="text-emerald-600/50 block text-[10px] uppercase font-black tracking-widest mb-2 flex items-center gap-2"><i class="fas fa-store"></i> Vendor Details</span>
                                                <span class="font-bold text-white text-lg block">{{ $value['name'] }}</span>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="bg-emerald-900/30 text-emerald-400 text-xs px-2 py-0.5 rounded-md border border-emerald-500/30">{{ $value['bank'] ?? 'Unknown Bank' }}</span>
                                                    <span class="text-sm font-mono font-bold text-emerald-100">{{ $value['account_number'] ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Items List (Editable for Admins) -->
                        @if(isset($loan->metadata['items']) && count($loan->metadata['items']) > 0)
                            <div class="mb-8">
                                <div class="flex justify-between items-center mb-4 border-b border-emerald-900/30 pb-3">
                                    <h4 class="font-bold text-white tracking-tight flex items-center gap-2"><i class="fas fa-clipboard-list text-emerald-500/70"></i> Requested Items</h4>
                                    <!-- Only show edit button if pending -->
                                    @if($loan->status == 'pending')
                                        <button onclick="document.getElementById('editItemsModal').classList.remove('hidden')" class="text-[10px] bg-[#0B1A14] border border-emerald-900/50 text-emerald-400 hover:bg-emerald-900/30 hover:shadow-[0_0_10px_rgba(16,185,129,0.2)] px-4 py-2 rounded-lg transition-all font-black uppercase tracking-widest flex items-center gap-2">
                                            <i class="fas fa-edit"></i> Edit Items
                                        </button>
                                    @endif
                                </div>
                                <div class="overflow-x-auto border border-emerald-900/50 rounded-2xl shadow-[0_0_15px_rgba(16,185,129,0.02)]">
                                    <table class="w-full text-sm text-left">
                                        <thead class="bg-[#0B1A14] text-[10px] font-black text-emerald-600/70 uppercase tracking-widest border-b border-emerald-900/50">
                                            <tr>
                                                <th class="px-5 py-4">Item</th>
                                                <th class="px-5 py-4 text-center">Qty</th>
                                                <th class="px-5 py-4 text-right">Price</th>
                                                <th class="px-5 py-4 text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-emerald-900/30 bg-[#0E211A]">
                                            @foreach($loan->metadata['items'] as $item)
                                            <tr class="hover:bg-emerald-900/10 transition-colors">
                                                <td class="px-5 py-4 font-bold text-emerald-100">{{ $item['name'] }}</td>
                                                <td class="px-5 py-4 text-center text-emerald-600/70 font-black">{{ $item['quantity'] }}</td>
                                                <td class="px-5 py-4 text-right text-emerald-600/70">
                                                    {{ isset($item['price']) ? number_format($item['price']) : 'N/A' }}
                                                </td>
                                                <td class="px-5 py-4 text-right font-black text-emerald-300">
                                                    {{ isset($item['price']) ? number_format($item['quantity'] * $item['price']) : 'N/A' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-[#0B1A14] font-bold border-t border-emerald-900/50">
                                            <tr>
                                                <td colspan="3" class="px-5 py-4 text-right text-[10px] uppercase tracking-widest text-emerald-600/50">Total Amount</td>
                                                <td class="px-5 py-4 text-right text-emerald-400 font-black text-lg shadow-[inset_0_2px_10px_rgba(0,0,0,0.1)]">₦{{ number_format($loan->amount, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="mt-8">
                            <h4 class="font-bold text-white tracking-tight mb-3 flex items-center gap-2"><i class="fas fa-quote-left text-emerald-500/50"></i> Narration</h4>
                            <div class="bg-[#0B1A14] border border-emerald-900/50 p-6 rounded-2xl text-emerald-100 italic font-medium leading-relaxed relative">
                                "{{ $loan->narration }}"
                                <div class="absolute bottom-4 right-4 text-emerald-900/30 text-4xl"><i class="fas fa-quote-right"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Guarantors -->
                    <div class="bg-[#0E211A] overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl p-8">
                         <h3 class="font-bold text-lg text-white border-b border-emerald-900/30 pb-4 mb-6 tracking-tight flex items-center gap-2"><i class="fas fa-users-cog text-emerald-500/70"></i> GUARANTORS</h3>
                         <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                             @foreach($loan->guarantors as $guarantor)
                                <div class="bg-[#0B1A14] p-5 rounded-2xl border border-emerald-900/50 flex flex-col hover:border-emerald-500/30 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-emerald-900/20 border border-emerald-500/20 flex items-center justify-center text-emerald-500 text-lg shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)]"><i class="fas fa-user-shield"></i></div>
                                        <div>
                                            <div class="font-bold text-white">{{ $guarantor->name }}</div>
                                            <div class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mt-1">{{ $guarantor->relationship }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-emerald-900/30 text-sm font-medium text-emerald-100 flex items-center gap-2">
                                        <i class="fas fa-phone-alt text-emerald-600/50"></i> {{ $guarantor->phone }}
                                    </div>
                                </div>
                             @endforeach
                         </div>
                    </div>
                    
                    <!-- Documents -->
                    <div class="bg-[#0E211A] overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl p-8">
                         <h3 class="font-bold text-lg text-white border-b border-emerald-900/30 pb-4 mb-6 tracking-tight flex items-center gap-2"><i class="fas fa-folder-open text-emerald-500/70"></i> DOCUMENTS</h3>
                         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                             @forelse($loan->documents->where('document_type', '!=', 'Asset Image') as $doc)
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="group flex flex-col items-center justify-center gap-3 p-6 bg-[#0B1A14] border border-emerald-900/50 rounded-2xl hover:bg-emerald-900/20 hover:border-emerald-500/50 transition-all text-center">
                                    <div class="w-12 h-12 rounded-xl bg-[#0E211A] border border-emerald-900/50 flex items-center justify-center text-2xl text-emerald-400 group-hover:scale-110 group-hover:bg-gold/10 group-hover:text-gold group-hover:border-gold/30 transition-all">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="w-full overflow-hidden">
                                        <div class="font-bold text-emerald-100 text-sm truncate mb-1">{{ $doc->document_type }}</div>
                                        <div class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70 group-hover:text-gold transition-colors">View / Download</div>
                                    </div>
                                </a>
                             @empty
                                <div class="col-span-full py-8 text-center bg-[#0B1A14] rounded-2xl border border-dashed border-emerald-900/50">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50">No standard documents uploaded</p>
                                </div>
                             @endforelse
                         </div>
                    </div>

                    <!-- Asset Photos (NEW) -->
                    <div class="bg-[#0E211A] overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl p-8">
                         <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-emerald-900/30 pb-4 mb-6 gap-4">
                            <h3 class="font-bold text-lg text-white tracking-tight flex items-center gap-2"><i class="fas fa-camera text-emerald-500/70"></i> ASSET PHOTOS</h3>
                            
                            @if($loan->status !== 'rejected')
                                <form action="{{ route('admin.loans.upload_assets', $loan) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 w-full sm:w-auto">
                                    @csrf
                                    <label class="cursor-pointer bg-[#0B1A14] border border-emerald-900/50 text-emerald-400 hover:bg-emerald-900/30 px-4 py-2 rounded-lg transition-all text-[10px] font-black uppercase tracking-widest flex items-center gap-2 whitespace-nowrap">
                                        <i class="fas fa-plus-circle"></i> Add Photos
                                        <input type="file" name="images[]" multiple accept="image/*" class="hidden" onchange="this.form.submit()">
                                    </label>
                                </form>
                            @endif
                         </div>

                         @php
                            $assetPhotos = $loan->documents->where('document_type', 'Asset Image');
                         @endphp

                         <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                             @forelse($assetPhotos as $photo)
                                <div class="relative aspect-square group overflow-hidden rounded-2xl border border-emerald-900/50 bg-[#0B1A14]">
                                    <img src="{{ Storage::url($photo->file_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Asset Photo">
                                    
                                    <!-- Overlay Actions -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-3 gap-2">
                                        <div class="flex justify-between items-center bg-[#0B1A14]/80 backdrop-blur-md p-2 rounded-xl border border-emerald-500/20">
                                            <a href="{{ Storage::url($photo->file_path) }}" target="_blank" class="text-emerald-400 hover:text-white transition-colors">
                                                <i class="fas fa-expand-alt"></i>
                                            </a>
                                            <form action="{{ route('admin.loans.delete_asset_image', $photo) }}" method="POST" onsubmit="return confirm('Delete this asset photo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-400 transition-colors">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                             @empty
                                <div class="col-span-full py-12 text-center bg-[#0B1A14] rounded-2xl border border-dashed border-emerald-900/50">
                                    <div class="w-16 h-16 rounded-full bg-emerald-900/10 border border-emerald-500/10 flex items-center justify-center text-emerald-700/30 text-2xl mx-auto mb-4">
                                        <i class="fas fa-images"></i>
                                    </div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50">No asset photos uploaded yet</p>
                                    <p class="text-[9px] text-emerald-800 font-bold uppercase tracking-widest mt-1">Capture photos of the physical assets being loaned</p>
                                </div>
                             @endforelse
                         </div>
                    </div>

                </div>

                <!-- Approval Sidebar -->
                <div class="md:col-span-1 space-y-8">
                    
                    <!-- Approval Status -->
                    <div class="bg-[#0E211A] overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl p-8 relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#0B1A14] to-transparent opacity-50 z-0"></div>
                        <div class="relative z-10">
                            <h3 class="font-bold text-white mb-6 text-center tracking-tight flex items-center justify-center gap-2">
                                <i class="fas fa-tasks text-emerald-500/70"></i> APPROVAL WORKFLOW
                            </h3>
                            
                            <div class="space-y-4 mb-8">
                                @php
                                    $manager = $admins->firstWhere('approval_order', 4);
                                    $chair = $admins->firstWhere('approval_order', 1);
                                    $fin = $admins->firstWhere('approval_order', 2);
                                    $aud = $admins->firstWhere('approval_order', 3);
                                    $treas = $admins->firstWhere('approval_order', 5);

                                    $steps = [
                                        1 => ['title' => 'Manager Review', 'user' => $manager, 'done' => $loan->stage > 1],
                                        2 => ['title' => 'Chairman Review', 'user' => $chair, 'done' => $loan->stage > 2],
                                        3 => ['title' => 'Financial Secretary', 'user' => $fin, 'done' => $loan->stage > 3],
                                        4 => ['title' => 'Auditor Check', 'user' => $aud, 'done' => $loan->stage > 4],
                                        5 => ['title' => 'Chairman Final', 'user' => $chair, 'done' => $loan->stage > 5 || $loan->status == 'approved' || $loan->status == 'disbursed'],
                                        6 => ['title' => 'Treasurer Disburse', 'user' => $treas, 'done' => $loan->status == 'disbursed'],
                                    ];
                                @endphp

                                @foreach($steps as $stage => $step)
                                    @php
                                        $isActive = $loan->stage == $stage && $loan->status != 'rejected' && $loan->status != 'disbursed';
                                        if ($stage == 6 && $loan->status == 'approved') $isActive = true; // Treasurer active when approved

                                        // Check if user has acted at this stage?
                                        // For simplicity, just use stage progression to show 'done'
                                        // But if rejected, show where it stopped.
                                        $isRejectedHere = $loan->status == 'rejected' && $loan->stage == $stage;
                                    @endphp
                                    <div class="flex items-center justify-between p-4 rounded-2xl border {{ $step['done'] ? 'bg-emerald-900/20 border-emerald-500/30' : ($isActive ? 'bg-gold/10 border-gold/50 shadow-[0_0_15px_rgba(251,191,36,0.1)]' : ($isRejectedHere ? 'bg-rose-900/20 border-rose-500/30' : 'bg-[#0B1A14] border-emerald-900/30 opacity-60')) }} transition-all">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] {{ $step['done'] ? 'bg-emerald-600 text-white' : ($isActive ? 'bg-gold text-army-green' : ($isRejectedHere ? 'bg-rose-600 text-white' : 'bg-[#0E211A] text-emerald-600/50 border border-emerald-900/50')) }}">
                                                <span class="font-mono">{{ $stage }}</span>
                                            </div>
                                            <div>
                                                <div class="text-[11px] font-black uppercase tracking-wider {{ $isActive ? 'text-gold' : ($step['done'] ? 'text-emerald-400' : ($isRejectedHere ? 'text-rose-400' : 'text-emerald-600/50')) }}">{{ $step['title'] }}</div>
                                                <div class="text-[9px] text-emerald-600/50 font-medium uppercase tracking-widest mt-0.5">{{ $step['user']->name ?? 'Admin' }}</div>
                                            </div>
                                        </div>
                                        @if($step['done'])
                                            <div class="w-6 h-6 rounded-full bg-emerald-900/50 flex items-center justify-center"><i class="fas fa-check text-[10px] text-emerald-400"></i></div>
                                        @elseif($isRejectedHere)
                                             <div class="w-6 h-6 rounded-full bg-rose-900/50 flex items-center justify-center"><i class="fas fa-times text-[10px] text-rose-400"></i></div>
                                        @elseif($isActive)
                                            <div class="w-6 h-6 rounded-full bg-gold/20 flex items-center justify-center animate-pulse"><i class="fas fa-arrow-right text-[10px] text-gold"></i></div>
                                        @else
                                            <div class="w-6 h-6 flex items-center justify-center"><i class="fas fa-clock text-[10px] text-emerald-600/30"></i></div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- List Approvals - Detailed -->
                            @if($loan->committeeApprovals->count() > 0)
                                <div class="space-y-4 mb-6 border-t border-emerald-900/30 pt-6">
                                    <h4 class="text-[10px] font-black text-emerald-600/50 uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fas fa-history"></i> Review History</h4>
                                    @foreach($loan->committeeApprovals as $approval)
                                        <div class="text-sm p-4 bg-[#0B1A14] border border-emerald-900/50 rounded-xl relative overflow-hidden group">
                                            <div class="absolute left-0 top-0 w-1 h-full {{ $approval->status == 'approved' ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                            <div class="flex justify-between items-center mb-2 pl-2">
                                                <span class="font-bold text-white text-xs">{{ $approval->user->name }}</span>
                                                <span class="text-[8px] font-black tracking-widest uppercase border px-2 py-0.5 rounded {{ $approval->status == 'approved' ? 'border-emerald-500/30 text-emerald-400 bg-emerald-900/20' : 'border-rose-500/30 text-rose-400 bg-rose-900/20' }}">
                                                    {{ $approval->status }}
                                                </span>
                                            </div>
                                            @if($approval->comment)
                                                <p class="text-[11px] text-emerald-100/70 italic mb-3 pl-2 leading-relaxed">"{{ $approval->comment }}"</p>
                                            @endif
                                            @if($approval->signature_path)
                                                <div class="bg-white/10 p-2 rounded-lg mb-2 inline-block ml-2">
                                                    <img src="{{ Storage::url($approval->signature_path) }}" class="h-8 object-contain filter invert border-none">
                                                </div>
                                            @endif
                                            <div class="text-[8px] text-emerald-600/50 text-right mt-2 font-black tracking-widest">
                                                <i class="far fa-clock mr-1"></i> {{ $approval->reviewed_at->format('M d, Y H:i') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Action Form -->
                            @php
                                $user = Auth::user();
                                $myOrder = $user->approval_order;
                                $stage = $loan->stage;

                                // Helper: is there an admin assigned to this approval_order?
                                $stageToOrder = [1=>1, 2=>2, 3=>3, 4=>1, 5=>5];
                                $requiredOrder = $stageToOrder[$stage] ?? null;
                                $stageAdminExists = $requiredOrder
                                    ? App\Models\User::where('role','admin')->where('approval_order',$requiredOrder)->exists()
                                    : false;

                                $isExactMatch = (
                                    ($myOrder == 1 && ($stage == 1 || $stage == 4)) ||
                                    ($myOrder == 2 && $stage == 2) ||
                                    ($myOrder == 3 && $stage == 3) ||
                                    ($myOrder == 5 && $stage == 5)
                                );

                                // Substitute: can approve if exact match, OR stage has no assigned admin and user can manage loans
                                $itIsMyTurn = false;
                                if ($loan->status == 'pending' || ($loan->status == 'approved' && $stage == 5)) {
                                    if ($isExactMatch) {
                                        $itIsMyTurn = true;
                                    } elseif (!$stageAdminExists && $user->canManageLoans()) {
                                        $itIsMyTurn = true;
                                    }
                                }
                            @endphp

                            @if($itIsMyTurn)
                                <div class="mt-8 pt-8 border-t border-emerald-900/50">
                                    <h4 class="font-black text-sm text-white uppercase tracking-widest mb-5 flex items-center justify-center gap-2"><i class="fas fa-pen-nib text-gold"></i> Submit Your Review</h4>
                                    
                                    <!-- Toggle Buttons for Approve/Reject to show relevant fields -->
                                    <div x-data="{ action: 'approve' }">
                                        <div class="flex gap-3 mb-6 p-1 bg-[#0B1A14] rounded-xl border border-emerald-900/50">
                                            <button @click="action = 'approve'" :class="action === 'approve' ? 'bg-emerald-600 text-white shadow-[0_0_10px_rgba(16,185,129,0.3)]' : 'text-emerald-600/70 hover:text-emerald-400'" class="flex-1 py-3 border border-transparent rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">
                                                @php
                                                    $btnText = 'Approve';
                                                    if($stage == 1) $btnText = 'To Chairman';
                                                    elseif($stage == 2) $btnText = 'To Finance';
                                                    elseif($stage == 3) $btnText = 'To Auditor';
                                                    elseif($stage == 4) $btnText = 'To Chairman';
                                                    elseif($stage == 5) $btnText = 'Finalize';
                                                @endphp
                                                {{ $btnText }}
                                            </button>
                                            <button @click="action = 'reject'" :class="action === 'reject' ? 'bg-rose-600 text-white shadow-[0_0_10px_rgba(225,29,72,0.3)] border-transparent' : 'text-emerald-600/70 hover:text-rose-400 border border-transparent'" class="flex-1 py-3 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">
                                                Reject
                                            </button>
                                        </div>

                                        <!-- Approval Form -->
                                        <form x-show="action === 'approve'" action="{{ route('admin.loans.approve', $loan) }}" method="POST" enctype="multipart/form-data" class="space-y-5 bg-[#0B1A14] p-5 rounded-2xl border border-emerald-500/30 shadow-[inset_0_2px_15px_rgba(16,185,129,0.05)]">
                                            @csrf
                                            <div>
                                                <label class="block text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2">
                                                    <i class="fas fa-comment-dots mr-1"></i> Review Comment
                                                </label>
                                                <textarea name="comment" rows="3" class="w-full text-sm rounded-xl bg-[#0E211A] border-emerald-900/50 focus:border-emerald-500/50 focus:ring-2 focus:ring-emerald-500/20 text-emerald-100 placeholder-emerald-900/50 transition-all font-medium" placeholder="Notes, recommendations, or conditions..."></textarea>
                                                <p class="text-[9px] text-emerald-600/50 mt-2 font-medium tracking-wide">Visible to other committee members in the history.</p>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2">
                                                    <i class="fas fa-signature mr-1"></i> Signature (Optional)
                                                </label>
                                                <div class="relative">
                                                    <input type="file" name="signature_image" accept="image/*" class="w-full text-[10px] text-emerald-600/70 border border-emerald-900/50 rounded-xl bg-[#0E211A]
                                                    file:mr-4 file:py-3 file:px-4 file:rounded-l-xl file:border-0 file:border-r file:border-emerald-900/50 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-emerald-900/30 file:text-emerald-400 hover:file:bg-emerald-900/50 file:transition-all file:cursor-pointer cursor-pointer focus:outline-none">
                                                </div>
                                            </div>
                                            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white py-4 rounded-xl font-black uppercase text-[10px] tracking-widest transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:-translate-y-0.5 active:scale-95 flex justify-center items-center gap-2">
                                                <i class="fas fa-check-double text-base"></i> Confirm Approval
                                            </button>
                                        </form>

                                        <!-- Rejection Form -->
                                        <form x-show="action === 'reject'" action="{{ route('admin.loans.reject', $loan) }}" method="POST" class="space-y-5 bg-[#0B1A14] p-5 rounded-2xl border border-rose-500/30 shadow-[inset_0_2px_15px_rgba(225,29,72,0.05)]">
                                            @csrf
                                            <div>
                                                <label class="block text-[10px] font-black text-rose-500 uppercase tracking-widest mb-2">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i> Rejection Reason *
                                                </label>
                                                <textarea name="comment" rows="4" class="w-full text-sm rounded-xl bg-rose-950/20 border-rose-900/50 focus:border-rose-500/50 focus:ring-2 focus:ring-rose-500/20 text-rose-100 placeholder-rose-900/50 transition-all font-medium" required placeholder="Clearly state the reasons for rejecting this loan application."></textarea>
                                            </div>
                                            <button type="submit" class="w-full bg-gradient-to-r from-rose-600 to-rose-800 hover:from-rose-500 hover:to-rose-700 text-white py-4 rounded-xl font-black uppercase text-[10px] tracking-widest transition-all shadow-[0_0_15px_rgba(225,29,72,0.3)] hover:shadow-[0_0_20px_rgba(225,29,72,0.4)] hover:-translate-y-0.5 active:scale-95 flex justify-center items-center gap-2">
                                                <i class="fas fa-times-circle text-base"></i> Confirm Rejection
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @elseif($myApproval)
                                 <div class="mt-8 p-6 bg-[#0B1A14] rounded-2xl text-center border border-emerald-900/50 relative overflow-hidden">
                                     <div class="absolute inset-0 bg-emerald-500/5 filter blur-3xl rounded-full"></div>
                                     <div class="relative z-10">
                                         <div class="text-[10px] font-black text-emerald-600/50 uppercase tracking-widest mb-2">Your Decision Recorded</div>
                                         <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-lg border {{ $myApproval->status == 'approved' ? 'bg-emerald-900/30 border-emerald-500/30 text-emerald-400' : 'bg-rose-900/30 border-rose-500/30 text-rose-400' }}">
                                             <i class="fas {{ $myApproval->status == 'approved' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                             <span class="font-black text-xs uppercase tracking-widest">{{ $myApproval->status }}</span>
                                         </div>
                                         @if($myApproval->comment)
                                            <p class="text-xs text-emerald-100/70 mt-3 font-medium italic bg-[#0E211A] p-3 rounded-lg text-left border border-emerald-900/30">"{{ $myApproval->comment }}"</p>
                                         @endif
                                     </div>
                                 </div>
                            @elseif($loan->status != 'pending')
                                 <div class="mt-8 p-5 bg-[#0B1A14] rounded-2xl text-center border border-emerald-900/50 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                                     <p class="text-[10px] font-black tracking-widest uppercase text-emerald-600/70 flex items-center justify-center gap-2">
                                         <i class="fas fa-info-circle text-emerald-500/50"></i>
                                         This loan is already <span class="{{ $loan->status == 'disbursed' ? 'text-blue-400' : ($loan->status == 'approved' ? 'text-emerald-400' : 'text-rose-400') }}">{{ $loan->status }}</span>.
                                     </p>
                                 </div>
                            @else
                                 <div class="mt-8 p-5 bg-[#0B1A14] rounded-2xl text-center border border-dashed border-emerald-900/50 shadow-[inset_0_2px_10px_rgba(0,0,0,0.3)]">
                                     <div class="text-xl text-emerald-600/30 mb-2"><i class="fas fa-hourglass-half animate-pulse"></i></div>
                                     <p class="text-[10px] font-black tracking-widest uppercase text-emerald-600/50">Waiting for preceding admin approvals...</p>
                                 </div>
                            @endif
                        </div>
                    </div>

                    <!-- Disbursement Terminal (Treasurer Only: Admin 5) -->
                    @php
                        $isTreasurerOrSubstitute = auth()->user()->approval_order == 5
                            || (!App\Models\User::where('role','admin')->where('approval_order',5)->exists() && auth()->user()->canManageLoans());
                    @endphp
                    @if($loan->status == 'approved' && $isTreasurerOrSubstitute)
                        <div class="bg-gradient-to-b from-[#0B1A14] to-emerald-950 p-8 rounded-3xl shadow-[0_0_30px_rgba(251,191,36,0.1)] mt-8 border-2 border-gold/30 relative overflow-hidden group">
                            <!-- Golden shine effect -->
                            <div class="absolute top-0 -left-[100%] w-1/2 h-full bg-gradient-to-r from-transparent via-white/5 to-transparent transform -skew-x-12 group-hover:left-[200%] transition-all duration-1000 ease-in-out"></div>
                            
                            <div class="flex items-center gap-4 text-white mb-6 relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-gold/20 flex items-center justify-center border border-gold/40 text-gold shadow-[0_0_15px_rgba(251,191,36,0.3)]">
                                    <i class="fas fa-hand-holding-usd text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black uppercase tracking-widest text-gold text-shadow">Disbursement Terminal</h3>
                                    <p class="text-[10px] text-gold/70 font-bold uppercase tracking-widest mt-0.5">Final authorization required</p>
                                </div>
                            </div>
                            
                            <div class="bg-black/20 rounded-xl p-4 mb-6 border border-gold/10 relative z-10">
                                <p class="text-xs text-emerald-100/90 leading-relaxed font-medium">This loan has been approved by the committee. Proceeding will trigger the financial outflow and mark the loan as active with repayments scheduled.</p>
                            </div>
                            
                            <form action="{{ route('admin.loans.disburse', $loan) }}" method="POST" class="relative z-10">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-gold to-yellow-600 hover:from-yellow-400 hover:to-gold text-[#0B1A14] font-black py-4 rounded-xl transition-all shadow-[0_0_20px_rgba(251,191,36,0.4)] hover:shadow-[0_0_25px_rgba(251,191,36,0.6)] active:scale-95 uppercase tracking-widest text-xs flex items-center justify-center gap-3">
                                    <i class="fas fa-lock-open text-base"></i>
                                    Confirm & Disburse Funds
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <!-- Edit Items Modal -->
    <div id="editItemsModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-[#0B1A14] opacity-80 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="document.getElementById('editItemsModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-[#0E211A] border border-emerald-900/50 rounded-3xl text-left overflow-hidden shadow-[0_0_30px_rgba(16,185,129,0.1)] transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900 opacity-50"></div>
                
                <form action="{{ route('admin.loans.update_items', $loan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-8">
                        <div>
                            <div class="text-center sm:text-left w-full">
                                <h3 class="text-xl font-bold text-white tracking-tight flex items-center gap-3 border-b border-emerald-900/30 pb-4" id="modal-title">
                                    <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-400"><i class="fas fa-edit"></i></div>
                                    Edit Loan Items
                                </h3>
                                
                                <div class="mt-6 overflow-x-auto bg-[#0B1A14] rounded-2xl border border-emerald-900/50 shadow-[inset_0_2px_10px_rgba(0,0,0,0.2)]">
                                    <table class="w-full text-sm" id="itemsTable">
                                        <thead class="bg-[#0E211A]/80 text-[10px] uppercase font-black tracking-widest text-emerald-600/70 border-b border-emerald-900/50">
                                            <tr>
                                                <th class="px-5 py-4 text-left">Item Name</th>
                                                <th class="px-5 py-4 w-24 text-center">Qty</th>
                                                <th class="px-5 py-4 w-32 text-right">Unit Price</th>
                                                <th class="px-5 py-4 w-32 text-right">Total</th>
                                                <th class="px-5 py-4 w-12 text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="itemsTableBody" class="divide-y divide-emerald-900/30">
                                            @if(isset($loan->metadata['items']))
                                                @foreach($loan->metadata['items'] as $index => $item)
                                                <tr class="item-row hover:bg-emerald-900/10 transition-colors">
                                                    <td class="px-3 py-3">
                                                        <input type="text" name="items[{{$index}}][name]" value="{{ $item['name'] }}" class="w-full text-sm bg-[#0E211A] border-emerald-900/50 rounded-xl focus:ring-gold focus:border-gold text-emerald-100 font-bold transition-colors">
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        <input type="number" name="items[{{$index}}][quantity]" value="{{ $item['quantity'] }}" min="1" class="qty-input w-full text-sm bg-[#0E211A] border-emerald-900/50 rounded-xl focus:ring-gold focus:border-gold text-center text-emerald-100 font-bold transition-colors" oninput="calculateRowTotal(this)">
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        <input type="text" name="items[{{$index}}][price]" value="{{ number_format($item['price'] ?? 0, 2, '.', ',') }}" 
                                                            inputmode="numeric"
                                                            oninput="
                                                                let val = this.value.replace(/[^0-9.]/g, '');
                                                                if (val.split('.').length > 2) val = val.replace(/\.+$/, '');
                                                                let parts = val.split('.');
                                                                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                                                                this.value = parts.join('.');
                                                                calculateRowTotal(this);
                                                            "
                                                            onblur="
                                                                let val = this.value.replace(/,/g, '');
                                                                if (val && !isNaN(val)) {
                                                                    this.value = parseFloat(val).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                                                }
                                                                calculateRowTotal(this);
                                                            "
                                                            class="price-input w-full text-sm bg-[#0E211A] border-emerald-900/50 rounded-xl focus:ring-gold focus:border-gold text-right text-emerald-100 font-bold transition-colors">
                                                    </td>
                                                    <td class="px-5 py-3 text-right font-black text-emerald-300 total-display text-base">
                                                        {{ number_format(($item['quantity'] * ($item['price'] ?? 0)), 2) }}
                                                    </td>
                                                    <td class="px-3 py-3 text-center">
                                                        <button type="button" onclick="removeRow(this)" class="w-8 h-8 rounded-lg bg-rose-900/20 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors flex items-center justify-center">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot class="bg-[#0E211A] border-t border-emerald-900/50">
                                            <tr>
                                                <td colspan="5" class="py-4 px-5 bg-[#0B1A14]">
                                                    <button type="button" onclick="addNewRow()" class="px-4 py-2 bg-emerald-900/30 border border-emerald-500/30 rounded-xl text-[10px] font-black uppercase tracking-widest text-emerald-400 hover:bg-emerald-500 hover:text-white transition-all w-full flex justify-center items-center gap-2">
                                                        <i class="fas fa-plus-circle"></i> Add New Item
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="px-5 py-5 text-right font-black uppercase text-[10px] tracking-widest text-emerald-600/70">Grand Total</td>
                                                <td class="px-5 py-5 text-right font-black text-2xl text-emerald-400 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]" id="grandTotalDisplay">
                                                    ₦{{ number_format($loan->amount, 2) }}
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-[#0B1A14] px-8 py-6 border-t border-emerald-900/50 sm:flex sm:flex-row-reverse gap-3 rounded-b-3xl">
                        <button type="submit" class="w-full inline-flex justify-center items-center rounded-xl px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black uppercase text-[10px] tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] focus:outline-none focus:ring-2 focus:ring-emerald-500/50 hover:-translate-y-0.5 transition-all sm:w-auto">
                            <i class="fas fa-save mr-2 text-base"></i> Save Changes
                        </button>
                        <button type="button" onclick="document.getElementById('editItemsModal').classList.add('hidden')" class="mt-3 sm:mt-0 w-full inline-flex justify-center items-center rounded-xl px-6 py-3.5 bg-[#0E211A] border border-emerald-900/50 text-emerald-600/70 font-black uppercase text-[10px] tracking-widest hover:text-emerald-400 hover:bg-emerald-900/30 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 transition-all sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function calculateRowTotal(input) {
            const row = input.closest('tr');
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value.replace(/,/g, '')) || 0;
            const total = qty * price;
            // Removed minimumFractionDigits so it matches the format style without `.00` everywhere unless it's a decimal natively, 
            // but standardizing to 2 decimal places is fine since the original script did it.
            row.querySelector('.total-display').innerText = total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                grandTotal += qty * price;
            });
            document.getElementById('grandTotalDisplay').innerText = '₦' + grandTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
            calculateGrandTotal();
        }

        function addNewRow() {
            const tbody = document.getElementById('itemsTableBody');
            const index = tbody.children.length; 
            const tr = document.createElement('tr');
            tr.className = 'item-row hover:bg-emerald-900/10 transition-colors';
            tr.innerHTML = `
                <td class="px-3 py-3">
                    <input type="text" name="items[${Date.now()}][name]" placeholder="New Item" class="w-full text-sm bg-[#0E211A] border-emerald-900/50 rounded-xl focus:ring-gold focus:border-gold text-emerald-100 font-bold transition-colors">
                </td>
                <td class="px-3 py-3">
                    <input type="number" name="items[${Date.now()}][quantity]" value="1" min="1" class="qty-input w-full text-sm bg-[#0E211A] border-emerald-900/50 rounded-xl focus:ring-gold focus:border-gold text-center text-emerald-100 font-bold transition-colors" oninput="calculateRowTotal(this)">
                </td>
                <td class="px-3 py-3">
                    <input type="text" name="items[${id}][price]" value="0.00" 
                        inputmode="numeric"
                        oninput="
                            let val = this.value.replace(/[^0-9.]/g, '');
                            if (val.split('.').length > 2) val = val.replace(/\.+$/, '');
                            let parts = val.split('.');
                            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            this.value = parts.join('.');
                            calculateRowTotal(this);
                        "
                        onblur="
                            let val = this.value.replace(/,/g, '');
                            if (val && !isNaN(val)) {
                                this.value = parseFloat(val).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                            calculateRowTotal(this);
                        "
                        class="price-input w-full text-sm bg-[#0E211A] border-emerald-900/50 rounded-xl focus:ring-gold focus:border-gold text-right text-emerald-100 font-bold transition-colors">
                </td>
                <td class="px-5 py-3 text-right font-black text-emerald-300 total-display text-base">0.00</td>
                <td class="px-3 py-3 text-center">
                    <button type="button" onclick="removeRow(this)" class="w-8 h-8 rounded-lg bg-rose-900/20 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors flex items-center justify-center">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        }
        document.querySelector('#editItemsModal form').addEventListener('submit', function() {
            this.querySelectorAll('.price-input').forEach(input => {
                input.value = input.value.replace(/,/g, '');
            });
        });
    </script>
</x-app-layout>
