<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    public function index() {
        // Aquí traerías los datos de la DB, por ahora enviamos vacío
        return Inertia::render('modulos/index', [
            'modulo' => [] 
        ]);
    }

    public function create() {
        return Inertia::render('modulos/create');
    }

    public function edit($id) {
        // Buscas el módulo por ID y lo mandas a Vue
        return Inertia::render('modulos/edit', [
            'modulo' => ['id' => $id, 'nombre' => 'Módulo de Prueba']
        ]);
    }

    public function show($id) {
        // Buscas el módulo por ID y lo mandas a Vue
        return Inertia::render('modulos/show', [
            'modulo' => ['id' => $id, 'nombre' => 'Módulo de Prueba']
        ]);
    }
}
