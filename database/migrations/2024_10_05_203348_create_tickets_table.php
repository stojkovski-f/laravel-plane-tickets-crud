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
      
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('passenger_name');
            $table->string('flight_id');
            $table->string('passport');
            $table->string('seat');
            $table->enum('status', ['active', 'canceled'])->default('active');
            $table->timestamps();

            $table->foreign('flight_id')->references('id')->on('flights');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
