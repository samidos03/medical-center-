<?php
namespace Tests\Feature;
use App\Models\Consultation;
use App\Models\Medecin;
use App\Models\Ordonnance;
use App\Models\Patient;
use App\Models\Rendezvous;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultationTest extends TestCase
{
    use RefreshDatabase;

    private function setup_data(): array
    {
        $spec = Specialite::create(['nom' => 'Generale']);
        $mUser = User::factory()->create(['role' => 'medecin', 'actif' => true]);
        $medecin = Medecin::create([
            'user_id'       => $mUser->id,
            'specialite_id' => $spec->id,
            'telephone'     => '0600000000',
        ]);
        $pUser = User::factory()->create(['role' => 'patient', 'actif' => true]);
        $patient = Patient::create([
            'user_id'    => $pUser->id,
            'birth_date' => '1985-06-15',
            'gender'     => 'F',
            'blood_type' => 'B+',
        ]);
        $rdv = Rendezvous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_rdv'   => now()->format('Y-m-d'),
            'heure_rdv'  => '10:00:00',
            'statut'     => 'confirme',
        ]);
        return [$mUser, $medecin, $pUser, $patient, $rdv];
    }

    public function test_consultation_can_be_created(): void
    {
        [$mUser, $medecin, $pUser, $patient, $rdv] = $this->setup_data();
        $consultation = Consultation::create([
            'patient_id'        => $patient->id,
            'medecin_id'        => $medecin->id,
            'rendez_vous_id'    => $rdv->id,
            'date_consultation' => now()->format('Y-m-d'),
            'compte_rendu'      => 'Patient presents with mild fever and cough.',
        ]);
        $this->assertDatabaseHas('consultations', [
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
        ]);
    }

    public function test_ordonnance_can_be_created_with_consultation(): void
    {
        [$mUser, $medecin, $pUser, $patient, $rdv] = $this->setup_data();
        $consultation = Consultation::create([
            'patient_id'        => $patient->id,
            'medecin_id'        => $medecin->id,
            'rendez_vous_id'    => $rdv->id,
            'date_consultation' => now()->format('Y-m-d'),
            'compte_rendu'      => 'Routine checkup completed successfully.',
        ]);
        $ordonnance = Ordonnance::create([
            'consultation_id' => $consultation->id,
            'contenu'         => 'Paracetamol 500mg - 3 times daily for 5 days.',
            'date_creation'   => now()->format('Y-m-d'),
        ]);
        $this->assertDatabaseHas('ordonnances', [
            'consultation_id' => $consultation->id,
        ]);
        $this->assertNotNull($consultation->ordonnance);
    }

    public function test_medecin_can_create_consultation(): void
    {
        [$mUser, $medecin, $pUser, $patient, $rdv] = $this->setup_data();
        $response = $this->actingAs($mUser)->post('/medecin/consultations', [
            'rendez_vous_id'     => $rdv->id,
            'compte_rendu'       => 'Patient in good health overall.',
            'contenu_ordonnance' => 'Vitamin C 1000mg daily.',
        ]);
        $response->assertRedirect('/medecin/consultations');
        $this->assertDatabaseHas('consultations', [
            'medecin_id' => $medecin->id,
        ]);
    }

    public function test_medecin_can_view_consultation(): void
    {
        [$mUser, $medecin, $pUser, $patient, $rdv] = $this->setup_data();
        $consultation = Consultation::create([
            'patient_id'        => $patient->id,
            'medecin_id'        => $medecin->id,
            'rendez_vous_id'    => $rdv->id,
            'date_consultation' => now()->format('Y-m-d'),
            'compte_rendu'      => 'Follow-up visit completed.',
        ]);
        $response = $this->actingAs($mUser)->get('/medecin/consultations/' . $consultation->id);
        $response->assertStatus(200);
    }

    public function test_consultation_belongs_to_patient(): void
    {
        [$mUser, $medecin, $pUser, $patient, $rdv] = $this->setup_data();
        $consultation = Consultation::create([
            'patient_id'        => $patient->id,
            'medecin_id'        => $medecin->id,
            'rendez_vous_id'    => $rdv->id,
            'date_consultation' => now()->format('Y-m-d'),
            'compte_rendu'      => 'Annual check completed.',
        ]);
        $this->assertEquals($patient->id, $consultation->patient->id);
        $this->assertEquals($medecin->id, $consultation->medecin->id);
    }

    public function test_ordonnance_pdf_is_downloadable(): void
    {
        [$mUser, $medecin, $pUser, $patient, $rdv] = $this->setup_data();
        $medecin->load(['user','specialite']);
        $consultation = Consultation::create([
            'patient_id'        => $patient->id,
            'medecin_id'        => $medecin->id,
            'rendez_vous_id'    => $rdv->id,
            'date_consultation' => now()->format('Y-m-d'),
            'compte_rendu'      => 'Test consultation for PDF.',
        ]);
        $ordonnance = Ordonnance::create([
            'consultation_id' => $consultation->id,
            'contenu'         => 'Amoxicillin 500mg - twice daily.',
            'date_creation'   => now()->format('Y-m-d'),
        ]);
        $response = $this->actingAs($mUser)
            ->get('/medecin/ordonnances/' . $ordonnance->id . '/pdf');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}

