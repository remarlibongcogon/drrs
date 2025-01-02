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
        Schema::create('patient_care_reports', function (Blueprint $table) {
            $table->id('patientCareID');
            $table->string('patientName');
            $table->string('patientAddress');
            $table->integer('patientAge');
            $table->string('patientContactPerson');
            $table->string('contactNumber');
            $table->string('incidentDate');
            $table->string('incidentPlace');
            $table->unsignedTinyInteger('patientGender');
            $table->string('time');
            $table->unsignedBigInteger('case');
            $table->string('others');
            $table->tinyInteger('recordedBy');
            $table->string('recievedBy');
            $table->timestamps();

            $table->foreign('patientGender')->references('id')->on('gender')->onDelete('cascade');
            $table->foreign('case')->references('id')->on('patient_care_cases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_care_reports');
    }
};
