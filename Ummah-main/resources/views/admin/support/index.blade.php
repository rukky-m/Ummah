<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">
            {{ __('Support Infrastructure') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 dark:bg-gray-900/30">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-hidden bg-white/60 dark:bg-gray-900/40 backdrop-blur-2xl shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-3xl">
                <div class="p-7">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                        <div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
                                <span class="w-2 h-6 bg-emerald-500 rounded-full"></span>
                                Communications Hub
                            </h3>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">Strategic oversight of member inquiries and resolution status.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-3">
                            <thead>
                                <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                                    <th class="px-6 pb-2">Ticket ID</th>
                                    <th class="px-6 pb-2">Member Entity</th>
                                    <th class="px-6 pb-2">Subject Matter</th>
                                    <th class="px-6 pb-2 text-center">Priority</th>
                                    <th class="px-6 pb-2 text-center">Protocol Status</th>
                                    <th class="px-6 pb-2 text-right">Synchronization</th>
                                    <th class="px-6 pb-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tickets as $ticket)
                                    <tr class="bg-white/40 dark:bg-gray-800/40 hover:bg-white/60 dark:hover:bg-gray-800/60 backdrop-blur-md transition-all duration-300 group shadow-sm hover:shadow-md">
                                        <td class="px-6 py-5 rounded-l-2xl border-y border-l border-gray-900/5 dark:border-white/5">
                                            <span class="text-[10px] font-black tracking-widest text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded-md uppercase">#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td class="px-6 py-5 border-y border-gray-900/5 dark:border-white/5">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-gray-900 dark:bg-white text-white dark:text-gray-900 flex items-center justify-center text-xs font-black shadow-lg">
                                                    {{ substr($ticket->user->name, 0, 1) }}
                                                </div>
                                                <div class="text-xs">
                                                    <p class="font-black text-gray-900 dark:text-white">{{ $ticket->user->name }}</p>
                                                    <p class="text-[9px] text-gray-400 uppercase tracking-widest font-bold mt-0.5">{{ $ticket->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 border-y border-gray-900/5 dark:border-white/5">
                                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 group-hover:text-emerald-500 transition-colors">{{ $ticket->subject }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-center border-y border-gray-900/5 dark:border-white/5">
                                            <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest border border-current opacity-80
                                                @if($ticket->priority === 'high') text-rose-500 @elseif($ticket->priority === 'medium') text-amber-500 @else text-blue-500 @endif">
                                                {{ $ticket->priority }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-center border-y border-gray-900/5 dark:border-white/5">
                                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest
                                                @if($ticket->status === 'open') bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 @elseif($ticket->status === 'in_progress') bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 @else bg-gray-100 text-gray-500 dark:bg-white/5 @endif">
                                                {{ str_replace('_', ' ', $ticket->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-right border-y border-gray-900/5 dark:border-white/5">
                                            <span class="text-[9px] font-black uppercase tracking-widest text-gray-400 group-hover:text-gray-500 transition-colors">
                                                {{ $ticket->updated_at->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 rounded-r-2xl border-y border-r border-gray-900/5 dark:border-white/5 text-right">
                                            <a href="{{ route('admin.support.show', $ticket) }}" 
                                               class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-[10px] font-black uppercase tracking-widest hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                                Review
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-24 text-center bg-white/20 dark:bg-white/5 backdrop-blur-sm rounded-3xl border border-dashed border-gray-900/10 dark:border-white/10">
                                            <div class="w-20 h-20 bg-gray-50 dark:bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-6 ring-1 ring-gray-900/5 dark:ring-white/10">
                                                <i class="fas fa-inbox text-3xl text-gray-300 dark:text-gray-600"></i>
                                            </div>
                                            <h4 class="text-xl font-black text-gray-900 dark:text-white tracking-tight">Queue Depleted</h4>
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-2 lowercase">All support channels are currently synchronized.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
