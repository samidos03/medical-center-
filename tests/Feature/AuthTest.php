<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_admin_can_login(): void
    {
        $user = User::factory()->create([
            'email'    => 'admin@test.ma',
            'password' => bcrypt('password'),
            'role'     => 'admin',
            'actif'    => true,
        ]);
        $response = $this->post('/login', [
            'email'    => 'admin@test.ma',
            'password' => 'password',
        ]);
        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_medecin_can_login(): void
    {
        $user = User::factory()->create([
            'email'    => 'medecin@test.ma',
            'password' => bcrypt('password'),
            'role'     => 'medecin',
            'actif'    => true,
        ]);
        $response = $this->post('/login', [
            'email'    => 'medecin@test.ma',
            'password' => 'password',
        ]);
        $response->assertRedirect('/medecin/dashboard');
    }

    public function test_patient_can_login(): void
    {
        $user = User::factory()->create([
            'email'    => 'patient@test.ma',
            'password' => bcrypt('password'),
            'role'     => 'patient',
            'actif'    => true,
        ]);
        $response = $this->post('/login', [
            'email'    => 'patient@test.ma',
            'password' => 'password',
        ]);
        $response->assertRedirect('/patient/dashboard');
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email'    => 'user@test.ma',
            'password' => bcrypt('password'),
            'role'     => 'patient',
            'actif'    => true,
        ]);
        $response = $this->post('/login', [
            'email'    => 'user@test.ma',
            'password' => 'wrongpassword',
        ]);
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create([
            'role'  => 'admin',
            'actif' => true,
        ]);
        $this->actingAs($user);
        $response = $this->post('/logout');
        $response->assertRedirect();
        $this->assertGuest();
    }

    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_register_page_is_accessible(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Test User',
            'email'                 => 'newuser@test.ma',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'patient',
        ]);
        $this->assertDatabaseHas('users', ['email' => 'newuser@test.ma']);
    }
}
