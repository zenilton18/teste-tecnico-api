<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposta extends Model
{
    use SoftDeletes;
    use HasFactory;
    public const STATUS_DRAFT = 'DRAFT';
    public const STATUS_SUBMITTED = 'SUBMITTED';
    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_REJECTED = 'REJECTED';
    public const STATUS_CANCELED = 'CANCELED';

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
    
    public function podeMudarPara(string $novoStatus): bool
    {
        $fluxo = [
            self::STATUS_DRAFT => [
                self::STATUS_SUBMITTED,
            ],
            self::STATUS_SUBMITTED => [
                self::STATUS_APPROVED,
                self::STATUS_REJECTED,
                self::STATUS_CANCELED,
            ],
        ];

        return isset($fluxo[$this->status]) && in_array($novoStatus, $fluxo[$this->status]);
    }

    public function validarVersao(int $versaoRequest)
    {
        if ($versaoRequest !== $this->versao) {
            abort(response()->json([
                'error' => 'Versão desatualizada',
                'code' => 'VERSION_CONFLICT'
            ], 409));      
        }
    }

    public function statusFinal(): bool
    {
        return in_array($this->status, [
            self::STATUS_APPROVED,
            self::STATUS_REJECTED,
            self::STATUS_CANCELED,
        ]);
    }
}
