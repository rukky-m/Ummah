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
                    <h2 class="font-black text-2xl text-white leading-tight tracking-tight uppercase">Support Center</h2>
                    <p class="text-xs text-emerald-200/50 font-bold uppercase tracking-widest mt-1">Get help and track your tickets</p>
                </div>
            </div>
            
            <a href="{{ route('support.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-emerald-500 rounded-xl font-black text-[10px] text-white uppercase tracking-widest hover:bg-emerald-500 transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] hover:-translate-y-0.5 active:scale-95">
                <i class="fas fa-plus mr-2"></i> {{ __('New Ticket') }}
            </a>
        </div>

        {{-- Mobile Header --}}
        <div class="flex sm:hidden justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="w-9 h-9 rounded-full bg-emerald-900/30 border border-emerald-800/50 flex items-center justify-center text-emerald-500 active:scale-95 transition">
                    <i class="fas fa-chevron-left text-sm"></i>
                </a>
                <div>
                    <p class="text-[9px] text-emerald-500/70 font-black uppercase tracking-widest leading-none">Helpdesk</p>
                    <h1 class="text-base font-black text-white leading-tight tracking-tight uppercase">Support</h1>
                </div>
            </div>
            <a href="{{ route('support.create') }}" class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/20 active:scale-95 transition">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Quick Contact Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <a href="https://wa.me/{{ str_replace(['+', ' '], '', config('app.support_whatsapp', env('SUPPORT_WHATSAPP', ''))) }}" target="_blank"
                   class="flex items-center gap-5 p-6 bg-[#0B1A14] rounded-3xl border border-emerald-900/50 hover:bg-[#0E211A] hover:border-emerald-500/30 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center border border-emerald-500/20 transition-transform group-hover:rotate-12">
                        <i class="fab fa-whatsapp text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-emerald-400 uppercase tracking-widest mb-1">Chat on WhatsApp</h3>
                        <p class="text-xs text-emerald-600 font-bold uppercase tracking-widest">Get instant help from our team</p>
                    </div>
                    <div class="ml-auto text-emerald-500/30 group-hover:text-emerald-400 transition-colors">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                </a>

                <a href="tel:{{ config('app.support_sms', env('SUPPORT_SMS', '')) }}"
                   class="flex items-center gap-5 p-6 bg-[#0B1A14] rounded-3xl border border-blue-900/30 hover:bg-[#0E211A] hover:border-blue-500/30 transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-blue-500/10 text-blue-400 flex items-center justify-center border border-blue-500/20 transition-transform group-hover:rotate-12">
                        <i class="fas fa-sms text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-blue-400 uppercase tracking-widest mb-1">Send an SMS</h3>
                        <p class="text-xs text-blue-600 font-bold uppercase tracking-widest">Reach out via direct message</p>
                    </div>
                    <div class="ml-auto text-blue-500/30 group-hover:text-blue-400 transition-colors">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-4 mb-4">
                <h3 class="text-xs font-black text-emerald-700 uppercase tracking-[0.2em]">{{ __('Your Recent Tickets') }}</h3>
                <div class="flex-1 h-px bg-emerald-900/30"></div>
            </div>

            @if($tickets->isEmpty())
                <div class="bg-[#0B1A14] overflow-hidden sm:rounded-3xl p-12 text-center border border-emerald-900/50">
                    <div class="w-20 h-20 bg-emerald-900/20 rounded-full flex items-center justify-center mx-auto mb-6 border border-emerald-800/30">
                        <i class="fas fa-headset text-3xl text-emerald-700"></i>
                    </div>
                    <h3 class="text-lg font-black text-white uppercase tracking-wider mb-2">No support tickets yet</h3>
                    <p class="text-emerald-600/70 max-w-sm mx-auto mb-8 font-medium">If you have any questions or issues, our support team is here to help.</p>
                    <a href="{{ route('support.create') }}" class="text-emerald-500 font-black text-sm uppercase tracking-widest hover:text-emerald-400 transition-colors">
                        Create your first ticket <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($tickets as $ticket)
                        <a href="{{ route('support.show', $ticket) }}" 
                           class="block bg-[#0B1A14] overflow-hidden sm:rounded-2xl border border-emerald-900/50 hover:border-emerald-500/40 hover:bg-[#0E211A] transition-all group">
                            <div class="p-6 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border 
                                        @if($ticket->status === 'open') bg-blue-500/10 text-blue-400 border-blue-500/20 
                                        @elseif($ticket->status === 'in_progress') bg-gold/10 text-gold border-gold/20 
                                        @else bg-gray-500/10 text-gray-400 border-gray-500/20 @endif transition-colors">
                                        <i class="fas fa-ticket-alt text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white group-hover:text-emerald-400 transition-colors">{{ $ticket->subject }}</h4>
                                        <div class="flex items-center gap-3 mt-1">
                                            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70">{{ $ticket->created_at->format('M d, Y') }}</span>
                                            <span class="w-1 h-1 bg-emerald-800/50 rounded-full"></span>
                                            <span class="text-[10px] font-black uppercase tracking-widest 
                                                @if($ticket->priority === 'high') text-red-400 @elseif($ticket->priority === 'medium') text-gold @else text-blue-400 @endif">
                                                {{ $ticket->priority }} Priority
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border
                                        @if($ticket->status === 'open') bg-blue-500/10 text-blue-400 border-blue-500/20 
                                        @elseif($ticket->status === 'in_progress') bg-gold/10 text-gold border-gold/20 
                                        @else bg-gray-900 text-gray-400 border-gray-700 @endif opacity-80">
                                        {{ str_replace('_', ' ', $ticket->status) }}
                                    </span>
                                    <i class="fas fa-chevron-right text-emerald-800/50 group-hover:text-emerald-500 group-hover:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
