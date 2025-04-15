<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_users_are_retrieved(): void {}
    public function test_only_admins_can_create_users(): void {}
    public function test_only_admins_can_change_user_role(): void {}
}
