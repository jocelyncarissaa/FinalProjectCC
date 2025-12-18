<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * RefreshDatabase: Mengosongkan database testing sebelum setiap skenario dijalankan.
     * Ini memastikan "Test Fixture" selalu dalam kondisi bersih.
     */
    use RefreshDatabase;

    // =========================================================================
    // == BAGIAN 1: PENGUJIAN LOGIN (LOGIN TESTING)
    // =========================================================================

    /** @test */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Welcome Back');
    }

    /** @test */
    public function test_users_can_authenticate_and_redirect_to_home(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@pharma.com',
            'password' => Hash::make('password123'),
            'role' => 'user'
        ]);

        $response = $this->post('/login', [
            'email' => 'customer@pharma.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/home');
    }

    /** @test */
    public function test_admin_is_redirected_to_admin_dashboard_properly(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@pharma.com',
            'password' => Hash::make('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@pharma.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function test_user_cannot_login_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function test_login_requires_valid_email_format(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'bukan-format-email',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    // =========================================================================
    // == BAGIAN 2: PENGUJIAN REGISTRASI (REGISTER TESTING)
    // =========================================================================

    /** @test */
    public function test_register_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Get Started');
    }

    /** @test */
    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'user'
        ]);
        $response->assertRedirect('/home');
    }

    /** @test */
    public function test_registration_fails_if_password_does_not_meet_requirements(): void
    {
        // Berdasarkan controller Anda: minimal 6 karakter, harus ada huruf dan angka
        $response = $this->from('/register')->post('/register', [
            'name' => 'User Baru',
            'email' => 'newuser@example.com',
            'password' => '12345', // Kurang dari 6 & tidak ada huruf
            'password_confirmation' => '12345',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'newuser@example.com']);
    }

    /** @test */
    public function test_user_cannot_register_with_already_taken_email(): void
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'User Duplikat',
            'email' => 'duplicate@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    // =========================================================================
    // == BAGIAN 3: KEAMANAN & SESI (SECURITY & SESSION)
    // =========================================================================

    /** @test */
    public function test_session_is_regenerated_after_login_for_security(): void
    {
        $user = User::factory()->create();
        $oldSessionId = session()->getId();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Proteksi terhadap serangan Session Fixation
        $this->assertNotEquals($oldSessionId, session()->getId());
    }

    /** @test */
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}