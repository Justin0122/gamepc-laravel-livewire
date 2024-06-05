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
        Schema::create('gpus', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->foreignId('FKBrandId')->references('Id')->on('brands');
            $table->string('Memory');
            $table->foreignId('FKMemoryTypeId')->references('Id')->on('memorytypes');
            $table->integer('MemoryInterface');
            $table->integer('MemoryBandwidth');
            $table->integer('BaseClock');
            $table->integer('BoostClock');
            $table->integer('Stock')->default(0);
            $table->decimal('Price', 8, 2);
            $table->timestamps();
            $table->softDeletesDatetime()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpus');
    }
};
