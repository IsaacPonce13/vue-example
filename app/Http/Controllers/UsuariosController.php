<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function index() {
        // Aquí traerías los datos de la DB, por ahora enviamos vacío
        return Inertia::render('usuarios/index', [
            'usuario' => [] 
        ]);
    }

    public function create() {
        return Inertia::render('usuarios/create');
    }

    public function store(Request $request) {
        dd($request);
    }

    public function edit($id) {
        // Buscas el usuario por ID y lo mandas a Vue
        return Inertia::render('usuarios/edit', [
            'usuario' => ['id' => $id, 'nombre' => 'usuario de Prueba']
        ]);
    }

    public function show($id) {
        // Buscas el usuario por ID y lo mandas a Vue
        return Inertia::render('usuarios/show', [
            'usuario' => ['id' => $id, 'nombre' => 'usuario de Prueba']
        ]);
    }
}
