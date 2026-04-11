<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rendezvous extends Model
{
    protected $fillable = [
        'patient_id',
        'medecin_id',
        'date_rdv',
        'heure_rdv',
        'statut',
    ];

    // Relations
    public function patient()     { return $this->belongsTo(Patient::class); }
    public function medecin()     { return $this->belongsTo(Medecin::class); }
    public function consultation() { return $this->hasOne(Consultation::class, 'rendez_vous_id'); }

    // Helpers statut
    public function confirmer() { $this->update(['statut' => 'confirme']); }
    public function annuler()   { $this->update(['statut' => 'annule']); }
}