<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table("disponibilites", function (Blueprint $table) {
            $table->foreignId("medecin_id")->constrained("medecins")->onDelete("cascade");
            $table->enum("jour", ["lundi","mardi","mercredi","jeudi","vendredi","samedi"]);
            $table->time("heure_debut");
            $table->time("heure_fin");
            $table->boolean("actif")->default(true);
        });
    }
    public function down(): void {
        Schema::table("disponibilites", function (Blueprint $table) {
            $table->dropColumn(["medecin_id","jour","heure_debut","heure_fin","actif"]);
        });
    }
};