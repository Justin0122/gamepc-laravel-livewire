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
        Schema::create('caseformfactors', function (Blueprint $table) {
            $table->foreignId('FKCaseId')->references('id')->on('pc_cases');
            $table->foreignId('FKFormFactorId')->references('id')->on('formfactors');
            $table->softDeletesDatetime()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caseformfactors');
    }
};
