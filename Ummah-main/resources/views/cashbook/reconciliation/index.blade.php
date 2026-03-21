<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bank Reconciliation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto px-4 py-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Bank Reconciliation</h1>
                    <p class="text-gray-500 mt-1">Match cashbook records with bank statements</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('cashbook.index') }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-bold hover:bg-gray-200 transition flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> 
                        <span>Back to Cashbook</span>
                    </a>
                    <a href="{{ route('cashbook.reconciliation.create') }}" class="bg-army-green text-white px-6 py-3 rounded-lg shadow-lg hover:bg-green-800 transition flex items-center gap-2">
                        <i class="fas fa-plus"></i> 
                        <span>New Reconciliation</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-army-green">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Reconciliations</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $reconciliations->total() }}</h3>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <p class="text-sm font-semibold text-green-600 uppercase tracking-wider">Completed</p>
                    <h3 class="text-2xl font-bold text-green-700 mt-2">{{ $reconciliations->where('status', 'completed')->count() }}</h3>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                    <p class="text-sm font-semibold text-yellow-600 uppercase tracking-wider">Pending</p>
                    <h3 class="text-2xl font-bold text-yellow-700 mt-2">{{ $reconciliations->where('status', 'pending')->count() }}</h3>
                </div>
            </div>

            <!-- Reconciliation List -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Reconciliation History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bank Balance</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cashbook Balance</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Difference</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reconciled By</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($reconciliations as $reconciliation)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $reconciliation->reconciliation_date->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                        ₦ {{ number_format($reconciliation->bank_statement_balance, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                        ₦ {{ number_format($reconciliation->cashbook_balance, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ abs($reconciliation->difference) < 0.01 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $reconciliation->difference >= 0 ? '+' : '' }} ₦ {{ number_format($reconciliation->difference, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($reconciliation->status === 'completed')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Completed</span>
                                        @else
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $reconciliation->reconciledBy->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <a href="{{ route('cashbook.reconciliation.show', $reconciliation->id) }}" class="text-army-green hover:text-green-800 transition" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                            <p>No reconciliations found.</p>
                                            <a href="{{ route('cashbook.reconciliation.create') }}" class="mt-4 text-army-green hover:underline">Create your first reconciliation</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($reconciliations->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $reconciliations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
