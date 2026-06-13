<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_user_can_login_with_login_id(): void
    {
        $user = $this->makeUser('admin', false);

        $response = $this->postJson('/api/v1/auth/login', [
            'login_id' => $user->login_id,
            'password' => 'Password123!',
            'device_name' => 'PHPUnit',
        ]);

        $response->assertOk()->assertJsonStructure(['access_token', 'token_type', 'must_change_password', 'user']);
        $this->assertDatabaseCount('personal_access_tokens', 1);
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = $this->makeUser('member', false, 'inactive');
        $this->postJson('/api/v1/auth/login', [
            'login_id' => $user->login_id, 'password' => 'Password123!', 'device_name' => 'PHPUnit',
        ])->assertForbidden();
    }

    public function test_temporary_password_blocks_application_endpoints(): void
    {
        $user = $this->makeUser('admin', true);
        $token = $user->createToken('PHPUnit')->plainTextToken;

        $this->withToken($token)->getJson('/api/v1/admin/dashboard')
            ->assertForbidden()->assertJson(['must_change_password' => true]);
    }

    public function test_member_cannot_access_admin_api(): void
    {
        $user = $this->makeUser('member', false);
        $token = $user->createToken('PHPUnit')->plainTextToken;
        $this->withToken($token)->getJson('/api/v1/admin/dashboard')->assertForbidden();
    }

    private function makeUser(string $roleName, bool $mustChange, string $status = 'active'): User
    {
        $role = Role::create(['name' => $roleName, 'display_name' => ucfirst($roleName)]);
        return User::create([
            'role_id' => $role->id,
            'login_id' => strtoupper($roleName).'-001',
            'name' => 'API Test User',
            'email' => $roleName.'@example.test',
            'password' => Hash::make('Password123!'),
            'must_change_password' => $mustChange,
            'status' => $status,
        ]);
    }
}
