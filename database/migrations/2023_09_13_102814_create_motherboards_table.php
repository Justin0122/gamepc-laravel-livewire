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
        Schema::create('motherboards', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->foreignId('FKSocketId')->references('Id')->on('sockets');
            $table->foreignId('FKMemoryTypeId')->references('Id')->on('memorytypes');
            $table->foreignId('FKFormFactorId')->references('Id')->on('formfactors');
            $table->foreignId('FKBrandId')->references('Id')->on('brands');
            $table->integer('MemoryCapacity');
            $table->integer('USBPorts');
            $table->integer('PCIeSlots');
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
        Schema::dropIfExists('motherboards');
    }
};
