<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('loans.index') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gold leading-tight tracking-tight uppercase">
                    {{ __('Asset Acquisition') }}
                </h2>
                <p class="text-xs text-emerald-500/60 mt-1 font-bold uppercase tracking-widest">Financing for Household, Electronics & Building Materials</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Info Card -->
            <div class="bg-emerald-900/10 border-l-4 border-emerald-500 p-8 rounded-r-[2rem] mb-10 shadow-2xl backdrop-blur-sm border-y border-r border-emerald-500/10">
                <div class="flex items-start gap-6">
                    <div class="shrink-0 w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 border border-emerald-500/20">
                        <i class="fas fa-couch text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-emerald-400 text-sm mb-4 uppercase tracking-[0.2em]">Acquisition Protocols</h3>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-3 text-[11px] text-emerald-100/70 font-bold uppercase tracking-widest leading-relaxed">
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Proforma Invoice Required</li>
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Approved Vendors Only</li>
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> 12 Months Repayment</li>
                            <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> 10% Flat Admin Rate</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-[#0B1A14] overflow-hidden shadow-2xl border border-emerald-900/50 sm:rounded-[2.5rem]">
                <div class="p-8 md:p-12">
                    <form id="assetForm" action="{{ route('loans.apply.store.asset') }}" method="POST" class="space-y-10">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <!-- Item Selection -->
                            <div class="md:col-span-2">
                                <label for="asset_id" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">Inventory Catalogue Selection</label>
                                <div class="relative group">
                                    <select id="asset_id" name="asset_id" class="w-full px-6 py-5 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[13px] font-black text-white transition-all cursor-pointer appearance-none uppercase tracking-widest" required x-data="{ 
                                        prices: { @foreach($assets as $asset) '{{ $asset->id }}': '{{ $asset->price }}', @endforeach },
                                        names: { @foreach($assets as $asset) '{{ $asset->id }}': '{{ $asset->name }}', @endforeach },
                                        updatePrice() {
                                            let id = $el.value;
                                            if(this.prices[id]) {
                                                let formatted = '₦' + parseFloat(this.prices[id]).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                                $root.querySelector('#display_price_large').innerText = formatted;
                                                $root.querySelector('#selected_item_name').innerText = this.names[id];
                                                $root.querySelector('#amount').value = this.prices[id];
                                                $root.querySelector('#price_container').style.display = 'block';
                                            } else {
                                                $root.querySelector('#price_container').style.display = 'none';
                                            }
                                        }
                                    }" @change="updatePrice()">
                                        <option value="" class="bg-[#0B1A14]">-- Select Premium Asset --</option>
                                        @foreach($assets as $asset)
                                            <option value="{{ $asset->id }}" class="bg-[#0B1A14]">{{ $asset->name }} (₦{{ number_format($asset->price, 2) }}) - {{ $asset->vendor->name ?? $asset->vendor }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-emerald-700">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                                <input type="hidden" name="amount" id="amount">
                                <x-input-error :messages="$errors->get('asset_id')" class="mt-2" />
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">Purchase Quantity</label>
                                <div class="relative group">
                                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-600/70 font-black text-xl">x</div>
                                    <input id="quantity" type="number" name="quantity" value="1" min="1"
                                        class="w-full pl-12 pr-6 py-5 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-white font-black text-2xl tracking-tighter transition-all focus:outline-none shadow-inner" required>
                                </div>
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                            <!-- Display Selected Item Details -->
                            <div class="md:col-span-2 transition-all duration-500" id="price_container" style="display: none;">
                                <div class="p-8 bg-emerald-900/10 border border-emerald-500/20 rounded-[2rem] flex items-center justify-between shadow-inner backdrop-blur-sm">
                                    <div class="flex items-center gap-6">
                                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center shadow-2xl">
                                            <i class="fas fa-shopping-bag text-2xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-emerald-500/50 uppercase tracking-[0.3em] text-[10px] mb-1">Authenticated Asset</h4>
                                            <p class="text-lg font-black text-white tracking-widest" id="selected_item_name"></p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="font-black text-emerald-600/70 uppercase tracking-[0.3em] text-[10px] mb-1">Standard Valuation</h4>
                                        <p class="text-3xl font-black text-gold tracking-tighter" id="display_price_large">₦0.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-emerald-900/30 pt-10">
                            <h3 class="font-black text-lg text-white mb-8 flex items-center gap-4 uppercase tracking-tight">
                                <i class="fas fa-building text-gold text-xl"></i> Vendor Verification
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <input type="text" name="vendor_name" placeholder="REGISTERED VENTURE NAME" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[11px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                                    <input type="text" name="vendor_phone" placeholder="OFFICIAL CONTACT NUMBER" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[11px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                                </div>
                                <div class="space-y-4">
                                    <input type="text" name="vendor_bank" placeholder="SETTLEMENT BANK NAME" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[11px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                                    <input type="text" name="vendor_account_number" placeholder="SETTLEMENT ACCOUNT NUMBER" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[11px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-emerald-900/30 pt-10">
                            <h3 class="font-black text-lg text-white mb-8 flex items-center gap-4 uppercase tracking-tight">
                                <i class="fas fa-handshake text-gold text-xl"></i> Security Endorsement
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <input type="text" name="guarantor_name" placeholder="GUARANTOR FULL LEGAL NAME" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[10px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                                <input type="text" name="guarantor_dept" placeholder="DEPT / SERVICE UNIT" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[10px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                                <input type="text" name="guarantor_phone" placeholder="PRIMARY PHONE CONTACT" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500/50 text-[10px] font-black text-white placeholder-emerald-800 uppercase tracking-widest focus:outline-none transition-all shadow-inner" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-black py-6 rounded-[2rem] shadow-2xl shadow-emerald-900/50 hover:shadow-emerald-500/30 hover:-translate-y-1.5 transition-all uppercase tracking-[0.25em] text-[11px] flex items-center justify-center gap-4 active:scale-95 group">
                                <span>Commit Asset Acquisition</span>
                                <i class="fas fa-file-signature group-hover:scale-110 transition-transform"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
