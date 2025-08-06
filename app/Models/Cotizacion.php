<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    
    protected $table = 'cotizaciones';
    
    protected $fillable = [
        'codigo',
        'cliente_id',
        'almacen_id',
        'condicion',
        'canal',
        'moneda',
        'forma_pago',
        'datos_adicionales',
        'subtotal',
        'impuestos',
        'total',
        'estado_id',
        'user_id',
        'fecha_validez',
        'gestionado',
        'centro_costo_id'
    ];
    
    protected $casts = [
        'fecha_validez' => 'date',
        'gestionado' => 'boolean'
    ];
    
    // Relaciones principales
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
    
    public function estado()
    {
        return $this->belongsTo(EstadoCotizacion::class, 'estado_id');
    }
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // Relaciones de detalles y seguimientos
    public function detalles()
    {
        return $this->hasMany(DetalleCotizacion::class, 'cotizacion_id');
    }
    
    public function historial()
    {
        return $this->hasMany(HistorialCotizacion::class, 'cotizacion_id')->orderBy('created_at', 'desc');
    }
    
    public function seguimientos()
    {
        return $this->hasMany(SeguimientoCotizacion::class, 'cotizacion_id')->latest();
    }
    
    // Relaciones de pagos y comprobantes
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'cotizacion_id');
    }
    
    public function comprobantes()
    {
        return $this->hasMany(Comprobante::class, 'cotizacion_id');
    }
    
    // Relaciones de procesos (pestañas)
    public function nota_pedido()
    {
        return $this->hasOne(NotaPedido::class, 'cotizacion_id');
    }
    
    public function ordenTrabajo()
    {
        return $this->hasOne(OrdenTrabajo::class, 'cotizacion_id');
    }
    
    public function acta_entrega()
    {
        return $this->hasOne(ActaEntrega::class, 'cotizacion_id');
    }
    
    public function documentos_sunarp()
    {
        return $this->hasMany(DocumentoSunarp::class, 'cotizacion_id');
    }
    
    public function placa_info()
    {
        return $this->hasOne(PlacaInfo::class, 'cotizacion_id');
    }
    
    public function documentos_placa()
    {
        return $this->hasMany(DocumentoPlaca::class, 'cotizacion_id');
    }
    
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'cotizacion_id');
    }
    
    // Relación con requerimiento de compra
    public function requerimientoCompra()
    {
        return $this->hasOne(RequerimientoCompra::class, 'cotizacion_id');
    }
    
    // Métodos de utilidad
    public static function generarCodigo()
    {
        $anio = date('Y');
        $mes = date('m');
        $ultimaCotizacion = self::whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->orderBy('id', 'desc')
            ->first();
        $numero = $ultimaCotizacion ? intval(substr($ultimaCotizacion->codigo, -6)) + 1 : 1;
        return 'COT-' . $anio . $mes . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }
    
    // Scopes
    public function scopeEstado($query, $estadoId)
    {
        if ($estadoId) {
            return $query->where('estado_id', $estadoId);
        }
        return $query;
    }
    
    public function scopeCliente($query, $clienteId)
    {
        if ($clienteId) {
            return $query->where('cliente_id', $clienteId);
        }
        return $query;
    }
    
    public function scopeFechaRango($query, $desde, $hasta)
    {
        if ($desde && $hasta) {
            return $query->whereBetween('created_at', [$desde, $hasta]);
        }
        return $query;
    }
    public function placas()
    {
        return $this->hasMany(PlacaInfo::class, 'cotizacion_id');
    }
    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'centro_costo_id');
    }
    public function ultimoSeguimiento()
    {
        return $this->hasOne(SeguimientoCotizacion::class)->latest('fecha_seguimiento');
    }
    public function estadoAnterior()
    {
        return $this->belongsTo(EstadoCotizacion::class, 'estado_id');
    }  
    
    public function __call($method, $parameters)
    {
        if ($method === 'orden_trabajo') {
            return $this->ordenTrabajo();
        }
        
        return parent::__call($method, $parameters);
    }

    public function vehiculos()
    {
        return $this->hasManyThrough(
            Vehiculo::class, 
            DetalleCotizacion::class, 
            'cotizacion_id', // FK en detalles_cotizacion
            'id',            // PK en vehiculos
            'id',            // PK en cotizaciones
            'vehiculo_catalogo_id' // FK en detalles_cotizacion referenciando vehiculos
        );
    }
    public function orden_trabajo()
    {
        return $this->hasOne(OrdenTrabajo::class, 'cotizacion_id');
    }
    public function esCerradoGanado()
    {
        return $this->estado && $this->estado->nombre === 'Cerrado Ganado';
    }
    public function puedeGenerarRequerimiento()
    {
        return $this->esCerradoGanado() && !$this->requerimientoCompra && $this->detalles->count() > 0;
    }
}