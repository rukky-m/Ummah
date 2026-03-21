<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-white tracking-tight flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-500/70 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]"><i class="fas fa-handshake text-lg"></i></div>
            {{ __('Vendor Architecture') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-hidden bg-[#0E211A] shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900 opacity-50"></div>
                <div class="p-8">
                    
                    @if(session('success'))
                        <div class="mb-8 bg-emerald-900/20 border border-emerald-500/30 text-emerald-400 px-6 py-4 rounded-2xl flex items-center gap-3 animate-fade-in shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                            <i class="fas fa-check-circle text-lg"></i>
                            <span class="font-bold text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-8 bg-rose-900/20 border border-rose-500/30 text-rose-400 px-6 py-4 rounded-2xl flex items-center gap-3 animate-fade-in shadow-[0_0_15px_rgba(225,29,72,0.1)]">
                            <i class="fas fa-exclamation-circle text-lg"></i>
                            <span class="font-bold text-sm">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                        <div>
                            <h3 class="text-xl font-black text-white tracking-tight flex items-center gap-2">
                                <span class="w-2.5 h-6 bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span>
                                Ecosystem Partners
                            </h3>
                            <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mt-2">Strategic vendors providing essential items and services for our members.</p>
                        </div>
                        
                        <button x-data="" x-on:click="$dispatch('open-modal', 'add-vendor-modal')" 
                            class="group bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 active:scale-95">
                            <i class="fas fa-plus text-[10px] group-hover:rotate-90 transition-transform duration-300"></i>
                            Register Vendor
                        </button>
                    </div>

                    <!-- Vendor Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($vendors as $vendor)
                            <div class="group relative bg-[#0B1A14] p-6 rounded-3xl border border-emerald-900/50 hover:border-emerald-500/50 hover:shadow-[0_0_20px_rgba(16,185,129,0.1)] transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                                
                                <!-- Decorative background glow -->
                                <div class="absolute -right-20 -top-20 w-40 h-40 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-colors pointer-events-none"></div>

                                <!-- Status Badge -->
                                <div class="absolute top-6 right-6 z-10">
                                    <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $vendor->is_active ? 'bg-emerald-900/30 text-emerald-400 border-emerald-500/30 shadow-[inset_0_0_10px_rgba(16,185,129,0.2)]' : 'bg-rose-900/20 text-rose-400 border-rose-500/30 shadow-[inset_0_0_10px_rgba(225,29,72,0.2)]' }}">
                                        {{ $vendor->is_active ? 'Active' : 'Archived' }}
                                    </span>
                                </div>

                                <div class="mb-6 relative z-10">
                                    <div class="w-14 h-14 bg-[#0E211A] border-2 border-emerald-900/50 text-emerald-500/50 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-900/30 group-hover:text-emerald-400 group-hover:border-emerald-500/50 transition-all duration-300 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                                        <i class="fas fa-building shadow-sm group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <h4 class="font-black text-xl text-white tracking-tight group-hover:text-emerald-300 transition-colors">{{ $vendor->name }}</h4>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mt-1 flex items-center gap-1.5"><i class="fas fa-map-marker-alt text-emerald-900/80"></i>{{ $vendor->address ?? 'Registry Pending' }}</p>
                                </div>

                                <div class="space-y-4 mb-8 bg-[#0E211A] p-4 rounded-2xl border border-emerald-900/30 relative z-10">
                                    <div class="flex items-center gap-3 text-[11px] font-bold text-emerald-100/70">
                                        <div class="w-8 h-8 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-xs text-emerald-500/50 shadow-inner">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        {{ $vendor->contact_person ?? 'Unnamed Relation' }}
                                    </div>
                                    <div class="flex items-center gap-3 text-[11px] font-bold text-emerald-100/70">
                                        <div class="w-8 h-8 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-xs text-blue-500/60 shadow-inner">
                                            <i class="fas fa-phone-alt"></i>
                                        </div>
                                        {{ $vendor->phone }}
                                    </div>
                                    <div class="flex items-center gap-3 text-[11px] font-bold text-emerald-100/70">
                                        <div class="w-8 h-8 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-xs text-gold/60 shadow-inner">
                                            <i class="fas fa-boxes"></i>
                                        </div>
                                        {{ $vendor->products_count }} Inventory Items
                                    </div>
                                </div>

                                <div class="pt-6 border-t border-emerald-900/50 flex items-center justify-between relative z-10">
                                    <button x-on:click="$dispatch('open-modal', 'edit-vendor-{{ $vendor->id }}')" 
                                        class="text-[10px] font-black uppercase tracking-widest text-emerald-600/80 hover:text-emerald-400 transition-colors flex items-center gap-1">
                                        <i class="fas fa-cog"></i> Config
                                    </button>
                                    
                                    <div class="flex items-center gap-3">
                                        <form action="{{ route('admin.vendors.toggle', $vendor) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-[10px] font-black uppercase tracking-widest {{ $vendor->is_active ? 'text-amber-600/70 hover:text-amber-500' : 'text-emerald-600/70 hover:text-emerald-400' }} transition-colors p-2 rounded-lg hover:bg-[#0E211A] border border-transparent hover:border-emerald-900/50">
                                                {{ $vendor->is_active ? 'Deactivate' : 'Enable' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" onsubmit="return confirm('Securely remove this vendor from registry?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-rose-600/70 hover:text-rose-400 transition-colors p-2 rounded-lg hover:bg-[#0E211A] border border-transparent hover:border-emerald-900/50">
                                                Purge
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Edit Modal (Dark Theme) -->
                                <x-modal name="edit-vendor-{{ $vendor->id }}" focusable>
                                    <form method="POST" action="{{ route('admin.vendors.update', $vendor) }}" class="p-8 bg-[#0E211A] text-left border border-emerald-900/50 rounded-3xl shadow-[0_0_30px_rgba(16,185,129,0.1)] relative overflow-hidden">
                                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900"></div>
                                        @csrf
                                        @method('PUT')

                                        <h2 class="text-2xl font-black text-white tracking-tight mb-8 flex items-center gap-3">
                                            <i class="fas fa-tools text-emerald-500"></i> Partner Configuration
                                        </h2>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="col-span-2">
                                                <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Company Legal Name</label>
                                                <input name="name" type="text" value="{{ old('name', $vendor->name) }}" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" required />
                                            </div>

                                            <div>
                                                <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Protocol Phone</label>
                                                <input name="phone" type="text" value="{{ old('phone', $vendor->phone) }}" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" required />
                                            </div>

                                            <div>
                                                <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Digital Mail</label>
                                                <input name="email" type="email" value="{{ old('email', $vendor->email) }}" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" />
                                            </div>

                                            <div class="col-span-2">
                                                <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Key Liaison Person</label>
                                                <input name="contact_person" type="text" value="{{ old('contact_person', $vendor->contact_person) }}" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" />
                                            </div>

                                            <div class="col-span-2">
                                                <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Global Headquarters</label>
                                                <textarea name="address" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" rows="3">{{ old('address', $vendor->address) }}</textarea>
                                            </div>
                                        </div>

                                        <div class="mt-10 flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-emerald-900/50">
                                            <button type="button" x-on:click="$dispatch('close')" class="px-6 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest text-emerald-600/70 border border-emerald-900/50 hover:bg-emerald-900/30 hover:text-emerald-400 transition-all">Abort</button>
                                            <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.3)] transition-all flex items-center justify-center gap-2 active:scale-95"><i class="fas fa-save"></i> Apply Changes</button>
                                        </div>
                                    </form>
                                </x-modal>
                            </div>
                        @empty
                            <div class="col-span-full py-20 text-center bg-[#0B1A14] rounded-[2rem] border border-dashed border-emerald-900/50 shadow-[inset_0_2px_10px_rgba(0,0,0,0.3)]">
                                <div class="w-20 h-20 mx-auto bg-[#0E211A] border-2 border-emerald-900/50 text-emerald-900/50 rounded-2xl flex items-center justify-center text-4xl mb-6 shadow-inner">
                                    <i class="fas fa-store-slash"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white tracking-tight">Ecosystem Empty</h3>
                                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50 mt-2">No partners have been registered in the system yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-10">
                        {{ $vendors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Vendor Modal (Dark Theme) -->
    <x-modal name="add-vendor-modal" focusable>
        <form method="POST" action="{{ route('admin.vendors.store') }}" class="p-8 bg-[#0E211A] text-left border border-emerald-900/50 rounded-3xl shadow-[0_0_30px_rgba(16,185,129,0.1)] relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900"></div>
            @csrf

            <h2 class="text-2xl font-black text-white tracking-tight mb-8 flex items-center gap-3">
                <i class="fas fa-handshake text-emerald-500"></i> Register New Partner
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Company Legal Name</label>
                    <input name="name" type="text" placeholder="e.g. Royal Logistics" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white placeholder-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" required />
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Protocol Phone</label>
                    <input name="phone" type="text" placeholder="Official mobile line" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white placeholder-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" required />
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Digital Mail</label>
                    <input name="email" type="email" placeholder="official@vendor.com" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white placeholder-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" />
                </div>

                <div class="col-span-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Key Liaison Person</label>
                    <input name="contact_person" type="text" placeholder="Full name of representative" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white placeholder-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" />
                </div>

                <div class="col-span-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Global Headquarters</label>
                    <textarea name="address" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white placeholder-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" rows="3" placeholder="Full physical location"></textarea>
                </div>
            </div>

            <div class="mt-10 flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-emerald-900/50">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest text-emerald-600/70 border border-emerald-900/50 hover:bg-emerald-900/30 hover:text-emerald-400 transition-all">Cancel Formation</button>
                <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.3)] transition-all flex items-center justify-center gap-2 active:scale-95"><i class="fas fa-check-circle"></i> Authorize Registry</button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
