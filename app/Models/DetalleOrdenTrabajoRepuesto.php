<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrdenTrabajoRepuesto extends Model
{
    use HasFactory;

    protected $table = 'detalle_orden_trabajo_repuestos';
    
    protected $fillable = [
        'orden_trabajo_id',
        'parte_id',
        'cantidad',
        'precio_unitario',
        'descripcion',
    ];

    /**
     * Relación con la orden de trabajo
     */
    public function ordenTrabajo()
    {
        return $this->belongsTo(OrdenTrabajoMantenimiento::class, 'orden_trabajo_id');
    }

    /**
     * Relación con la parte o repuesto
     */
    public function parte()
    {
        return $this->belongsTo(Parte::class, 'parte_id');
    }
}