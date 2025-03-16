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
        Schema::create('weather', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->date('date');
            $table->decimal('max_celsius', 5, 2);
            $table->decimal('min_celsius', 5, 2);
            $table->boolean('cloudy')->default(false);
            $table->boolean('rainy')->default(false);
            $table->decimal('expected_maximum_rain', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather');
    }
};
