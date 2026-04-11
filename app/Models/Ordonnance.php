<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    protected $fillable = [
        'consultation_id',
        'contenu',
        'date_creation',
    ];

    // Relations
    public function consultation() { return $this->belongsTo(Consultation::class); }
}