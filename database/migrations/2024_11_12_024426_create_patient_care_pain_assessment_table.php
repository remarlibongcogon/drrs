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
        Schema::create('patient_care_pain_assessment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patientCareID');
            $table->string('O');
            $table->string('P');
            $table->string('Q');
            $table->string('R');
            $table->string('S');
            $table->string('T');

            $table->foreign('patientCareID')->references('patientCareID')->on('patient_care_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_care_pain_assessment');
    }
};
