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
        Schema::create('ecash_donations', function (Blueprint $table) {
            $table->bigIncrements('donationID'); 
            $table->string('fullname');         
            $table->unsignedBigInteger('contactno');      
            $table->unsignedInteger('donationMode');
            $table->string('proof_of_donation');
            $table->tinyInteger('isPickUp')->unsigned();
            $table->timestamps();             
    
            // Adding the foreign key constraint
            $table->foreign('donationMode')->references('id')->on('donation_mode')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
