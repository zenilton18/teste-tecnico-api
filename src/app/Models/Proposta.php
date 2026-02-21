<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'produto',
        'valor_mensal',
        'status',
        'origem',
        'versao',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function auditorias()
    {
        return $this->hasMany(AuditoriaProposta::class);
    }
}
