<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrdenTrabajoServicio extends Model
{
    use HasFactory;

    protected $table = 'detalle_orden_trabajo_servicios';
    
    protected $fillable = [
        'orden_trabajo_id',
        'servicio_id',
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
     * Relación con el servicio
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}