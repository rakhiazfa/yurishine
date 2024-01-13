<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('patient_registrasion_number');
            $table->string('patient_name');
            $table->string('patient_address');
            $table->string('patient_phone');
            $table->unsignedBigInteger('doctor_id');
            $table->string('doctor_name');
            $table->string('polyclinic_name')->nullable();
            $table->string('description')->nullable();
            $table->json('treatments')->nullable();
            $table->json('skincares')->nullable();
            $table->date('inspection_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
