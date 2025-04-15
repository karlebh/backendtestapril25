<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_expenses_are_gotten(): void {}
    public function test_an_expense_can_be_created_by_users(): void {}
    public function test_managers_and_admins_can_also_create_expense(): void {}
    public function test_only_managers_and_admins_can_update_expense(): void {}
    public function test_only_managers_and_admins_can_delete_expense(): void {}
}
