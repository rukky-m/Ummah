<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-white tracking-tight flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-500/70 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]"><i class="fas fa-bullhorn text-lg"></i></div>
            {{ __('Manage Announcements') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-7">
                <!-- Total Broadcasts -->
                <div class="relative overflow-hidden bg-[#0E211A] border border-emerald-900/50 shadow-[0_0_20px_rgba(16,185,129,0.05)] sm:rounded-3xl p-7 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(59,130,246,0.1)] group">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600/70 mb-2 drop-shadow-sm">Total Broadcasts</div>
                            <div class="text-4xl font-black text-white tracking-tighter">{{ $totalAnnouncements }}</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-[#0B1A14] border-2 border-emerald-900/50 flex items-center justify-center shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)] group-hover:scale-110 group-hover:bg-blue-900/20 group-hover:border-blue-500/30 transition-all duration-500">
                            <i class="fas fa-layer-group text-emerald-500/50 group-hover:text-blue-500 transition-colors"></i>
                        </div>
                    </div>
                </div>

                <!-- Currently Active -->
                <div class="relative overflow-hidden bg-[#0E211A] border border-emerald-900/50 shadow-[0_0_20px_rgba(16,185,129,0.05)] sm:rounded-3xl p-7 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(16,185,129,0.1)] group">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600/70 mb-2 drop-shadow-sm">Currently Active</div>
                            <div class="text-4xl font-black text-white tracking-tighter">{{ $activeAnnouncements }}</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-[#0B1A14] border-2 border-emerald-900/50 flex items-center justify-center shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)] group-hover:scale-110 group-hover:bg-emerald-900/30 group-hover:border-emerald-500/50 transition-all duration-500">
                            <i class="fas fa-broadcast-tower text-emerald-500/50 group-hover:text-emerald-400 transition-colors"></i>
                        </div>
                    </div>
                </div>

                <!-- Visibility -->
                <div class="relative overflow-hidden bg-[#0B1A14] border border-emerald-500/30 shadow-[0_0_20px_rgba(16,185,129,0.15)] sm:rounded-3xl p-7 transition-all duration-500 hover:-translate-y-1 group">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/20 via-transparent to-transparent opacity-100 pointer-events-none"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-400 mb-2 drop-shadow-[0_0_5px_rgba(52,211,153,0.3)]">Visibility</div>
                            <div class="text-2xl font-black text-white tracking-tighter mt-2">All Members</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-[#0E211A] border-2 border-emerald-400 flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.4)] group-hover:scale-110 transition-all duration-500">
                            <i class="fas fa-eye text-emerald-400 drop-shadow-[0_0_5px_rgba(52,211,153,0.5)]"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Create Announcement Form -->
            <div class="relative overflow-hidden bg-[#0E211A] border border-emerald-900/50 shadow-[0_0_20px_rgba(16,185,129,0.05)] sm:rounded-3xl p-8">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900 opacity-50"></div>
                
                <h3 class="font-black text-xl text-white mb-8 flex items-center gap-3 tracking-tight">
                    <i class="fas fa-bullhorn text-emerald-500"></i> Broadcast New Announcement
                </h3>

                <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6 relative z-10">
                    @csrf
                    <div>
                        <x-input-label for="title" :value="__('Title / Headline')" class="mb-2 text-[10px] font-black uppercase tracking-widest text-emerald-600/70" />
                        <x-text-input id="title" name="title" type="text" class="block w-full rounded-2xl border-emerald-900/50 bg-[#0B1A14] focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)] text-white font-bold p-4" placeholder="e.g. General Meeting Notice" required />
                        <x-input-error class="mt-2 text-rose-400" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="message" :value="__('Message Body')" class="mb-2 text-[10px] font-black uppercase tracking-widest text-emerald-600/70" />
                        <textarea id="message" name="message" class="block w-full rounded-2xl border-emerald-900/50 bg-[#0B1A14] focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)] text-white font-bold p-4 resize-none" rows="4" placeholder="Write your announcement here..." required></textarea>
                        <x-input-error class="mt-2 text-rose-400" :messages="$errors->get('message')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="type" :value="__('Type')" class="mb-2 text-[10px] font-black uppercase tracking-widest text-emerald-600/70" />
                            <select id="type" name="type" class="block w-full rounded-2xl border-emerald-900/50 bg-[#0B1A14] focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)] text-white font-bold p-4">
                                <option class="bg-[#0B1A14] text-white" value="info">General Info (Blue)</option>
                                <option class="bg-[#0B1A14] text-white" value="warning">Important Warning (Red)</option>
                                <option class="bg-[#0B1A14] text-white" value="meeting">Meeting (Gold)</option>
                                <option class="bg-[#0B1A14] text-white" value="program">Program / Event (Green)</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="expires_at" :value="__('Expires At')" class="mb-2 text-[10px] font-black uppercase tracking-widest text-emerald-600/70" />
                            <x-text-input id="expires_at" name="expires_at" type="datetime-local" class="block w-full rounded-2xl border-emerald-900/50 bg-[#0B1A14] focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)] text-white font-bold p-4" style="color-scheme: dark;" />
                            <p class="text-[10px] font-bold text-emerald-600/50 mt-2 uppercase tracking-widest flex items-center gap-1.5"><i class="fas fa-info-circle text-emerald-900/80"></i> Optional: Leave blank to keep active indefinitely</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end pt-6 border-t border-emerald-900/50 gap-3">
                        <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.3)] transition-all duration-300 flex items-center justify-center gap-2 active:scale-95">
                            <i class="fas fa-paper-plane"></i> Broadcast Now
                        </button>
                    </div>
                </form>
            </div>

            <!-- Active Announcements List -->
            <div class="relative overflow-hidden bg-[#0E211A] border border-emerald-900/50 shadow-[0_0_20px_rgba(16,185,129,0.05)] sm:rounded-3xl">
                <div class="px-8 py-6 border-b border-emerald-900/50 bg-[#0B1A14]">
                    <h3 class="text-lg font-black text-white tracking-tight flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse drop-shadow-[0_0_5px_rgba(16,185,129,0.8)]"></span>
                        Active & Recent Announcements
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-emerald-900/30">
                        <thead class="bg-[#0B1A14]/50">
                            <tr>
                                <th class="px-8 py-5 text-left text-[10px] font-black tracking-widest text-emerald-600/70 uppercase w-1/2">Broadcast Subject</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black tracking-widest text-emerald-600/70 uppercase">Category</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black tracking-widest text-emerald-600/70 uppercase">Status Radar</th>
                                <th class="px-8 py-5 text-right text-[10px] font-black tracking-widest text-emerald-600/70 uppercase">Override Auth</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-900/30 bg-transparent">
                            @forelse($announcements as $announcement)
                                <tr class="hover:bg-[#0B1A14]/80 transition-colors group">
                                    <td class="px-8 py-6">
                                        <p class="font-bold text-white text-base tracking-tight mb-2 group-hover:text-emerald-300 transition-colors">{{ $announcement->title }}</p>
                                        <p class="text-xs font-semibold text-emerald-100/60 truncate max-w-md">{{ $announcement->message }}</p>
                                    </td>
                                    <td class="px-8 py-6">
                                        @php
                                            $colors = [
                                                'info' => 'bg-blue-900/20 text-blue-400 border-blue-500/30',
                                                'warning' => 'bg-rose-900/20 text-rose-400 border-rose-500/30',
                                                'meeting' => 'bg-amber-900/20 text-amber-400 border-amber-500/30',
                                                'program' => 'bg-emerald-900/20 text-emerald-400 border-emerald-500/30',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-lg text-[9px] font-black border uppercase tracking-widest {{ $colors[$announcement->type] ?? 'bg-gray-900/20 text-gray-400 border-gray-500/30' }}">
                                            {{ ucfirst($announcement->type) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border text-[9px] font-black uppercase tracking-widest {{ $announcement->is_active ? 'bg-emerald-900/30 text-emerald-400 border-emerald-500/30 shadow-[inset_0_0_10px_rgba(16,185,129,0.1)]' : 'bg-[#0B1A14] text-emerald-700/50 border-emerald-900/50' }}">
                                            <i class="fas {{ $announcement->is_active ? 'fa-satellite-dish animate-pulse' : 'fa-power-off' }} text-[10px]"></i>
                                            {{ $announcement->is_active ? 'Live Broadcast' : 'Offline' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <form action="{{ route('admin.announcements.toggle', $announcement) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center border border-transparent hover:bg-[#0B1A14] hover:border-emerald-900/50 {{ $announcement->is_active ? 'text-amber-600/70 hover:text-amber-400' : 'text-emerald-600/70 hover:text-emerald-400' }} transition-colors shadow-sm" title="{{ $announcement->is_active ? 'Disable Broadcast' : 'Activate Broadcast' }}">
                                                    <i class="fas {{ $announcement->is_active ? 'fa-microphone-slash' : 'fa-microphone' }} text-sm"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Purge this announcement permanently?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center border border-transparent hover:bg-rose-900/20 hover:border-rose-500/30 text-rose-600/70 hover:text-rose-400 transition-colors shadow-sm" title="Purge Record">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-center">
                                        <div class="w-20 h-20 mx-auto bg-[#0B1A14] border-2 border-emerald-900/50 text-emerald-900/50 rounded-2xl flex items-center justify-center text-4xl mb-6 shadow-inner">
                                            <i class="fas fa-microphone-slash"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-white tracking-tight">Airwaves Clear</h3>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50 mt-2">No active broadcasts found in the communication logs.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($announcements->hasPages())
                    <div class="px-8 py-5 border-t border-emerald-900/50 bg-[#0B1A14]">
                        {{ $announcements->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
