<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'patient_id',
        'medecin_id',
        'rendez_vous_id',
        'date_consultation',
        'compte_rendu',
    ];

    // Relations
    public function patient()    { return $this->belongsTo(Patient::class); }
    public function medecin()    { return $this->belongsTo(Medecin::class); }
    public function rendezvous() { return $this->belongsTo(Rendezvous::class, 'rendez_vous_id'); }
    public function ordonnance() { return $this->hasOne(Ordonnance::class); }
}