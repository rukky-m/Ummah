<?php

namespace App\Http\Controllers;

use App\Models\LoanProduct;
use Illuminate\Http\Request;

class AdminLoanProductController extends Controller
{
    public function index(Request $request)
    {
        // Fetch products grouped by category for the view
        $products = LoanProduct::with('vendor')->get()->groupBy('category');
        $vendors = \App\Models\Vendor::active()->orderBy('name')->get();
        $activeTab = $request->query('category', 'motorcycle');
        
        return view('admin.loan-products.index', compact('products', 'vendors', 'activeTab'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:motorcycle,ramadan,sallah,asset',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'vendor' => 'nullable|string|max:255',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        LoanProduct::create($validated);

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    public function update(Request $request, LoanProduct $loanProduct)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'vendor' => 'nullable|string|max:255',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        $loanProduct->update($validated);

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function destroy(LoanProduct $loanProduct)
    {
        $loanProduct->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(LoanProduct $loanProduct)
    {
        $loanProduct->update([
            'is_active' => !$loanProduct->is_active
        ]);

        return redirect()->back()->with('success', 'Product status updated.');
    }
}
