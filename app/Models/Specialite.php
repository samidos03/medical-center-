<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Specialite extends Model
{
    protected $fillable = ['nom'];
    public function medecins() { return $this->hasMany(Medecin::class); }
}
