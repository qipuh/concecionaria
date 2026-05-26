<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'module',
        'module_label',
        'submodule',
        'submodule_label',
    ];

    /**
     * Relación muchos a muchos con roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    /**
     * Scope para permisos por módulo
     */
    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module)->orderBy('display_name');
    }

    /**
     * Obtener todos los permisos agrupados por módulo
     */
    public static function groupedByModule()
    {
        return self::orderBy('module')->orderBy('submodule')->orderBy('display_name')->get()->groupBy('module');
    }

    /**
     * Obtener permisos agrupados por módulo y submódulo (3 niveles).
     * Retorna: [moduleKey => ['label' => '...', 'submodules' => [subKey => ['label' => '...', 'permissions' => [...]]]]]
     */
    public static function groupedByModuleAndSubmodule()
    {
        $permissions = self::orderBy('module')
            ->orderBy('submodule')
            ->orderBy('id')
            ->get();

        $result = [];
        foreach ($permissions as $perm) {
            $modKey = $perm->module ?: 'general';
            $modLabel = $perm->module_label ?: ucfirst($modKey);
            $subKey = $perm->submodule ?: 'general';
            $subLabel = $perm->submodule_label ?: ucfirst(str_replace(['-', '_', '.'], ' ', $subKey));

            if (!isset($result[$modKey])) {
                $result[$modKey] = [
                    'label' => $modLabel,
                    'submodules' => [],
                ];
            }
            if (!isset($result[$modKey]['submodules'][$subKey])) {
                $result[$modKey]['submodules'][$subKey] = [
                    'label' => $subLabel,
                    'permissions' => [],
                ];
            }
            $result[$modKey]['submodules'][$subKey]['permissions'][] = $perm;
        }
        return $result;
    }
}
