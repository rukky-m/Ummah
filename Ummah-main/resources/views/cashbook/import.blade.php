<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Import Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Bulk Import Transactions</h1>
                        <p class="text-gray-500 text-sm mt-1">Upload a CSV file to import multiple transactions at once</p>
                    </div>
                    <a href="{{ route('cashbook.index') }}" class="text-gray-500 hover:text-army-green transition flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Cashbook</span>
                    </a>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-bold text-blue-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        How to Import
                    </h3>
                    <ol class="list-decimal list-inside space-y-2 text-blue-700">
                        <li>Download the CSV template below</li>
                        <li>Fill in your transaction data following the format</li>
                        <li>Save the file as CSV</li>
                        <li>Upload it using the form below</li>
                    </ol>
                </div>

                <!-- Download Template -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Step 1: Download Template</h3>
                    <p class="text-gray-600 mb-4">Download our CSV template with sample data to see the correct format.</p>
                    <a href="{{ route('cashbook.template') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-army-green to-green-900 hover:from-green-900 hover:to-army-green text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-green-900/10 hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all">
                        <i class="fas fa-download"></i>
                        <span>Download CSV Template</span>
                    </a>
                </div>

                <!-- File Format Requirements -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">File Format Requirements</h3>
                    
                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border-b">Column</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border-b">Required</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border-b">Format</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase border-b">Example</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-800">Date</td>
                                    <td class="px-4 py-2 text-sm"><span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Required</span></td>
                                    <td class="px-4 py-2 text-sm text-gray-600">YYYY-MM-DD</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">2023-01-15</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-800">Type</td>
                                    <td class="px-4 py-2 text-sm"><span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Required</span></td>
                                    <td class="px-4 py-2 text-sm text-gray-600">income or expense</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">income</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-800">Category</td>
                                    <td class="px-4 py-2 text-sm"><span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Required</span></td>
                                    <td class="px-4 py-2 text-sm text-gray-600">Text</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">Membership Due</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-800">Amount</td>
                                    <td class="px-4 py-2 text-sm"><span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Required</span></td>
                                    <td class="px-4 py-2 text-sm text-gray-600">Positive number</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">5000</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-800">Payment Method</td>
                                    <td class="px-4 py-2 text-sm"><span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Required</span></td>
                                    <td class="px-4 py-2 text-sm text-gray-600">Cash, Bank Transfer, POS, Check</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">Bank Transfer</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-800">Description</td>
                                    <td class="px-4 py-2 text-sm"><span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">Optional</span></td>
                                    <td class="px-4 py-2 text-sm text-gray-600">Text</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">January dues</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-800">Reference</td>
                                    <td class="px-4 py-2 text-sm"><span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">Optional</span></td>
                                    <td class="px-4 py-2 text-sm text-gray-600">Text</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">REF001</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-yellow-800">
                            <strong>Note:</strong> Make sure your CSV file uses the exact column names shown in the template. The first row should contain the headers.
                        </p>
                    </div>
                </div>

                <!-- Upload Form -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-army-green to-green-800 px-6 py-4">
                        <h2 class="text-white font-semibold flex items-center gap-2">
                            <i class="fas fa-upload"></i> 
                            Step 2: Upload Your File
                        </h2>
                    </div>

                    <form action="{{ route('cashbook.import.process') }}" method="POST" enctype="multipart/form-data" class="p-8">
                        @csrf

                        @if($errors->any())
                            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                <h4 class="font-bold text-red-800 mb-2">Upload Error</h4>
                                <ul class="list-disc list-inside text-sm text-red-700">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select CSV File</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-file-csv text-4xl text-gray-400 mb-3"></i>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500">CSV file (MAX. 10MB)</p>
                                        <p id="file-name" class="mt-2 text-sm text-army-green font-medium hidden"></p>
                                    </div>
                                    <input id="file" name="file" type="file" class="hidden" accept=".csv,.txt" required onchange="showFileName(this)" />
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4 pt-8 border-t border-gray-100 mt-10">
                            <a href="{{ route('cashbook.index') }}" class="inline-flex items-center px-6 py-4 bg-gray-50 text-gray-400 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-gray-100 hover:text-gray-600 border border-gray-100 transition-all">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Ledger
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-army-green to-green-900 hover:from-green-900 hover:to-army-green text-white font-black py-4 px-10 rounded-xl shadow-xl shadow-green-900/20 hover:shadow-green-900/30 transition-all active:scale-95 flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                                <i class="fas fa-upload text-[10px]"></i>
                                Import Transactions
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tips -->
                <div class="mt-8 bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-lightbulb text-yellow-500"></i>
                        Tips for Successful Import
                    </h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Use the provided template to ensure correct formatting</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Dates must be in YYYY-MM-DD format (e.g., 2023-01-15)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Type must be exactly "income" or "expense" (lowercase)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Amounts should be positive numbers without currency symbols</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 mt-1"></i>
                            <span>Empty rows will be automatically skipped</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showFileName(input) {
            const fileNameElement = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameElement.textContent = '✓ Selected: ' + input.files[0].name;
                fileNameElement.classList.remove('hidden');
            } else {
                fileNameElement.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
