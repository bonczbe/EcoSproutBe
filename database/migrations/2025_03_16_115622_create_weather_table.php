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
            $table->string('time_zone');
            $table->timestamp('date');
            $table->decimal('max_celsius', 5, 2)->nullable();
            $table->decimal('min_celsius', 5, 2)->nullable();
            $table->decimal('average_celsius', 5, 2)->nullable();
            $table->integer('uv')->nullable();
            $table->integer('rain_chance')->nullable();
            $table->integer('snow_chance')->nullable();
            $table->decimal('expected_maximum_rain', 5, 2)->nullable();
            $table->decimal('expected_maximum_snow', 5, 2)->nullable();
            $table->decimal('expected_maximum_rain_tomorrow', 5, 2)->nullable();
            $table->decimal('expected_max_celsius', 5, 2)->nullable();
            $table->decimal('expected_min_celsius', 5, 2)->nullable();
            $table->decimal('expected_avgtemp_celsius', 5, 2)->nullable();
            $table->json('condition')->nullable();
            $table->json('astro')->nullable();
            $table->unique(['city', 'date'], 'city_date');
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
