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
        Schema::create('rams', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->foreignId('FKBrandId')->references('Id')->on('brands');
            $table->string('Capacity');
            $table->integer('Speed')->default(0);
            $table->integer('Stock')->default(0);
            $table->foreignId('FKMemoryTypeId')->references('Id')->on('memorytypes');
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
        Schema::dropIfExists('rams');
    }
};
