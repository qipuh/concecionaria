<?php

namespace App\Http\Controllers\Admin\Almacenes;

use App\Http\Controllers\Controller;
use App\Models\Parte;
use App\Models\Unidad;
use App\Models\Fabricante;
use App\Models\CategoriasPartes;
use App\Models\Proveedor;
use App\Models\Almacen;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Facades\Excel;

HeadingRowFormatter::default('none');

class ParteTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['REP-001', 'Filtro de aceite', 'Bosch', 'BO-F001', 'Unidad', 'Bosch', 'Filtros', 'TecnoAuto SAC', '45.00', 'SOL', '28.00', 'SOL', 'Almacén Principal', '10'],
        ];
    }

    public function headings(): array
    {
        return [
            'Codigo',
            'Nombre',
            'Marca',
            'Codigo OEM',
            'Unidad',
            'Fabricante',
            'Categoria',
            'Proveedor',
            'Precio Venta',
            'Moneda Venta',
            'Precio Compra',
            'Moneda Compra',
            'Almacen',
            'Stock',
        ];
    }
}

class ParteImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $row = $row->toArray();

            $validator = Validator::make($row, [
                'Nombre'        => 'required|string|max:255',
                'Unidad'        => 'required|string|max:255',
                'Categoria'     => 'required|string|max:255',
                'Proveedor'     => 'required|string|max:255',
                'Precio Venta'  => 'required|numeric|min:0',
                'Moneda Venta'  => 'required|in:SOL,USD',
                'Precio Compra' => 'required|numeric|min:0',
                'Moneda Compra' => 'required|in:SOL,USD',
                'Almacen'       => 'required|string|max:255',
                'Stock'         => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                throw new \Exception('Error en fila "' . ($row['Nombre'] ?? '?') . '": ' . implode(', ', $validator->errors()->all()));
            }

            $unidad = Unidad::where('nombre', $row['Unidad'])->first();
            if (!$unidad) throw new \Exception('Unidad no encontrada: "' . $row['Unidad'] . '"');

            $categoria = CategoriasPartes::where('nombre', $row['Categoria'])->first();
            if (!$categoria) throw new \Exception('Categoría no encontrada: "' . $row['Categoria'] . '"');

            $proveedor = Proveedor::where('razon_social', $row['Proveedor'])->first();
            if (!$proveedor) throw new \Exception('Proveedor no encontrado: "' . $row['Proveedor'] . '"');

            $almacen = Almacen::where('nombre', $row['Almacen'])->first();
            if (!$almacen) throw new \Exception('Almacén no encontrado: "' . $row['Almacen'] . '"');

            $fabricante = null;
            if (!empty($row['Fabricante'])) {
                $fabricante = Fabricante::where('nombre_fabricante', $row['Fabricante'])->first();
            }

            $codigo = !empty($row['Codigo']) ? trim($row['Codigo']) : null;
            $autogenerar = $codigo === null;
            if ($codigo === null) {
                $ultimo = Parte::max('codigo');
                $codigo = $ultimo ? str_pad((int)$ultimo + 1, 6, '0', STR_PAD_LEFT) : '000001';
            }

            $parte = Parte::create([
                'codigo'             => $codigo,
                'autogenerar_codigo' => $autogenerar,
                'nombre'             => $row['Nombre'],
                'marca'              => $row['Marca'] ?? null,
                'codigo_oem'         => $row['Codigo OEM'] ?? null,
                'unidad_id'          => $unidad->id,
                'fabricante_id'      => $fabricante?->id,
                'categoria_parte_id' => $categoria->id,
                'proveedor_id'       => $proveedor->id,
                'precio_venta'       => $row['Precio Venta'],
                'moneda_venta'       => $row['Moneda Venta'],
                'precio_compra'      => $row['Precio Compra'],
                'moneda_compra'      => $row['Moneda Compra'],
            ]);

            Inventario::create([
                'parte_id'         => $parte->id,
                'almacen_id'       => $almacen->id,
                'stock_disponible' => (int) $row['Stock'],
                'stock_reservado'  => 0,
                'stock_minimo'     => 0,
                'stock_maximo'     => 0,
            ]);
        }
    }
}

class ParteImportController extends Controller
{
    public function downloadTemplate()
    {
        return Excel::download(new ParteTemplateExport, 'plantilla_partes.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new ParteImport, $request->file('file'));
            return redirect()->route('admin.almacenes.partes.index')
                ->with('success', 'Partes importadas exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.almacenes.partes.index')
                ->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }
}
