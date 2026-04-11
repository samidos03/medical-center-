<?php
namespace Tests\Unit;
use App\Models\Consultation;
use App\Models\Medecin;
use App\Models\Ordonnance;
use App\Models\Patient;
use App\Models\Rendezvous;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_correct_role(): void
    {
        $user = User::factory()->create(['role' => 'admin', 'actif' => true]);
        $this->assertEquals('admin', $user->role);
    }

    public function test_patient_model_relations(): void
    {
        $user = User::factory()->create(['role' => 'patient', 'actif' => true]);
        $patient = Patient::create([
            'user_id'    => $user->id,
            'birth_date' => '1990-01-01',
            'gender'     => 'M',
            'blood_type' => 'A+',
        ]);
        $this->assertInstanceOf(User::class, $patient->user);
    }

    public function test_medecin_model_relations(): void
    {
        $spec = Specialite::create(['nom' => 'Pediatrie']);
        $user = User::factory()->create(['role' => 'medecin', 'actif' => true]);
        $medecin = Medecin::create([
            'user_id'       => $user->id,
            'specialite_id' => $spec->id,
            'telephone'     => '0611111111',
        ]);
        $this->assertInstanceOf(User::class, $medecin->user);
        $this->assertInstanceOf(Specialite::class, $medecin->specialite);
    }

    public function test_rendezvous_statut_values(): void
    {
        $spec = Specialite::create(['nom' => 'Test']);
        $mUser = User::factory()->create(['role' => 'medecin', 'actif' => true]);
        $medecin = Medecin::create(['user_id' => $mUser->id, 'specialite_id' => $spec->id, 'telephone' => '0600']);
        $pUser = User::factory()->create(['role' => 'patient', 'actif' => true]);
        $patient = Patient::create(['user_id' => $pUser->id, 'birth_date' => '1990-01-01', 'gender' => 'M', 'blood_type' => 'O+']);
        $rdv = Rendezvous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_rdv'   => now()->addDays(1)->format('Y-m-d'),
            'heure_rdv'  => '09:00:00',
            'statut'     => 'en_attente',
        ]);
        $this->assertContains($rdv->statut, ['en_attente', 'confirme', 'annule']);
    }

    public function test_ordonnance_belongs_to_consultation(): void
    {
        $spec = Specialite::create(['nom' => 'Test']);
        $mUser = User::factory()->create(['role' => 'medecin', 'actif' => true]);
        $medecin = Medecin::create(['user_id' => $mUser->id, 'specialite_id' => $spec->id, 'telephone' => '0600']);
        $pUser = User::factory()->create(['role' => 'patient', 'actif' => true]);
        $patient = Patient::create(['user_id' => $pUser->id, 'birth_date' => '1990-01-01', 'gender' => 'F', 'blood_type' => 'B+']);
        $rdv = Rendezvous::create(['patient_id' => $patient->id, 'medecin_id' => $medecin->id, 'date_rdv' => now()->format('Y-m-d'), 'heure_rdv' => '10:00:00', 'statut' => 'confirme']);
        $consultation = Consultation::create(['patient_id' => $patient->id, 'medecin_id' => $medecin->id, 'rendez_vous_id' => $rdv->id, 'date_consultation' => now()->format('Y-m-d'), 'compte_rendu' => 'Test.']);
        $ordonnance = Ordonnance::create(['consultation_id' => $consultation->id, 'contenu' => 'Test prescription.', 'date_creation' => now()->format('Y-m-d')]);
        $this->assertEquals($consultation->id, $ordonnance->consultation->id);
    }
}
