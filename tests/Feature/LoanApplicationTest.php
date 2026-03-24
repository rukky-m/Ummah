<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;

class LoanApplicationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_member_can_apply_for_a_loan()
    {
        $user = User::factory()->create();
        $member = Member::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        // Step 1: Loan Details
        $response = $this->post(route('loans.apply.step1.store'), [
            'amount' => 500000,
            'purpose' => 'Business',
            'duration_months' => 12,
            'repayment_frequency' => 'monthly',
            'bank_name' => 'Test Bank',
            'account_number' => '1234567890',
            'account_name' => 'Test Account',
        ]);

        $response->assertRedirect(route('loans.apply.step2'));
        $this->assertEquals(500000, session('loan_application.step1.amount'));

        // Step 2: Guarantors
        $response = $this->post(route('loans.apply.step2.store'), [
            'guarantor_1_name' => 'Guarantor One',
            'guarantor_1_relationship' => 'Friend',
            'guarantor_1_phone' => '08011111111',
            'guarantor_1_passport' => \Illuminate\Http\UploadedFile::fake()->create('passport1.jpg', 100, 'image/jpeg'),
            'guarantor_2_name' => 'Guarantor Two',
            'guarantor_2_relationship' => 'Colleague',
            'guarantor_2_phone' => '08022222222',
            'guarantor_2_passport' => \Illuminate\Http\UploadedFile::fake()->create('passport2.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('loans.apply.step3'));
        $this->assertEquals('Guarantor One', session('loan_application.step2.guarantor_1_name'));

        // Step 3: Narration & Submission
        $response = $this->post(route('loans.apply.step3.store'), [
            'narration' => 'I need this loan to expand my tailoring business to a new location.',
        ]);

        $response->assertRedirect(); // Should redirect to success
        
        $this->assertDatabaseHas('loans', [
            'member_id' => $member->id,
            'amount' => 500000,
            'purpose' => 'Business',
            'interest_rate' => 10,
            'total_repayment' => 550000,
        ]);

        $this->assertDatabaseHas('loan_guarantors', ['name' => 'Guarantor One']);
        $this->assertFalse(Session::has('loan_application'));
    }
}
