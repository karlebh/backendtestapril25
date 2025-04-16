<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_expenses_are_retrieved(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $expenses = Expense::factory()->count(3)
            ->for($user)->for($company)
            ->create();

        $token = $user->createToken('API Token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(route('expenses.index'));

        $response->assertStatus(200);
    }

    public function test_an_expense_can_be_created_by_users(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create();

        $token = $user->createToken('API Token')->plainTextToken;

        $expenseData = [
            'company_id' => $company->id,
            'title' => 'Test Expense',
            'amount' => 100.00,
            'category' => 'Test Category',
            'description' => 'Test Description',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post(route('expenses.store'), $expenseData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('expenses', $expenseData);
    }

    public function test_managers_and_admins_can_also_create_expense(): void {}
    public function test_only_managers_and_admins_can_update_expense(): void {}
    public function test_only_managers_and_admins_can_delete_expense(): void {}
    public function test_weekly_report_is_sent_to_admins(): void {}
}
