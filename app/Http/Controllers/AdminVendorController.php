<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminVendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::withCount('products')->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contact_person' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        Vendor::create($validated);

        return redirect()->back()->with('success', 'Vendor added successfully.');
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contact_person' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $vendor->update($validated);

        return redirect()->back()->with('success', 'Vendor details updated successfully.');
    }

    public function toggleStatus(Vendor $vendor)
    {
        $vendor->update(['is_active' => !$vendor->is_active]);
        return redirect()->back()->with('success', 'Vendor status updated.');
    }

    public function destroy(Vendor $vendor)
    {
        if ($vendor->products()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete vendor with linked products.');
        }

        $vendor->delete();
        return redirect()->back()->with('success', 'Vendor deleted successfully.');
    }
}
