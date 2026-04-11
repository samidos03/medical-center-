<?php
namespace Tests\Feature;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create([
            'role'  => 'admin',
            'actif' => true,
        ]);
    }

    private function createPatientUser(): array
    {
        $user = User::factory()->create([
            'role'  => 'patient',
            'actif' => true,
        ]);
        $patient = Patient::create([
            'user_id'    => $user->id,
            'birth_date' => '1990-01-01',
            'gender'     => 'M',
            'blood_type' => 'A+',
        ]);
        return [$user, $patient];
    }

    public function test_admin_can_view_patients_list(): void
    {
        $admin = $this->createAdmin();
        [$user, $patient] = $this->createPatientUser();
        $response = $this->actingAs($admin)->get('/admin/patients');
        $response->assertStatus(200);
    }

    public function test_admin_can_view_patient_detail(): void
    {
        $admin = $this->createAdmin();
        [$user, $patient] = $this->createPatientUser();
        $response = $this->actingAs($admin)->get('/admin/patients/' . $patient->id);
        $response->assertStatus(200);
    }

    public function test_patient_has_correct_relations(): void
    {
        [$user, $patient] = $this->createPatientUser();
        $this->assertEquals($user->id, $patient->user->id);
        $this->assertEquals('A+', $patient->blood_type);
        $this->assertEquals('M', $patient->gender);
    }

    public function test_patient_cannot_access_admin_panel(): void
    {
        [$user, $patient] = $this->createPatientUser();
        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_secretaire_can_add_patient(): void
    {
        $sec = User::factory()->create(['role' => 'secretaire', 'actif' => true]);
        $response = $this->actingAs($sec)->post('/secretaire/patients', [
            'name'       => 'Nouveau Patient',
            'email'      => 'nouveau@test.ma',
            'password'   => 'password123',
            'birth_date' => '1995-05-15',
            'gender'     => 'F',
            'blood_type' => 'O+',
        ]);
        $this->assertDatabaseHas('users', ['email' => 'nouveau@test.ma']);
    }

    public function test_secretaire_can_delete_patient(): void
    {
        $sec = User::factory()->create(['role' => 'secretaire', 'actif' => true]);
        [$user, $patient] = $this->createPatientUser();
        $response = $this->actingAs($sec)->delete('/secretaire/patients/' . $patient->id);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}

