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
        Schema::create('auditoria_propostas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposta_id')->constrained('propostas');
            $table->string('actor'); 
            $table->enum('evento', ['CREATED', 'UPDATED_FIELDS', 'STATUS_CHANGED','DELETED_LOGICAL']);
            $table->json('payload')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_propostas');
    }
};
