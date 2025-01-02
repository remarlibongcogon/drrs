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
        Schema::create('hazards', function (Blueprint $table) {
            $table->id('hazardID');
            $table->string('hazardName');
            $table->unsignedBigInteger('hazardStatus');
            $table->string('coordinates'); // Store coordinates as JSON
            $table->timestamps();

            $table->foreign('hazardStatus')->references('id')->on('hazard_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danger_zones');
    }
};
