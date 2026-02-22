<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Proposta;
use App\Models\AuditoriaProposta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class PropostaController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produto' => 'required|string',
            'valor_mensal' => 'required|numeric',
            'origem' => 'required|in:APP,SITE,API',
        ]);

        $proposta = Proposta::create([
            ...$data,
            'status' => 'DRAFT',
            'versao' => 1,
        ]);

        return response()->json($proposta, 201);
    }
    public function update(Request $request, $id)
    {
        $proposta = Proposta::findOrFail($id);
       
        if ($proposta->statusFinal()) {
            return response()->json(['error' => 'Proposta em status final'], 422);
        }

        $proposta->validarVersao($request->versao);

        $dados = $request->validate([
            'produto' => 'sometimes|string',
            'valor_mensal' => 'sometimes|numeric',
            'origem' => 'sometimes|in:APP,SITE,API',
            'versao' => 'required|integer'
        ]);
        $antes = $proposta->only(array_keys($dados));

        unset($dados['versao']);

        $proposta->update($dados);
        $proposta->increment('versao');
        $payload = [
            'from' => $antes,
            'to'   => $proposta->only(array_keys($dados)),
        ];

        AuditoriaProposta::registrar(
            $proposta->id,
            'system',
            'UPDATED_FIELDS',
            $payload
        );

        return response()->json($proposta);
    }

    public function submit(Request $request, $id)
    {
        $proposta = Proposta::findOrFail($id);

        if (!$proposta->podeMudarPara(Proposta::STATUS_SUBMITTED)) {
            return response()->json([
                'erro' => 'Proposta não pode ser submetida neste status'
            ], 422);
        }

        $proposta->validarVersao($request->versao);

        $statusAnterior = $proposta->status;

        $proposta->update([
            'status' => Proposta::STATUS_SUBMITTED
        ]);

        AuditoriaProposta::create([
            'proposta_id' => $proposta->id,
            'actor' => 'system',
            'evento' => 'STATUS_CHANGED',
            'payload' => [
                'from' => $statusAnterior,
                'to' => Proposta::STATUS_SUBMITTED
            ]
        ]);

        return response()->json($proposta);
    }

    public function approve(Request $request, $id) 
    {
        $proposta = Proposta::findOrfail($id);

        if (!$proposta->podeMudarPara(Proposta::STATUS_APPROVED)) {
            return response()->json([
                'erro' => 'Transição de status inválida'
            ], 422);
        }

        $proposta->validarVersao($request->versao);

        $proposta->status = Proposta::STATUS_APPROVED;
        $proposta->versao++;
        $proposta->save();

        return response()->json($proposta);
    }

    public function reject(Request $request, $id)
    {
        $proposta = Proposta::findOrFail($id);

        if (!$proposta->podeMudarPara(Proposta::STATUS_REJECTED)) {
            return response()->json([
                'erro' => 'Transição de status inválida'
            ], 422);
        }

        $proposta->validarVersao($request->versao);

        $proposta->status = Proposta::STATUS_REJECTED;
        $proposta->versao++;
        $proposta->save();

        return response()->json($proposta);
    }
    public function cancel(Request $request, $id)
    {
        $proposta = Proposta::findOrFail($id);

        if (!$proposta->podeMudarPara(Proposta::STATUS_CANCELED)) {
            return response()->json([
                'erro' => 'Transição de status inválida'
            ], 422);
        }

        $proposta->validarVersao($request->versao);

        $proposta->status = Proposta::STATUS_CANCELED;
        $proposta->versao++;
        $proposta->save();

        return response()->json($proposta);
    }

    public function show($id)
    {
        $proposta = Proposta::findOrFail($id);
        return response()->json($proposta);
    }

    public function index(Request $request)
    {
        $query = Proposta::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('origem')) {
            $query->where('origem', $request->origem);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $query->orderBy($sortBy, $sortDir);

        $pagina = $request->get('per_page', 10);

        return response()->json(
            $query->paginate($pagina)
        );
    }

    public function destroy($id, Request $request)
    {
        $proposta = Proposta::findOrFail($id);

        if ($proposta->statusFinal()) {
            return response()->json([
                'error' => 'Proposta em status final não pode ser excluída'
            ], 400);
        }

        $proposta->validarVersao($request->versao);

        AuditoriaProposta::create([
            'proposta_id' => $proposta->id,
            'actor' => 'system',
            'evento' => 'DELETED_LOGICAL',
            'payload' => [
                'from' => $proposta->status,
                'to' => 'DELETED'
            ]
        ]);

        $proposta->delete();

        return response()->json([
            'message' => 'Proposta excluída logicamente'
        ]);
    }    
}


