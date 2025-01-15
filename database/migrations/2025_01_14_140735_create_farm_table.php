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
        // Tabela das fazendas
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('size', 8, 2);
            $table->string('responsible');
            $table->timestamps();
        });

        // Tabela de veterinários
        Schema::create('vets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('crmv')->unique();
            $table->timestamps();
        });

        // tabela de relacionamento vets e farms
        Schema::create('farm_vet', function (Blueprint $table) {
            $table->foreignId('farm_id')->constrained('farms')->onDelete('cascade');
            $table->foreignId('vet_id')->constrained('vets')->onDelete('cascade');
            $table->primary(['farm_id', 'vet_id']);
            $table->timestamps();
        });

        // Tabela dos gados
        Schema::create('cows', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('milk', 8, 2);
            $table->decimal('feed', 8, 2);
            $table->decimal('weight', 8, 2);
            $table->date('birth_date');
            $table->foreignId('farm_id')->constrained('farms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_vet');
        Schema::dropIfExists('cows');
        Schema::dropIfExists('vets');
        Schema::dropIfExists('farms');
    }
};
