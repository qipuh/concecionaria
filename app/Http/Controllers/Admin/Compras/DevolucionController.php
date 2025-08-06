<?php

namespace App\Http\Controllers\Admin\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DevolucionController extends Controller
{
    public function index()
    {
        // Por implementar
        return view('admin.compras.documentos.devoluciones.index');
    }

    public function create()
    {
        // Por implementar
        return view('admin.compras.documentos.devoluciones.create');
    }

    public function store(Request $request)
    {
        // Por implementar
    }

    public function show($id)
    {
        // Por implementar
        return view('admin.compras.documentos.devoluciones.show');
    }

    public function edit($id)
    {
        // Por implementar
        return view('admin.compras.documentos.devoluciones.edit');
    }

    public function update(Request $request, $id)
    {
        // Por implementar
    }
}