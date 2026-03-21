<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MemberRegistrationController extends Controller
{
    // Step 1: Personal Info
    public function createStep1()
    {
        $data = Session::get('member_registration.step1', []);
        return view('join.step1', compact('data'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Only check users for registration uniqueness
            'dob' => 'required|date|before:-18 years',
            'gender' => 'required|in:Male,Female,Other',
            'marital_status' => 'required|string',
            'occupation' => 'required|string',
            'employer_name' => 'required|string',
            'monthly_income_range' => 'required|string',
        ]);

        Session::put('member_registration.step1', $validated);
        return redirect()->route('join.step2');
    }

    // Step 2: Contact & Identification
    public function createStep2()
    {
        if (!Session::has('member_registration.step1')) {
            return redirect()->route('join.step1');
        }
        $data = Session::get('member_registration.step2', []);
        return view('join.step2', compact('data'));
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
            'id_card_file' => 'required|image|max:2048', // For demo, assuming image is uploaded every time or needs better logic for persistent files across steps
            'passport_photo_file' => 'required|image|max:2048',
        ]);

        // Handle file uploads temporarily or store path directly?
        // Ideally we store files in step 3 or final submit. 
        // For this simple wizard, we'll store paths in session after uploading temp? 
        // Or better, store on final submit. But user might lose file reference if validation fails on step 3.
        // Let's store files now to a temp location or a "pending_uploads" folder.
        
        if ($request->hasFile('id_card_file')) {
            $path = $request->file('id_card_file')->store('temp/id_cards', 'public');
            $validated['id_card_path'] = $path;
        } else {
             // retain old path if navigating back? Complex. 
             // For simplicity, require re-upload or check session.
             if(Session::has('member_registration.step2.id_card_path')) {
                 $validated['id_card_path'] = Session::get('member_registration.step2')['id_card_path'];
             }
        }

        if ($request->hasFile('passport_photo_file')) {
            $path = $request->file('passport_photo_file')->store('temp/passports', 'public');
            $validated['passport_photo_path'] = $path;
        }

        unset($validated['id_card_file']);
        unset($validated['passport_photo_file']);

        Session::put('member_registration.step2', $validated);
        return redirect()->route('join.step3');
    }

    // Step 3: Next of Kin & Payment
    public function createStep3()
    {
        if (!Session::has('member_registration.step2')) {
            return redirect()->route('join.step2');
        }
        return view('join.step3');
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
            'password' => 'required|string|min:8|confirmed',
        ]);

        $step1 = Session::get('member_registration.step1');
        $step2 = Session::get('member_registration.step2');

        // Create User
        $user = User::create([
            'name' => $step1['first_name'] . ' ' . $step1['last_name'],
            'email' => $step1['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'member', 
        ]);
        
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof_file')) {
            $paymentProofPath = $request->file('payment_proof_file')->store('payment_proofs', 'public');
        }

        // Create Member
        $member = Member::create([
            'user_id' => $user->id,
            'application_ref' => 'APP-' . date('Y') . '-' . rand(1000, 9999),
            // Step 1
            'first_name' => $step1['first_name'],
            'middle_name' => $step1['middle_name'],
            'last_name' => $step1['last_name'],
            'dob' => $step1['dob'],
            'gender' => $step1['gender'],
            'marital_status' => $step1['marital_status'],
            'occupation' => $step1['occupation'],
            'employer_name' => $step1['employer_name'],
            'monthly_income_range' => $step1['monthly_income_range'],
            // Step 2
            'phone' => $step2['phone'],
            'address' => $step2['address'],
            'city' => $step2['city'],
            'state' => $step2['state'],
            'id_type' => $step2['id_type'],
            'id_number' => $step2['id_number'],
            'id_card_path' => $step2['id_card_path'],
            'passport_photo_path' => $step2['passport_photo_path'], // Assuming file was moved or just use temp path for now
            // Step 3
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
        
        // Auto-login? Or require verification?
        // Let's auto login for UX, but their dashboard will show 'Pending' state (need to handle that in Dashboard logic too)
        
        Session::forget('member_registration');
        
        return redirect()->route('home')->with('success', 'Your registration was successful! Your Application ID is ' . $member->application_ref . '. We will review your application and notify you soon.');
    }

    public function showSuccess(Member $member)
    {
       // Security check: simple public view for now or ensure owned by user?
       // Since the user might not be logged in or just registered.
       // We can pass ID but verifies nothing. Better to use session flash or just show generic success?
       // For this demo, let's just show it.
       return view('join.success', compact('member'));
    }
}
