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
        Schema::create('propostas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->string('produto');
            $table->decimal('valor_mensal', 10, 2);
            $table->enum('status', ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED', 'CANCELED'])->default('DRAFT');
            $table->enum('origem', ['APP', 'SITE', 'API']);
            $table->integer('versao')->default(1);
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propostas');
    }
};
