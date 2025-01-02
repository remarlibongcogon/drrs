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
        Schema::create('patient_care_dcap_blts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patientCareID');
            $table->boolean('D');
            $table->boolean('C');
            $table->boolean('A');
            $table->boolean('P');
            $table->boolean('B');
            $table->boolean('L');
            $table->boolean('T');
            $table->boolean('S');

            $table->foreign('patientCareID')->references('patientCareID')->on('patient_care_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dcap_blts');
    }
};
