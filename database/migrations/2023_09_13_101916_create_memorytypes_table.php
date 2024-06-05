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
        Schema::create('memorytypes', function (Blueprint $table) {
            $table->id();
            $table->string('Name');
            $table->integer('MemoryTypeSpeed');
            $table->timestamps();
            $table->softDeletesDatetime()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorytypes');
    }
};
