<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can access user management page
     */
    public function test_admin_can_access_user_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
    }

    /**
     * Test staff cannot access user management page
     */
    public function test_staff_cannot_access_user_management(): void
    {
        $staff = User::factory()->create([
            'role' => 'staff',
            'is_active' => true,
        ]);

        $response = $this->actingAs($staff)->get('/admin/users');

        $response->assertStatus(403);
    }

    /**
     * Test regular user cannot access admin panel
     */
    public function test_regular_user_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    /**
     * Test public registration creates user with 'user' role only
     */
    public function test_public_registration_creates_user_role_only(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'SecureP@ss123!XyZ',
            'password_confirmation' => 'SecureP@ss123!XyZ',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'role' => 'user', // Must be 'user', not 'admin' or 'staff'
        ]);

        // Verify cannot be admin or staff
        $this->assertDatabaseMissing('users', [
            'email' => 'testuser@example.com',
            'role' => 'admin',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'testuser@example.com',
            'role' => 'staff',
        ]);
    }

    /**
     * Test admin can create staff account
     */
    public function test_admin_can_create_staff_account(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Simulate creating a staff user through admin panel
        $staffData = [
            'name' => 'New Staff',
            'email' => 'staff@example.com',
            'password' => 'StaffP@ss123!',
            'role' => 'staff',
            'is_active' => true,
        ];

        $this->actingAs($admin);

        User::create([
            'name' => $staffData['name'],
            'email' => $staffData['email'],
            'password' => bcrypt($staffData['password']),
            'role' => $staffData['role'],
            'is_active' => $staffData['is_active'],
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'staff@example.com',
            'role' => 'staff',
        ]);
    }

    /**
     * Test staff can access admin dashboard
     */
    public function test_staff_can_access_admin_dashboard(): void
    {
        $staff = User::factory()->create([
            'role' => 'staff',
            'is_active' => true,
        ]);

        $response = $this->actingAs($staff)->get('/admin');

        $response->assertStatus(200);
    }

    /**
     * Test inactive admin cannot access admin panel
     */
    public function test_inactive_admin_cannot_access_panel(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(403);
    }
}
