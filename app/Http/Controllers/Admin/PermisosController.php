<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class PermisosController extends Controller
{
    public function index()
    {
        $permisos = Permission::with('permissions')->get(); 
        return Inertia::render('permisos/index', [ 
            'permisos' => $permisos 
        ]);
    }
}
