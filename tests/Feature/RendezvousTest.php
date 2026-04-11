<?php
namespace Tests\Feature;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Rendezvous;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RendezvousTest extends TestCase
{
    use RefreshDatabase;

    private function createMedecin(): array
    {
        $spec = Specialite::create(['nom' => 'Cardiologie']);
        $user = User::factory()->create(['role' => 'medecin', 'actif' => true]);
        $medecin = Medecin::create([
            'user_id'      => $user->id,
            'specialite_id'=> $spec->id,
            'telephone'    => '0600000000',
        ]);
        return [$user, $medecin];
    }

    private function createPatient(): array
    {
        $user = User::factory()->create(['role' => 'patient', 'actif' => true]);
        $patient = Patient::create([
            'user_id'    => $user->id,
            'birth_date' => '1990-01-01',
            'gender'     => 'M',
            'blood_type' => 'A+',
        ]);
        return [$user, $patient];
    }

    public function test_rendezvous_can_be_created(): void
    {
        [$mUser, $medecin] = $this->createMedecin();
        [$pUser, $patient] = $this->createPatient();
        $rdv = Rendezvous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_rdv'   => now()->addDays(2)->format('Y-m-d'),
            'heure_rdv'  => '09:00:00',
            'statut'     => 'en_attente',
        ]);
        $this->assertDatabaseHas('rendezvouses', [
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'statut'     => 'en_attente',
        ]);
    }

    public function test_rendezvous_statut_can_be_confirmed(): void
    {
        [$mUser, $medecin] = $this->createMedecin();
        [$pUser, $patient] = $this->createPatient();
        $rdv = Rendezvous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_rdv'   => now()->addDays(2)->format('Y-m-d'),
            'heure_rdv'  => '09:00:00',
            'statut'     => 'en_attente',
        ]);
        $rdv->update(['statut' => 'confirme']);
        $this->assertEquals('confirme', $rdv->fresh()->statut);
    }

    public function test_rendezvous_statut_can_be_cancelled(): void
    {
        [$mUser, $medecin] = $this->createMedecin();
        [$pUser, $patient] = $this->createPatient();
        $rdv = Rendezvous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_rdv'   => now()->addDays(2)->format('Y-m-d'),
            'heure_rdv'  => '09:00:00',
            'statut'     => 'en_attente',
        ]);
        $rdv->update(['statut' => 'annule']);
        $this->assertEquals('annule', $rdv->fresh()->statut);
    }

    public function test_admin_can_update_rendezvous_statut(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'actif' => true]);
        [$mUser, $medecin] = $this->createMedecin();
        [$pUser, $patient] = $this->createPatient();
        $rdv = Rendezvous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_rdv'   => now()->addDays(2)->format('Y-m-d'),
            'heure_rdv'  => '10:00:00',
            'statut'     => 'en_attente',
        ]);
        $response = $this->actingAs($admin)
            ->patch('/admin/rendezvous/' . $rdv->id . '/statut', ['statut' => 'confirme']);
        $response->assertRedirect();
        $this->assertEquals('confirme', $rdv->fresh()->statut);
    }

    public function test_patient_can_book_rendezvous(): void
    {
        [$mUser, $medecin] = $this->createMedecin();
        [$pUser, $patient] = $this->createPatient();
        $response = $this->actingAs($pUser)->post('/patient/rendezvous', [
            'medecin_id' => $medecin->id,
            'date_rdv'   => now()->addDays(3)->format('Y-m-d'),
            'heure_rdv'  => '11:00',
        ]);
        $this->assertDatabaseHas('rendezvouses', [
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'statut'     => 'en_attente',
        ]);
    }

    public function test_patient_can_cancel_rendezvous(): void
    {
        [$mUser, $medecin] = $this->createMedecin();
        [$pUser, $patient] = $this->createPatient();
        $rdv = Rendezvous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_rdv'   => now()->addDays(2)->format('Y-m-d'),
            'heure_rdv'  => '09:00:00',
            'statut'     => 'en_attente',
        ]);
        $response = $this->actingAs($pUser)
            ->patch('/patient/rendezvous/' . $rdv->id . '/annuler');
        $this->assertEquals('annule', $rdv->fresh()->statut);
    }

    public function test_rendezvous_belongs_to_patient_and_medecin(): void
    {
        [$mUser, $medecin] = $this->createMedecin();
        [$pUser, $patient] = $this->createPatient();
        $rdv = Rendezvous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_rdv'   => now()->addDays(2)->format('Y-m-d'),
            'heure_rdv'  => '09:00:00',
            'statut'     => 'en_attente',
        ]);
        $this->assertEquals($patient->id, $rdv->patient->id);
        $this->assertEquals($medecin->id, $rdv->medecin->id);
    }
}

