<?php
namespace App\Http\Controllers\Admin\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.usuarios.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.usuarios.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string|max:255',
        ]);

        Role::create($request->all());

        return redirect()->route('admin.usuarios.roles.index')
                        ->with('success', 'Rol creado con éxito');
    }

    public function show(Role $rol)
    {
        return view('admin.usuarios.roles.show', compact('rol'));
    }

    public function edit(Role $rol)
    {
        return view('admin.usuarios.roles.edit', compact('rol'));
    }

    public function update(Request $request, Role $rol)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $rol->id,
            'description' => 'nullable|string|max:255',
        ]);

        $rol->update($request->all());

        return redirect()->route('admin.usuarios.roles.index')
                        ->with('success', 'Rol actualizado con éxito');
    }

    public function destroy(Role $rol)
    {
        // Verificar que no sea un rol importante
        if (in_array($rol->name, ['admin'])) {
            return redirect()->route('admin.usuarios.roles.index')
                            ->with('error', 'No se puede eliminar el rol de administrador');
        }

        $rol->delete();

        return redirect()->route('admin.usuarios.roles.index')
                        ->with('success', 'Rol eliminado con éxito');
    }
}