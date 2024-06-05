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
        Schema::create('my_pcs', function (Blueprint $table) {
            $table->id('MyPcId');
            $table->foreignId('FKUserId')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('FKCpuId')->nullable()->references('id')->on('cpus');
            $table->foreignId('FKCpuCoolerId')->nullable()->references('id')->on('cpu_coolers');
            $table->foreignId('FKMotherboardId')->nullable()->references('Id')->on('motherboards');
            $table->foreignId('FKRamId')->nullable()->references('id')->on('rams');
            $table->foreignId('FKStorageId')->nullable()->references('id')->on('storages');
            $table->foreignId('FKGpuId')->nullable()->references('id')->on('gpus');
            $table->foreignId('FKPsuId')->nullable()->references('id')->on('psus');
            $table->foreignId('FKCaseId')->nullable()->references('id')->on('pc_cases');
            $table->foreignId('FKCaseCoolerId')->nullable()->references('id')->on('case_coolers');
            $table->timestamps();
            $table->softDeletesDatetime()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_pcs');
    }
};
