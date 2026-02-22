<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ClienteController;
use App\Http\Controllers\Api\V1\PropostaController;
use App\Http\Controllers\Api\V1\AuditoriaPropostaController;

Route::prefix('v1')->group(function () {

    // Clientes
    Route::post('/clientes', [ClienteController::class, 'store']);
    Route::get('/clientes/{id}', [ClienteController::class, 'show']);

    // Propostas
    Route::post('/propostas', [PropostaController::class, 'store']);
    Route::patch('/propostas/{id}', [PropostaController::class, 'update']);

    Route::post('/propostas/{id}/submit', [PropostaController::class, 'submit']);
    Route::post('/propostas/{id}/approve', [PropostaController::class, 'approve']);
    Route::post('/propostas/{id}/reject', [PropostaController::class, 'reject']);
    Route::post('/propostas/{id}/cancel', [PropostaController::class, 'cancel']);
    Route::delete('/propostas/{id}', [PropostaController::class, 'destroy']);

    Route::get('/propostas/{id}', [PropostaController::class, 'show']);
    Route::get('/propostas', [PropostaController::class, 'index']);

    

    // Auditoria
    Route::get('/propostas/{id}/auditoria', [AuditoriaPropostaController::class, 'index']);
    
});