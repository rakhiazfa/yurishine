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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('registrasion_number')->unique();
            $table->string('name');
            $table->unsignedInteger('age');
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->string('skin_type');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->boolean('is_smoked');
            $table->string('using_kb');
            $table->boolean('using_skincare');
            $table->boolean('already_use_mixed_cream');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
