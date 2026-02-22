<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaProposta extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'proposta_id',
        'actor',
        'evento',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function proposta()
    {
        return $this->belongsTo(Proposta::class);
    }
    
    public static function registrar($propostaId, $actor, $evento, array $payload = [])
    {
        return self::create([
            'proposta_id' => $propostaId,
            'actor'       => $actor,
            'evento'      => $evento,
            'payload'     => $payload,
        ]);
    }
}
