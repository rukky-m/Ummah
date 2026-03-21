<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\FinanceService;
use App\Models\Member;
use App\Models\Saving;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinanceServiceTest extends TestCase
{
    use RefreshDatabase;

    protected FinanceService $financeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->financeService = new FinanceService();
    }

    /** @test */
    public function it_calculates_correct_interest_rate_for_emergency_purpose()
    {
        $rate = $this->financeService->calculateInterestRate('Emergency');
        $this->assertEquals(6.0, $rate);

        $rate = $this->financeService->calculateInterestRate('Essential Commodity');
        $this->assertEquals(6.0, $rate);
    }

    /** @test */
    public function it_calculates_correct_interest_rate_for_other_purposes()
    {
        $rate = $this->financeService->calculateInterestRate('Business');
        $this->assertEquals(10.0, $rate);
    }

    /** @test */
    public function it_calculates_total_repayment_correctly()
    {
        $total = $this->financeService->calculateTotalRepayment(100000, 10);
        $this->assertEquals(110000, $total);

        $total = $this->financeService->calculateTotalRepayment(100000, 6);
        $this->assertEquals(106000, $total);
    }

    /** @test */
    public function it_calculates_correct_savings_balance_for_a_member()
    {
        $member = Member::factory()->create();

        // Approved deposits
        Saving::create([
            'member_id' => $member->id,
            'amount' => 50000,
            'category' => 'Personal Savings',
            'type' => 'deposit',
            'status' => 'approved',
            'transaction_date' => now(),
        ]);

        Saving::create([
            'member_id' => $member->id,
            'amount' => 25000,
            'category' => 'Personal Savings',
            'type' => 'deposit',
            'status' => 'approved',
            'transaction_date' => now(),
        ]);

        // Approved withdrawal
        Saving::create([
            'member_id' => $member->id,
            'amount' => 10000,
            'category' => 'Personal Savings',
            'type' => 'withdrawal',
            'status' => 'approved',
            'transaction_date' => now(),
        ]);

        $balance = $this->financeService->getMemberSavingsBalance($member);
        $this->assertEquals(65000, $balance);
    }

    /** @test */
    public function it_calculates_total_contributions_correctly()
    {
        $member = Member::factory()->create();

        Saving::create([
            'member_id' => $member->id,
            'amount' => 5000,
            'category' => 'Contribution',
            'type' => 'deposit',
            'status' => 'approved',
            'transaction_date' => now(),
        ]);

        Saving::create([
            'member_id' => $member->id,
            'amount' => 5000,
            'category' => 'Contribution',
            'type' => 'deposit',
            'status' => 'approved',
            'transaction_date' => now(),
        ]);

        $contributions = $this->financeService->getMemberTotalContributions($member);
        $this->assertEquals(10000, $contributions);
    }

    /** @test */
    public function it_calculates_global_savings_balance_correctly()
    {
        $member1 = Member::factory()->create();
        $member2 = Member::factory()->create();

        Saving::create(['member_id' => $member1->id, 'amount' => 1000, 'category' => 'Personal Savings', 'type' => 'deposit', 'status' => 'approved', 'transaction_date' => now()]);
        Saving::create(['member_id' => $member2->id, 'amount' => 2000, 'category' => 'Personal Savings', 'type' => 'deposit', 'status' => 'approved', 'transaction_date' => now()]);
        Saving::create(['member_id' => $member1->id, 'amount' => 500, 'category' => 'Personal Savings', 'type' => 'withdrawal', 'status' => 'approved', 'transaction_date' => now()]);

        $this->assertEquals(2500, $this->financeService->getGlobalSavingsBalance());
    }

    /** @test */
    public function it_calculates_global_total_contributions_correctly()
    {
        $member1 = Member::factory()->create();
        Saving::create(['member_id' => $member1->id, 'amount' => 5000, 'category' => 'Contribution', 'type' => 'deposit', 'status' => 'approved', 'transaction_date' => now()]);
        Saving::create(['member_id' => $member1->id, 'amount' => 5000, 'category' => 'Contribution', 'type' => 'deposit', 'status' => 'approved', 'transaction_date' => now()]);

        $this->assertEquals(10000, $this->financeService->getGlobalTotalContributions());
    }
}
