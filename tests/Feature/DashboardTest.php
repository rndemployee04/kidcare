<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get('/parent/dashboard')->assertRedirect('/login');
    }

    public function test_authenticated_users_can_visit_the_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'parent',
            'registration_complete' => true,
            'verification_status' => 'approved',
        ]);
        $this->actingAs($user);
        $this->get('/parent/dashboard')->assertStatus(200);
    }
}
