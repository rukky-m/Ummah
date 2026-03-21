<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Apply for a Loan') }}
        </h2>
        <p class="text-sm text-emerald-500/60 mt-1">Select the type of loan you wish to apply for.</p>
    </x-slot>

    <div class="py-12 bg-transparent">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Main Loan -->
                <a href="{{ route('loans.apply.step1') }}" class="block bg-[#0B1A14] p-6 rounded-2xl shadow-sm border border-emerald-900/50 hover:-translate-y-1 hover:border-emerald-500/50 hover:shadow-[0_0_15px_rgba(16,185,129,0.2)] transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="text-lg font-black text-white mb-2">Main Loan</h3>
                    <p class="text-sm text-emerald-500/60">Apply for a standard cash loan for various purposes.</p>
                </a>

                <!-- Motorcycle Loan -->
                <a href="{{ route('loans.apply.motorcycle') }}" class="block bg-[#0B1A14] p-6 rounded-2xl shadow-sm border border-emerald-900/50 hover:-translate-y-1 hover:border-gold/50 hover:shadow-[0_0_15px_rgba(234,179,8,0.2)] transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-gold/10 border border-gold/20 text-gold flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <h3 class="text-lg font-black text-white mb-2">Motorcycle Loan</h3>
                    <p class="text-sm text-emerald-500/60">Apply for financing to purchase a motorcycle.</p>
                </a>

                <!-- Asset Loan -->
                <a href="{{ route('loans.apply.asset') }}" class="block bg-[#0B1A14] p-6 rounded-2xl shadow-sm border border-emerald-900/50 hover:-translate-y-1 hover:border-blue-500/50 hover:shadow-[0_0_15px_rgba(59,130,246,0.2)] transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-laptop-house"></i>
                    </div>
                    <h3 class="text-lg font-black text-white mb-2">Asset Loan</h3>
                    <p class="text-sm text-emerald-500/60">Finance the purchase of appliances, electronics, and other assets.</p>
                </a>

                <!-- Ramadan/Sallah Loan -->
                <a href="{{ route('loans.apply.ramadan_sallah') }}" class="block bg-[#0B1A14] p-6 rounded-2xl shadow-sm border border-emerald-900/50 hover:-translate-y-1 hover:border-purple-500/50 hover:shadow-[0_0_15px_rgba(168,85,247,0.2)] transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h3 class="text-lg font-black text-white mb-2">Ramadan / Sallah Packages</h3>
                    <p class="text-sm text-emerald-500/60">Special commodities packages for Ramadan and Sallah periods.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
