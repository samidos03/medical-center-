<?php
// app/Models/Patient.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'birth_date',
        'gender',
        'blood_type',
        'allergies',
        'medical_conditions',
        'emergency_contact',
        'emergency_phone',
    ];

    protected function casts(): array
    {
        return ['birth_date' => 'date'];
    }

    public function user()          { return $this->belongsTo(User::class); }
    public function rendezvous()    { return $this->hasMany(Rendezvous::class); }
    public function consultations() { return $this->hasMany(Consultation::class); }
}