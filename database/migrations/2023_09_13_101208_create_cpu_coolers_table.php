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
        Schema::create('cpu_coolers', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->foreignId('FKSocketId')->references('Id')->on('sockets');
            $table->foreignId('FKBrandId')->references('Id')->on('brands');
            $table->foreignId('FKGenerationId')->references('Id')->on('generations');
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
        Schema::dropIfExists('cpu_coolers');
    }
};
