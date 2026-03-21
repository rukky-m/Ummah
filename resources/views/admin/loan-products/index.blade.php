<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-white tracking-tight flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#0B1A14] border border-emerald-900/50 flex items-center justify-center text-emerald-500/70 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]"><i class="fas fa-boxes text-lg"></i></div>
            {{ __('Inventory Architecture') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-hidden bg-[#0E211A] shadow-[0_0_20px_rgba(16,185,129,0.05)] border border-emerald-900/50 sm:rounded-3xl">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900 opacity-50"></div>
                <div class="p-8" x-data="{ activeTab: '{{ $activeTab }}' }">
                    
                    @if(session('success'))
                        <div class="mb-8 bg-emerald-900/20 border border-emerald-500/30 text-emerald-400 px-6 py-4 rounded-2xl flex items-center gap-3 animate-fade-in shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                            <i class="fas fa-check-circle text-lg"></i>
                            <span class="font-bold text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
                        <div>
                            <h3 class="text-xl font-black text-white tracking-tight flex items-center gap-2">
                                <span class="w-2.5 h-6 bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span>
                                Product Registry
                            </h3>
                            <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mt-2">Manage items available for specific loan categories.</p>
                        </div>
                    </div>

                    <!-- Category Tabs -->
                    <div class="flex flex-wrap bg-[#0B1A14] p-1.5 rounded-2xl border border-emerald-900/50 shadow-[inset_0_2px_4px_rgba(0,0,0,0.4)] mb-10 gap-1 relative z-10">
                        @foreach(['motorcycle', 'ramadan', 'sallah', 'asset'] as $tab)
                            <button @click="activeTab = '{{ $tab }}'"
                                :class="activeTab === '{{ $tab }}' ? 'bg-[#0E211A] text-emerald-400 border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.2)] scale-100' : 'text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/20 border border-transparent scale-95 hover:scale-100'"
                                class="flex-1 min-w-[120px] rounded-xl py-3.5 text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300">
                                {{ $tab }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Content Area -->
                    @foreach(['motorcycle', 'ramadan', 'sallah', 'asset'] as $category)
                        <div x-show="activeTab === '{{ $category }}'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                            <div class="flex justify-between items-center mb-6 px-2">
                                <h4 class="text-xs font-black uppercase tracking-[0.3em] text-emerald-400 px-5 py-2.5 bg-emerald-900/20 border border-emerald-500/20 rounded-xl inline-flex items-center gap-2 shadow-[inset_0_2px_5px_rgba(0,0,0,0.2)]">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div>
                                    {{ $category }} Series
                                </h4>
                                
                                <button x-data="" x-on:click="$dispatch('open-modal', 'add-modal-{{ $category }}')" 
                                    class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:-translate-y-0.5 transition-all shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] active:scale-95 z-20 relative flex items-center gap-2">
                                    <i class="fas fa-plus text-xs"></i> New Product
                                </button>
                            </div>

                            <div class="space-y-4 relative z-0">
                                @forelse($products->get($category, []) as $product)
                                    <div class="group relative bg-[#0B1A14] p-5 rounded-3xl border border-emerald-900/50 hover:border-emerald-500/50 hover:shadow-[0_0_20px_rgba(16,185,129,0.1)] transition-all flex flex-col md:flex-row justify-between items-center gap-4 hover:-translate-y-0.5 duration-300 overflow-hidden">
                                        
                                        <!-- Decorative background glow -->
                                        <div class="absolute -right-20 -top-20 w-40 h-40 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-colors pointer-events-none"></div>

                                        <div class="flex items-center gap-5 w-full md:w-auto relative z-10">
                                            <div class="w-14 h-14 bg-[#0E211A] border-2 border-emerald-900/50 rounded-2xl flex items-center justify-center text-emerald-500/50 group-hover:text-emerald-400 group-hover:border-emerald-500/50 transition-all shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                                                <i class="fas fa-box-open text-xl group-hover:scale-110 transition-transform"></i>
                                            </div>
                                            <div>
                                                <h5 class="font-bold text-lg text-white tracking-tight group-hover:text-emerald-300 transition-colors">{{ $product->name }}</h5>
                                                <p class="text-[11px] font-black uppercase tracking-widest text-emerald-400 mt-1 drop-shadow-[0_0_5px_rgba(52,211,153,0.3)]">₦{{ number_format($product->price, 0) }}</p>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-6 w-full md:w-auto justify-between md:justify-end relative z-10 bg-[#0E211A] border border-emerald-900/50 md:border-none md:bg-transparent rounded-2xl p-4 md:p-0">
                                            <div class="text-[10px] bg-[#0B1A14] md:bg-[#0E211A] border border-emerald-900/50 md:border-emerald-900/30 px-4 py-2 rounded-xl flex items-center gap-3">
                                                <span class="text-emerald-600/70 font-black uppercase tracking-[0.2em] relative top-0.5"><i class="fas fa-store text-emerald-900/70 mr-1"></i> Partner</span>
                                                <span class="font-bold text-white tracking-tight">
                                                    @if($product->vendor_id)
                                                        {{ $product->vendor->name }}
                                                    @else
                                                        {{ $product->vendor ?? 'Internal Registry' }}
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="flex items-center gap-4">
                                                <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $product->is_active ? 'bg-emerald-900/30 text-emerald-400 border-emerald-500/30' : 'bg-rose-900/20 text-rose-400 border-rose-500/30' }}">
                                                    {{ $product->is_active ? 'Active' : 'Offline' }}
                                                </span>
                                                
                                                <div class="flex items-center gap-2">
                                                    <button x-on:click="$dispatch('open-modal', 'edit-modal-{{ $product->id }}')" 
                                                        class="w-10 h-10 flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 border border-transparent hover:border-emerald-500/30 rounded-xl transition-all shadow-sm">
                                                        <i class="fas fa-edit text-sm"></i>
                                                    </button>
                                                    <form action="{{ route('admin.loan-products.toggle', $product) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" title="{{ $product->is_active ? 'Take Offline' : 'Mark Active' }}" class="w-10 h-10 flex items-center justify-center {{ $product->is_active ? 'text-amber-600/70 hover:text-amber-500 hover:bg-amber-900/20 hover:border-amber-500/30' : 'text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 hover:border-emerald-500/30' }} border border-transparent rounded-xl transition-all shadow-sm">
                                                            <i class="fas {{ $product->is_active ? 'fa-ban' : 'fa-check' }} text-sm"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.loan-products.destroy', $product) }}" method="POST" onsubmit="return confirm('Securely purge this product from inventory?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="w-10 h-10 flex items-center justify-center text-rose-600/70 hover:text-rose-400 hover:bg-rose-900/20 border border-transparent hover:border-rose-500/30 rounded-xl transition-all shadow-sm">
                                                            <i class="fas fa-trash-alt text-sm"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Modal (Dark Theme) -->
                                        <x-modal name="edit-modal-{{ $product->id }}" focusable>
                                            <form method="POST" action="{{ route('admin.loan-products.update', $product) }}" class="p-8 bg-[#0E211A] text-left border border-emerald-900/50 rounded-3xl shadow-[0_0_30px_rgba(16,185,129,0.1)] relative overflow-hidden">
                                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900"></div>
                                                @csrf
                                                @method('PUT')

                                                <h2 class="text-2xl font-black text-white tracking-tight mb-8 flex items-center gap-3">
                                                    <i class="fas fa-tools text-emerald-500"></i> Update Specifications
                                                </h2>

                                                <div class="space-y-6">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Model Designation</label>
                                                        <input name="name" type="text" value="{{ $product->name }}" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" required />
                                                    </div>

                                                    <div class="grid grid-cols-2 gap-6">
                                                        <div>
                                                            <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Acquisition Price (₦)</label>
                                                            <input name="price" type="text" value="{{ number_format($product->price, 2, '.', ',') }}" 
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
                                                                class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-emerald-400 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" required />
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Partner Link</label>
                                                            <select name="vendor_id" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]">
                                                                <option value="" class="bg-[#0B1A14]">-- Independent --</option>
                                                                @foreach($vendors as $vendor)
                                                                    <option value="{{ $vendor->id }}" {{ $product->vendor_id == $vendor->id ? 'selected' : '' }} class="bg-[#0B1A14]">{{ $vendor->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Override Vendor Name</label>
                                                        <input name="vendor" type="text" value="{{ $product->vendor }}" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white placeholder-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" placeholder="Manual vendor name" />
                                                    </div>
                                                </div>

                                                <div class="mt-10 flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-emerald-900/50">
                                                    <button type="button" x-on:click="$dispatch('close')" class="px-6 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest text-emerald-600/70 border border-emerald-900/50 hover:bg-emerald-900/30 hover:text-emerald-400 hover:border-emerald-500/50 transition-all">Abort Update</button>
                                                    <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.3)] transition-all flex justify-center items-center gap-2 active:scale-95"><i class="fas fa-save"></i> Commit Changes</button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </div>
                                @empty
                                    <div class="py-20 text-center bg-[#0B1A14] rounded-[2rem] border border-dashed border-emerald-900/50 shadow-[inset_0_2px_10px_rgba(0,0,0,0.3)] mt-2">
                                        <div class="w-20 h-20 mx-auto bg-[#0E211A] border-2 border-emerald-900/50 rounded-2xl flex items-center justify-center text-emerald-900/50 text-4xl mb-6 shadow-inner">
                                            <i class="fas fa-boxes"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-white tracking-tight mb-2">Registry Void</h3>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/50">This inventory branch is entirely empty.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Add Modal (Dark Theme) -->
                            <x-modal name="add-modal-{{ $category }}" focusable>
                                <form method="POST" action="{{ route('admin.loan-products.store') }}" class="p-8 bg-[#0E211A] text-left border border-emerald-900/50 rounded-3xl shadow-[0_0_30px_rgba(16,185,129,0.1)] relative overflow-hidden">
                                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-900 via-emerald-500 to-emerald-900"></div>
                                    @csrf
                                    <input type="hidden" name="category" value="{{ $category }}">

                                    <h2 class="text-2xl font-black text-white tracking-tight mb-8 flex items-center gap-3">
                                        <i class="fas fa-plus-circle text-emerald-500"></i> New {{ ucfirst($category) }}
                                    </h2>

                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Model Designation</label>
                                            <input name="name" type="text" placeholder="e.g. Hero Hunter 125" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white placeholder-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" required />
                                        </div>

                                        <div class="grid grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Acquisition Price (₦)</label>
                                                <input name="price" type="text" placeholder="0,000.00" 
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
                                                    class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-emerald-400 placeholder-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" required />
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Partner Link</label>
                                                <select name="vendor_id" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]">
                                                    <option value="" class="bg-[#0B1A14]">-- No Partner --</option>
                                                    @foreach($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}" class="bg-[#0B1A14]">{{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest text-emerald-600/70 mb-2">Override Vendor Name</label>
                                            <input name="vendor" type="text" class="w-full bg-[#0B1A14] border border-emerald-900/50 rounded-2xl p-4 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/50 transition-all font-bold text-white placeholder-emerald-900/50 shadow-[inset_0_2px_5px_rgba(0,0,0,0.5)]" placeholder="Manual entry if not in list" />
                                        </div>
                                    </div>

                                    <div class="mt-10 flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-emerald-900/50">
                                        <button type="button" x-on:click="$dispatch('close')" class="px-6 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest text-emerald-600/70 border border-emerald-900/50 hover:bg-emerald-900/30 hover:text-emerald-400 hover:border-emerald-500/50 transition-all">Cancel Formation</button>
                                        <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-[0_0_15px_rgba(16,185,129,0.3)] transition-all flex justify-center items-center gap-2 active:scale-95"><i class="fas fa-layer-group"></i> Register Item</button>
                                    </div>
                                </form>
                            </x-modal>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const priceInput = this.querySelector('input[name="price"]');
                if (priceInput) {
                    priceInput.value = priceInput.value.replace(/,/g, '');
                }
            });
        });
    </script>
</x-app-layout>
