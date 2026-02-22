<?php

namespace Database\Factories;

use App\Models\AuditoriaProposta;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditoriaPropostaFactory extends Factory
{
    protected $model = AuditoriaProposta::class;

    public function definition(): array
    {
        return [
            'proposta_id' => \App\Models\Proposta::factory(),
            'actor' => 'system',
            'evento' => 'CREATED',
            'payload' => [
                'status' => 'DRAFT'
            ],
        ];
    }
}
