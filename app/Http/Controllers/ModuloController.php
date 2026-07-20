<?php

namespace App\Http\Controllers;

use App\Models\Modulos;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class ModuloController extends Controller
{
    public function index()
    {
        $modulos = Modulos::paginate(12);
        Log::info('Datos del modulo', ['Modulo' => $modulos]);
        return Inertia::render('modulos/index', [
            'modulos' => $modulos
        ]);
    }

    public function create()
    {
        return Inertia::render('modulos/form');
    }

    public function edit($id)
    {
        // Buscas el módulo por ID y lo mandas a Vue
        return Inertia::render('modulos/edit', [
            'modulo' => ['id' => $id, 'nombre' => 'Módulo de Prueba']
        ]);
    }

    public function show($id)
    {
        // Buscas el módulo por ID y lo mandas a Vue
        return Inertia::render('modulos/show', [
            'modulo' => ['id' => $id, 'nombre' => 'Módulo de Prueba']
        ]);
    }
}
