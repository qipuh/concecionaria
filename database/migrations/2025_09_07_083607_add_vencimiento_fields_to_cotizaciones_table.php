<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->foreignId('regla_vencimiento_id')->nullable()->constrained('reglas_vencimiento_cotizaciones')->comment('Regla de vencimiento aplicada');
            $table->datetime('fecha_ultimo_seguimiento')->nullable()->comment('Última fecha de seguimiento o actividad');
            $table->datetime('fecha_vencimiento')->nullable()->comment('Fecha calculada de vencimiento');
            $table->datetime('fecha_alerta')->nullable()->comment('Fecha para enviar alerta de vencimiento próximo');
            $table->boolean('vencida')->default(false)->comment('Si la cotización está vencida');
            $table->boolean('reasignable')->default(false)->comment('Si puede ser reasignada a otro asesor');
            $table->json('historial_vencimiento')->nullable()->comment('Historial de cambios por vencimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->dropConstrainedForeignId('regla_vencimiento_id');
            $table->dropColumn([
                'fecha_ultimo_seguimiento',
                'fecha_vencimiento', 
                'fecha_alerta',
                'vencida',
                'reasignable',
                'historial_vencimiento'
            ]);
        });
    }
};
