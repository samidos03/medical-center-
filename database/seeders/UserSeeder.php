<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@cabinet.ma',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'actif'    => true,
            'phone'    => '0522000001',
            'address'  => 'Bahjawa Medical Center, Marrakech',
        ]);

        User::create([
            'name'     => 'Dr. Youssef Alaoui',
            'email'    => 'medecin1@cabinet.ma',
            'password' => Hash::make('password'),
            'role'     => 'medecin',
            'actif'    => true,
            'phone'    => '0522000002',
            'address'  => 'Marrakech',
        ]);

        User::create([
            'name'     => 'Dr. Fatima Benali',
            'email'    => 'medecin2@cabinet.ma',
            'password' => Hash::make('password'),
            'role'     => 'medecin',
            'actif'    => true,
            'phone'    => '0522000003',
            'address'  => 'Marrakech',
        ]);

        User::create([
            'name'     => 'Dr. Karim Tazi',
            'email'    => 'medecin3@cabinet.ma',
            'password' => Hash::make('password'),
            'role'     => 'medecin',
            'actif'    => true,
            'phone'    => '0522000004',
            'address'  => 'Marrakech',
        ]);

        User::create([
            'name'     => 'Sara Bennani',
            'email'    => 'secretaire@cabinet.ma',
            'password' => Hash::make('password'),
            'role'     => 'secretaire',
            'actif'    => true,
            'phone'    => '0522000005',
            'address'  => 'Marrakech',
        ]);

        User::create([
            'name'     => 'Mohamed Khalil',
            'email'    => 'patient1@cabinet.ma',
            'password' => Hash::make('password'),
            'role'     => 'patient',
            'actif'    => true,
            'phone'    => '0600000001',
            'address'  => 'Gueliz, Marrakech',
        ]);

        User::create([
            'name'     => 'Fatima Zahra',
            'email'    => 'patient2@cabinet.ma',
            'password' => Hash::make('password'),
            'role'     => 'patient',
            'actif'    => true,
            'phone'    => '0600000002',
            'address'  => 'Hivernage, Marrakech',
        ]);

        User::create([
            'name'     => 'Hassan Berrada',
            'email'    => 'patient3@cabinet.ma',
            'password' => Hash::make('password'),
            'role'     => 'patient',
            'actif'    => true,
            'phone'    => '0600000003',
            'address'  => 'Medina, Marrakech',
        ]);

        User::create([
            'name'     => 'Zineb Moussaoui',
            'email'    => 'patient4@cabinet.ma',
            'password' => Hash::make('password'),
            'role'     => 'patient',
            'actif'    => true,
            'phone'    => '0600000004',
            'address'  => 'Menara, Marrakech',
        ]);

        User::create([
            'name'     => 'Omar Lahlou',
            'email'    => 'patient5@cabinet.ma',
            'password' => Hash::make('password'),
            'role'     => 'patient',
            'actif'    => true,
            'phone'    => '0600000005',
            'address'  => 'Targa, Marrakech',
        ]);
    }
}
