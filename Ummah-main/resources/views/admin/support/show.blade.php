<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.support.index') }}" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 hover:text-army-green transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-black text-lg text-gray-800 dark:text-gray-200 uppercase tracking-widest leading-none mb-1">
                        {{ $ticket->subject }}
                    </h2>
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-black uppercase tracking-widest opacity-40">From: {{ $ticket->user->name }}</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="text-[9px] font-black uppercase tracking-widest opacity-40">Ticket ID: #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <form action="{{ route('admin.support.updateStatus', $ticket) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="text-[10px] font-black uppercase tracking-widest bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-army-green focus:border-army-green py-1">
                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 dark:border-gray-700 flex flex-col h-[600px]">
                
                {{-- Chat History --}}
                <div class="flex-1 overflow-y-auto p-6 space-y-6" id="chat-container">
                    @foreach($messages as $message)
                        <div class="flex {{ $message->is_admin ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[70%]">
                                <div class="flex items-center gap-2 mb-1 {{ $message->is_admin ? 'flex-row-reverse' : 'flex-row' }}">
                                    <span class="text-[9px] font-black uppercase tracking-widest opacity-40">
                                        {{ $message->is_admin ? 'Support Team (Me)' : $ticket->user->name }}
                                    </span>
                                    <span class="text-[9px] font-black uppercase tracking-widest opacity-20">
                                        {{ $message->created_at->format('H:i') }}
                                    </span>
                                </div>
                                <div class="px-4 py-3 rounded-2xl text-sm shadow-sm 
                                    {{ $message->is_admin 
                                        ? 'bg-army-green text-white rounded-tr-none' 
                                        : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-tl-none' }}">
                                    {!! nl2br(e($message->message)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Reply Form --}}
                <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    <form method="POST" action="{{ route('admin.support.message', $ticket) }}" class="flex gap-3">
                        @csrf
                        <div class="flex-1">
                            <textarea name="message" rows="1" 
                                class="block w-full border-gray-200 dark:border-gray-600 focus:border-army-green focus:ring-army-green rounded-xl shadow-sm text-sm font-medium resize-none py-3" 
                                placeholder="Type your response here..." required></textarea>
                        </div>
                        <button type="submit" class="w-12 h-12 rounded-xl bg-army-green text-white flex items-center justify-center shadow-lg shadow-army-green/20 hover:scale-105 active:scale-95 transition-all">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Scroll to bottom of chat
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('chat-container');
            container.scrollTop = container.scrollHeight;
        });
    </script>
</x-app-layout>
