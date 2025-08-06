<?php
// app/Models/Venta.php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
   
    protected $fillable = [
        'codigo',
        'fecha',
        'cliente_id',
        'usuario_id',
        'almacen_id',
        'subtotal',
        'igv',
        'total',
        'moneda',
        'tipo_pago',
        'estado',
        'observaciones',
        'cotizacion_id',
        'monto_abonado',     // Nuevo campo
        'saldo_pendiente'    // Nuevo campo
    ];
   
    protected $casts = [
        'fecha' => 'datetime',
        'subtotal' => 'float',
        'igv' => 'float',
        'total' => 'float',
        'monto_abonado' => 'float',    // Convertir a float
        'saldo_pendiente' => 'float'   // Convertir a float
    ];
   
    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
   
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
   
    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }
   
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
   
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }
    
    // Nueva relación con requerimientos de compra
    public function requerimientosCompra()
    {
        return $this->hasMany(RequerimientoCompra::class, 'venta_id');
    }
   
    // Generador de código automático
    public static function generarCodigo()
    {
        $anio = date('Y');
        $mes = date('m');
        $ultimaVenta = self::whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->orderBy('id', 'desc')
            ->first();
       
        $numero = $ultimaVenta ? intval(substr($ultimaVenta->codigo, -6)) + 1 : 1;
        return 'VTA-' . $anio . $mes . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }
    
    /**
     * Verifica si la venta está pagada completamente
     */
    public function estaPagada()
    {
        return $this->saldo_pendiente <= 0;
    }
    
    /**
     * Obtiene el porcentaje abonado
     */
    public function getPorcentajeAbonadoAttribute()
    {
        if ($this->total > 0) {
            return round(($this->monto_abonado / $this->total) * 100, 2);
        }
        return 0;
    }
    
    /**
     * Registra un pago adicional
     */
    public function registrarPago($monto, $referencia = null, $comentario = null)
    {
        if ($monto <= 0 || $monto > $this->saldo_pendiente) {
            return false;
        }
        
        $this->monto_abonado += $monto;
        $this->saldo_pendiente -= $monto;
        
        // Si se pagó todo, actualizar el estado
        if ($this->saldo_pendiente <= 0) {
            $this->estado = 'Completada';
            $this->saldo_pendiente = 0; // Asegurarse que no quede negativo
        }
        
        return $this->save();
    }
    
    /**
     * Genera un requerimiento de compra para items sin stock
     */
    public function generarRequerimientoCompra($itemsSinStock, $estadoId, $comentario = null)
    {
        if (empty($itemsSinStock)) {
            return null;
        }
        
        $requerimiento = new RequerimientoCompra();
        $requerimiento->tipo = 'Compra';
        $requerimiento->almacen_id = $this->almacen_id;
        $requerimiento->comentario = $comentario ?? "Requerimiento generado automáticamente desde POS. Venta: {$this->codigo}";
        $requerimiento->estado_id = $estadoId;
        $requerimiento->cotizacion_id = $this->cotizacion_id;
        $requerimiento->venta_id = $this->id;
        $requerimiento->prioridad = 'Alta';
        $requerimiento->user_id = $this->usuario_id;
        $requerimiento->save();
        
        // Crear detalles del requerimiento
        foreach ($itemsSinStock as $item) {
            if ($item['tipo'] == 'parte') {
                $detalle = new DetalleRequerimientoCompra();
                $detalle->requerimiento_compra_id = $requerimiento->id;
                $detalle->item_id = $item['id'];
                $detalle->tipo_item = 'parte';
                $detalle->cantidad = $item['cantidad'];
                $detalle->descripcion = "Requerido para venta {$this->codigo}";
                $detalle->save();
            }
        }
        
        return $requerimiento;
    }

    public function detallesPOS()
    {
        return $this->hasMany(DetalleVentaPOS::class, 'venta_id');
    }
}