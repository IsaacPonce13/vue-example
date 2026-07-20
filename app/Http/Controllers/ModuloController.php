<?php

namespace App\Http\Controllers;

use App\Models\Modulos;
use App\Models\CategoriasModulos;
use App\Models\TipoModulos;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class ModuloController extends Controller
{
    public function index()
    {
        $modulos = Modulos::paginate(12);

        return Inertia::render('modulos/index', [
            'modulos' => $modulos
        ]);
    }

    public function create()
    {
        $detalleTypeSource = Modulos::select('detalle_id', 'detalle_type')->orderBy('detalle_type')->get();
        $categoriaSource = CategoriasModulos::select('id', 'descripcion')->orderBy('descripcion')->get();
        $tipoModuloSource = TipoModulos::select('id', 'descripcion')->orderBy('descripcion')->get();
        Log::info("Info de modulos: {$detalleTypeSource}, Categorias: {$categoriaSource}, tips: {$tipoModuloSource}");

        return Inertia::render('modulos/form', [
            'detalleTypeSource' => $detalleTypeSource,
            'categoriaSource' => $categoriaSource,
            'tipoModuloSource' => $tipoModuloSource
        ]);
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
