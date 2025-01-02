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
        Schema::create('patient_care_spot_stroke', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patientCareID');
            $table->boolean('B');
            $table->boolean('F');
            $table->boolean('A');
            $table->boolean('S');
            $table->string('T');
            
            $table->foreign('patientCareID')->references('patientCareID')->on('patient_care_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_care_spot_stroke');
    }
};
