<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Proposta;
use Illuminate\Http\Request;

class AuditoriaPropostaController extends Controller
{
    public function index($id)
    {
        $proposta = Proposta::findOrFail($id);

        $auditorias = $proposta->auditorias()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($auditorias);
    }
}
