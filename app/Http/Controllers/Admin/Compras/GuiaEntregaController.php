<?php

namespace App\Http\Controllers\Admin\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuiaEntregaController extends Controller
{
    public function index()
    {
        // Por implementar
        return view('admin.compras.documentos.guias.index');
    }

    public function create()
    {
        // Por implementar
        return view('admin.compras.documentos.guias.create');
    }

    public function store(Request $request)
    {
        // Por implementar
    }

    public function show($id)
    {
        // Por implementar
        return view('admin.compras.documentos.guias.show');
    }

    public function edit($id)
    {
        // Por implementar
        return view('admin.compras.documentos.guias.edit');
    }

    public function update(Request $request, $id)
    {
        // Por implementar
    }
}