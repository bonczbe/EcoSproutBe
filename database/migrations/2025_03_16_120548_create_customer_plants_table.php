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
        Schema::create('customer_plants', function (Blueprint $table) {
            $table->id();
            $table->string('dirt_type')->default('mid');
            $table->string('pot_size')->default('mid');
            $table->string('name');
            $table->string('plant_img')->nullable();
            $table->foreignId('device_id')->constrained()->onDelete('cascade');
            $table->foreignId('plant_id')->constrained()->onDelete('cascade');
            $table->foreignId('plant_type_id')->nullable()->constrained('plant_types')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_plants');
    }
};
