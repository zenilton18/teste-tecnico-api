<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Proposta;
use App\Models\AuditoriaProposta;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Cliente::factory(5)->create()->each(function ($cliente) {
            $propostas = Proposta::factory(3)->create([
                'cliente_id' => $cliente->id
            ]);

            foreach ($propostas as $proposta) {
                AuditoriaProposta::factory()->create([
                    'proposta_id' => $proposta->id,
                    'payload' => [
                        'status' => $proposta->status
                    ]
                ]);
            }
        });
    }
}