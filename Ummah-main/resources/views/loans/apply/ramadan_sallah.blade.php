<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('loans.create') }}" class="w-10 h-10 rounded-full bg-[#0B1A14] border border-emerald-900/50 shadow-sm flex items-center justify-center text-emerald-600/70 hover:text-emerald-400 hover:bg-emerald-900/30 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Ramadan / Sallah Package') }}
                </h2>
                <p class="text-sm text-emerald-500/60 mt-1">Request for commodities or RAM for festive periods.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Info Card -->
            <div class="bg-gold/10 border-l-4 border-gold p-6 rounded-r-xl mb-8 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 p-2 bg-gold/10 rounded-full text-gold">
                        <i class="fas fa-star-and-crescent text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gold text-lg mb-2">Package Conditions</h3>
                        <ul class="list-disc list-inside text-sm text-yellow-600/90 space-y-2">
                            <li><strong>Membership:</strong> Must be a member for 6 months to 1 year (package dependent).</li>
                            <li><strong>Repayment:</strong> 4 months period.</li>
                            <li><strong>Profit:</strong> Prices include 6% profit markup.</li>
                            <li><strong>Limits:</strong> Junior Staff (N150,000), Senior Staff (N220,000).</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-[#0B1A14] overflow-hidden shadow-sm border border-emerald-900/50 sm:rounded-3xl">
                <div class="p-8 md:p-12">
                    <form action="{{ route('loans.apply.store.ramadan_sallah') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Package Type -->
                            <div>
                                <label for="package_type" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">Package Variant</label>
                                <select id="package_type" name="package_type" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all cursor-pointer" required>
                                    <option value="Ramadan">Ramadan Package</option>
                                    <option value="Sallah">Sallah Package</option>
                                </select>
                            </div>

                            <!-- Staff Category -->
                            <div>
                                <label for="staff_category" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">Staff Category</label>
                                <select id="staff_category" name="staff_category" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all cursor-pointer" required>
                                    <option value="Junior Staff">Junior Staff (Max N150k)</option>
                                    <option value="Senior Staff">Senior Staff (Max N220k)</option>
                                </select>
                            </div>

                            <!-- Vendor -->
                             <div class="md:col-span-2">
                                <label for="vendor" class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-3">Preferred Vendor</label>
                                <select id="vendor" name="vendor" class="w-full px-6 py-4 bg-[#0E211A] border border-emerald-900/50 rounded-2xl focus:ring-2 focus:ring-gold/20 focus:border-gold/50 text-sm font-bold text-emerald-100 transition-all cursor-pointer" required>
                                    <option value="">Select Vendor</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->name }}">{{ $vendor->name }}</option>
                                    @endforeach
                                    <option value="Other">Other Approved Vendor</option>
                                </select>
                                <p class="text-[10px] text-emerald-600/70 mt-2 italic">Supply is strictly to our vendors as per agreement.</p>
                            </div>

                            <!-- Amount (Hidden, calculated automatically) -->
                            <input id="amount" type="hidden" name="amount" value="{{ old('amount') }}" required>

                            <!-- Commodity Items Selection -->
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-emerald-600/70 uppercase tracking-[0.2em] mb-4">Select Items & Statistics</label>
                                <div class="bg-[#0E211A] rounded-2xl p-6 border border-emerald-900/30 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2 bg-[#0B1A14] p-4 rounded-xl border border-gold/20 shadow-sm flex justify-between items-center mb-4">
                                        <span class="text-white font-bold text-sm uppercase tracking-wider">Total Amount</span>
                                        <span class="text-2xl font-black text-emerald-400" id="itemsTotalDisplay">₦0.00</span>
                                    </div>
                                    @forelse($commodities as $product)
                                        <div class="item-row flex items-center justify-between p-3 bg-[#0B1A14] rounded-xl border border-emerald-900/50 shadow-sm transition-all hover:border-gold/40">
                                            <label class="flex items-center gap-3 cursor-pointer flex-1">
                                                <input type="checkbox" name="items[]" value="{{ $product->name }}" data-price="{{ $product->price }}" class="item-checkbox w-5 h-5 text-gold bg-[#0E211A] border-emerald-900/50 rounded focus:ring-gold focus:ring-offset-0">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold text-white">{{ $product->name }}</span>
                                                    <span class="text-[10px] text-emerald-500/60 font-bold">₦{{ number_format($product->price) }} <span class="text-xs font-normal text-emerald-600/70">({{ $product->vendor->name ?? $product->vendor ?? 'General' }})</span></span>
                                                </div>
                                            </label>
                                            <select name="quantities[{{ $product->name }}]" class="item-quantity w-20 px-2 py-1.5 text-xs font-bold bg-[#0E211A] border border-emerald-900/30 rounded-lg focus:ring-2 focus:ring-gold/20 text-center text-white cursor-pointer" disabled>
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    @empty
                                        <p class="text-emerald-500/50 text-sm italic p-4 text-center col-span-2">No commodity items available currently. Please contact admin.</p>
                                    @endforelse
                                </div>
                                <p class="text-[10px] text-emerald-600/70 mt-2 italic">
                                    Select items to automatically calculate total.
                                </p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-gold hover:bg-yellow-500 text-white font-black py-4 rounded-2xl shadow-[0_0_15px_rgba(234,179,8,0.3)] hover:shadow-[0_0_25px_rgba(234,179,8,0.5)] hover:-translate-y-1 transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-3 active:scale-95">
                                Submit Request <i class="fas fa-check-circle"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const amountInput = document.getElementById('amount');
        const itemsTotalDisplay = document.getElementById('itemsTotalDisplay');
        const allQuantityInputs = document.querySelectorAll('.item-quantity');

        function calculateTotal() {
            let total = 0;
            itemCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const price = parseFloat(checkbox.dataset.price);
                    const qtyInput = checkbox.closest('.item-row').querySelector('.item-quantity');
                    const qty = parseInt(qtyInput.value) || 0;
                    total += price * qty;
                }
            });
            
            // Update Amount Input
            amountInput.value = total;
            
            // Update Display
            itemsTotalDisplay.textContent = '₦' + total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
        
        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const quantityInput = this.closest('.item-row').querySelector('.item-quantity');
                if (this.checked) {
                    quantityInput.disabled = false;
                    quantityInput.focus();
                } else {
                    quantityInput.disabled = true;
                    quantityInput.value = '1'; // Reset to 1
                }
                calculateTotal();
            });
        });

        allQuantityInputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
            input.addEventListener('change', calculateTotal);
        });

        // Initial check in case of old input
        calculateTotal();
    });
</script>
