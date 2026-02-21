<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaProposta extends Model
{
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
}
