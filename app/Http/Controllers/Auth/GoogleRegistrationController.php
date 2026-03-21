<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class GoogleRegistrationController extends Controller
{
    // Step 1: Personal Info
    public function createStep1()
    {
        $user = Auth::user();
        if ($user->member) {
            return redirect()->route('dashboard');
        }

        $data = Session::get('google_registration.step1', [
            'first_name' => explode(' ', $user->name)[0] ?? '',
            'last_name' => explode(' ', $user->name)[1] ?? '',
            'email' => $user->email,
        ]);

        return view('auth.complete-profile-step1', compact('data'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date|before:-18 years',
            'gender' => 'required|in:Male,Female,Other',
            'marital_status' => 'required|string',
            'occupation' => 'required|string',
            'employer_name' => 'required|string',
            'monthly_income_range' => 'required|string',
        ]);

        Session::put('google_registration.step1', $validated);
        return redirect()->route('complete-profile.step2');
    }

    // Step 2: Contact & Identification
    public function createStep2()
    {
        if (!Session::has('google_registration.step1')) {
            return redirect()->route('complete-profile.step1');
        }
        $data = Session::get('google_registration.step2', []);
        return view('auth.complete-profile-step2', compact('data'));
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|unique:members,phone',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'id_type' => 'required|string',
            'id_number' => 'required|string',
            'id_card_file' => 'required|image|max:2048',
            'passport_photo_file' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('id_card_file')) {
            $path = $request->file('id_card_file')->store('temp/id_cards', 'public');
            $validated['id_card_path'] = $path;
        }

        if ($request->hasFile('passport_photo_file')) {
            $path = $request->file('passport_photo_file')->store('temp/passports', 'public');
            $validated['passport_photo_path'] = $path;
        }

        unset($validated['id_card_file']);
        unset($validated['passport_photo_file']);

        Session::put('google_registration.step2', $validated);
        return redirect()->route('complete-profile.step3');
    }

    // Step 3: Next of Kin & Payment
    public function createStep3()
    {
        if (!Session::has('google_registration.step2')) {
            return redirect()->route('complete-profile.step2');
        }
        return view('auth.complete-profile-step3');
    }

    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            'next_of_kin_name' => 'required|string',
            'next_of_kin_phone' => 'required|string',
            'nok_relationship' => 'required|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string',
            'payment_method' => 'required|in:Bank Transfer,Online Payment,Cash',
            'payment_proof_file' => 'nullable|file|max:2048|required_if:payment_method,Bank Transfer',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|size:10',
            'account_name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $step1 = Session::get('google_registration.step1');
        $step2 = Session::get('google_registration.step2');

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof_file')) {
            $paymentProofPath = $request->file('payment_proof_file')->store('payment_proofs', 'public');
        }

        // Create Member
        Member::create([
            'user_id' => $user->id,
            'application_ref' => 'APP-' . date('Y') . '-' . rand(1000, 9999),
            'first_name' => $step1['first_name'],
            'middle_name' => $step1['middle_name'],
            'last_name' => $step1['last_name'],
            'dob' => $step1['dob'],
            'gender' => $step1['gender'],
            'marital_status' => $step1['marital_status'],
            'occupation' => $step1['occupation'],
            'employer_name' => $step1['employer_name'],
            'monthly_income_range' => $step1['monthly_income_range'],
            'phone' => $step2['phone'],
            'address' => $step2['address'],
            'city' => $step2['city'],
            'state' => $step2['state'],
            'id_type' => $step2['id_type'],
            'id_number' => $step2['id_number'],
            'id_card_path' => $step2['id_card_path'],
            'passport_photo_path' => $step2['passport_photo_path'],
            'next_of_kin_name' => $validated['next_of_kin_name'],
            'next_of_kin_phone' => $validated['next_of_kin_phone'],
            'nok_relationship' => $validated['nok_relationship'],
            'emergency_contact_name' => $validated['emergency_contact_name'],
            'emergency_contact_phone' => $validated['emergency_contact_phone'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_name' => $validated['account_name'],
            'payment_method' => $validated['payment_method'],
            'payment_proof_path' => $paymentProofPath,
            'status' => 'pending',
        ]);
        
        // Update user role to member (but still pending approval)
        $user->update(['role' => 'member']);

        Session::forget('google_registration');
        
        return redirect()->route('dashboard')->with('success', 'Your profile is complete! Our team will review your membership application.');
    }
}
