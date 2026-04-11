<?php
namespace Database\Seeders;
use App\Models\Medecin;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Database\Seeder;
class MedecinSeeder extends Seeder
{
    public function run(): void
    {
        $specialites = [
            'Medecine generale',
            'Cardiologie',
            'Pediatrie',
            'Dermatologie',
            'Gynecologie',
            'Ophtalmologie',
            'Neurologie',
            'Orthopedie',
        ];

        foreach ($specialites as $nom) {
            Specialite::firstOrCreate(['nom' => $nom]);
        }

        $medecin1 = User::where('email','medecin1@cabinet.ma')->first();
        $medecin2 = User::where('email','medecin2@cabinet.ma')->first();
        $medecin3 = User::where('email','medecin3@cabinet.ma')->first();

        Medecin::create([
            'user_id'       => $medecin1->id,
            'specialite_id' => Specialite::where('nom','Medecine generale')->first()->id,
            'telephone'     => '0522100001',
        ]);

        Medecin::create([
            'user_id'       => $medecin2->id,
            'specialite_id' => Specialite::where('nom','Cardiologie')->first()->id,
            'telephone'     => '0522100002',
        ]);

        Medecin::create([
            'user_id'       => $medecin3->id,
            'specialite_id' => Specialite::where('nom','Pediatrie')->first()->id,
            'telephone'     => '0522100003',
        ]);
    }
}
