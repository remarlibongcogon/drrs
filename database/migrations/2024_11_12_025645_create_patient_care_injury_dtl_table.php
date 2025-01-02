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
        Schema::create('patient_care_injury_dtl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patientCareID');
            $table->unsignedBigInteger('vehicular');
            $table->boolean('fall');
            $table->boolean('cut');
            $table->string('broken');
            $table->boolean('gunshot');
            $table->boolean('drowning');
            $table->boolean('electrocuted');
            $table->boolean('suicide');
            $table->boolean('burns');

            $table->foreign('patientCareID')->references('patientCareID')->on('patient_care_reports')->onDelete('cascade');
            $table->foreign('vehicular')->references('id')->on('vehicular_accident_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_care_injury_dtl');
    }
};
