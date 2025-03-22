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
            $table->decimal('average_celsius', 5, 2);
            $table->integer('uv');
            $table->integer('rain_chance');
            $table->integer('snow_chance');
            $table->decimal('expected_maximum_rain', 5, 2)->nullable();
            $table->decimal('expected_maximum_snow', 5, 2)->nullable();
            $table->decimal('expected_maximum_rain_tomorrow', 5, 2)->nullable();
            $table->decimal('expected_maximum_snow_tomorrow', 5, 2)->nullable();
            $table->json('condition');
            $table->json('astro');
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
