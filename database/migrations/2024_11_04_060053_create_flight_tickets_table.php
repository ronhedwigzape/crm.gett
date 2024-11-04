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
        Schema::create('flight_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('airline_id')->constrained('airlines')->onDelete('cascade');
            $table->string('flight_number');
            $table->string('departure_airport');
            $table->string('arrival_airport');
            $table->date('departure_date');
            $table->decimal('amount', 10, 2);
            $table->date('arrival_date');
            $table->string('seat_class');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_tickets');
    }
};
