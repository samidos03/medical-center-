<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rendezvouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('medecins')->onDelete('cascade');
            $table->date('date_rdv');
            $table->time('heure_rdv');
            $table->string('statut')->default('en_attente'); // en_attente, confirme, annule, termine
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rendezvouses');
    }
};