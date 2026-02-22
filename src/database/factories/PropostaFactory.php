<?php

namespace Database\Factories;

use App\Models\Proposta;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropostaFactory extends Factory
{
    protected $model = Proposta::class;

    public function definition(): array
    {
        return [
            'cliente_id' => \App\Models\Cliente::factory(),
            'produto' => $this->faker->word(),
            'valor_mensal' => $this->faker->randomFloat(2, 50, 500),
            'status' => Proposta::STATUS_DRAFT,
            'origem' => $this->faker->randomElement(['APP','SITE','API']),
            'versao' => 1,
        ];
    }
}
