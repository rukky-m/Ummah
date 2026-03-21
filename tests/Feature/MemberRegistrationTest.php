<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MemberRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_complete_registration_wizard()
    {
        Storage::fake('public');

        // Step 1: Personal Info
        $response = $this->post(route('join.step1.store'), [
            'first_name' => 'John',
            'middle_name' => 'M',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'dob' => '1990-01-01',
            'gender' => 'Male',
            'marital_status' => 'Single',
            'occupation' => 'Developer',
            'employer_name' => 'Tech Corp',
            'monthly_income_range' => '100k - 200k',
        ]);

        $response->assertRedirect(route('join.step2'));
        $this->assertEquals('John', session('member_registration.step1.first_name'));

        // Step 2: Contact & Identification
        $response = $this->post(route('join.step2.store'), [
            'phone' => '08012345678',
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'AnyState',
            'id_type' => 'National ID',
            'id_number' => '1234567890',
            'id_card_file' => UploadedFile::fake()->create('id.jpg', 100),
            'passport_photo_file' => UploadedFile::fake()->create('passport.jpg', 100),
        ]);

        $response->assertRedirect(route('join.step3'));
        $this->assertEquals('08012345678', session('member_registration.step2.phone'));

        // Step 3: Next of Kin & Final Submission
        $response = $this->post(route('join.step3.store'), [
            'next_of_kin_name' => 'Jane Doe',
            'next_of_kin_phone' => '08087654321',
            'nok_relationship' => 'Sister',
            'emergency_contact_name' => 'Emergency Contact',
            'emergency_contact_phone' => '08011122233',
            'payment_method' => 'Cash',
            'bank_name' => 'Test Bank',
            'account_number' => '0123456789',
            'account_name' => 'John Doe',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
        $this->assertDatabaseHas('members', ['first_name' => 'John', 'phone' => '08012345678']);
    }
}
