<?php
namespace Database\Seeders;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'email'              => 'patient1@cabinet.ma',
                'birth_date'         => '1985-03-12',
                'gender'             => 'M',
                'blood_type'         => 'A+',
                'allergies'          => 'None',
                'medical_conditions' => 'None',
                'emergency_contact'  => 'Aicha Khalil',
                'emergency_phone'    => '0600100001',
            ],
            [
                'email'              => 'patient2@cabinet.ma',
                'birth_date'         => '1992-07-25',
                'gender'             => 'F',
                'blood_type'         => 'O+',
                'allergies'          => 'Penicillin',
                'medical_conditions' => 'Asthma',
                'emergency_contact'  => 'Ahmed Zahra',
                'emergency_phone'    => '0600100002',
            ],
            [
                'email'              => 'patient3@cabinet.ma',
                'birth_date'         => '1978-11-05',
                'gender'             => 'M',
                'blood_type'         => 'O+',
                'allergies'          => 'None',
                'medical_conditions' => 'Hypertension',
                'emergency_contact'  => 'Khadija Berrada',
                'emergency_phone'    => '0600100003',
            ],
            [
                'email'              => 'patient4@cabinet.ma',
                'birth_date'         => '2001-01-30',
                'gender'             => 'F',
                'blood_type'         => 'AB+',
                'allergies'          => 'None',
                'medical_conditions' => 'None',
                'emergency_contact'  => 'Youssef Moussaoui',
                'emergency_phone'    => '0600100004',
            ],
            [
                'email'              => 'patient5@cabinet.ma',
                'birth_date'         => '1965-09-18',
                'gender'             => 'M',
                'blood_type'         => 'A-',
                'allergies'          => 'Aspirin',
                'medical_conditions' => 'Diabetes type 2',
                'emergency_contact'  => 'Sara Lahlou',
                'emergency_phone'    => '0600100005',
            ],
        ];

        foreach ($patients as $data) {
            $user = User::where('email', $data['email'])->first();
            if ($user) {
                Patient::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'birth_date'         => $data['birth_date'],
                        'gender'             => $data['gender'],
                        'blood_type'         => $data['blood_type'],
                        'allergies'          => $data['allergies'],
                        'medical_conditions' => $data['medical_conditions'],
                        'emergency_contact'  => $data['emergency_contact'],
                        'emergency_phone'    => $data['emergency_phone'],
                    ]
                );
            }
        }
    }
}
