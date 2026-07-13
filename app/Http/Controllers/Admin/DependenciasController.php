<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dependencias;
use App\Models\TipoDependencias;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;


class DependenciasController extends Controller
{
    protected $table = 'ca_dependencias';

    public function index()
    {
        $dependencias = Dependencias::get();
        return Inertia::render('dependencias/index', compact('dependencias'));
    }

    public function create()
    {
        $dependenciasPadre = Dependencias::whereNull('id_padre')
            ->orWhere('id_padre', 0)
            ->get();
        $tipoDependencias = TipoDependencias::get();
        return Inertia::render('dependencias/form', [
            'dependenciaPadre' => $dependenciasPadre,
            'tipoDependencias' => $tipoDependencias,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:255',
            'adscripcion' => 'required|numeric|max:255',
            'id_padre' => 'numeric|digits_between:13,15|nullable',
            'metadatos' => 'required|json',
            'shortname' => 'required|string|max:255',
            'tipo_dependencia' => 'required|integer|exists:ca_tipo_dependencias,id',
            'email' => 'required|string|email|max:255|unique:users|confirmed',
            'telefono' => 'required|numeric|digits_between:10,15',
            'horarios' => 'required|string|max:255',
            'codigo_postal' => 'required|numeric|digits_between:5,10',
            'id_municipio' => 'required|integer',
            'colonia' => 'required|string|max:255',
            'calle_numero' => 'required|string|max',
            'latitud' => 'required|string|max:255',
            'longitud' => 'required|string|max:255',
        ], [], [
            // Alias para mensajes de error en español
            'descripcion' => 'Descripción',
            'adscripcion' => 'Adscripción',
            'id_padre' => 'Dependencia a la que pertenece',
            'metadatos' => 'Metadatos',
            'shortname' => 'Nombre corto',
            'tipo_dependencia' => 'Tipo de dependencia',
            'email' => 'Correo electrónico',
            'telefono' => 'Teléfono',
            'horarios' => 'Horarios',
            'codigo_postal' => 'Código postal',
            'id_municipio' => 'Municipio',
            'colonia' => 'Colonia',
            'calle_numero' => 'Calle y número',
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
        ]);

        try {
            $Dependencias = Dependencias::create($data);
            return redirect('/admin/dependencias')
                ->with('success', 'Dependencia creada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al crear la dependencia: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $dependencias = Dependencias::findOrFail($id);

        $dependenciasPadre = Dependencias::whereNull('id_padre')
            ->orWhere('id_padre', 0)
            ->get();
        $tipoDependencias = TipoDependencias::get();

        return Inertia::render('dependencias/form', [
            'isEditing' => true,
            'dependencia' => $dependencias,
            'dependenciaPadre' => $dependenciasPadre,
            'tipoDependencias' => $tipoDependencias,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $dependencias = Dependencias::findOrFail($id);

        $data = $request->validate([
            'descripcion' => 'required|string|max:255',
            'adscripcion' => 'required|numeric|max:255',
            'id_padre' => 'numeric|digits_between:13,15|nullable',
            'metadatos' => 'required|json',
            'shortname' => 'required|string|max:255',
            'tipo_dependencia' => 'required|integer|exists:ca_tipo_dependencias,id',
            'email' => 'required|string|email|max:255|unique:users|confirmed',
            'telefono' => 'required|numeric|digits_between:10,15',
            'horarios' => 'required|string|max:255',
            'codigo_postal' => 'required|numeric|digits_between:5,10',
            'id_municipio' => 'required|integer',
            'colonia' => 'required|string|max:255',
            'calle_numero' => 'required|string|max',
            'latitud' => 'required|string|max:255',
            'longitud' => 'required|string|max:255',
        ], [], [
            // Alias para mensajes de error en español
            'descripcion' => 'Descripción',
            'adscripcion' => 'Adscripción',
            'id_padre' => 'Dependencia a la que pertenece',
            'metadatos' => 'Metadatos',
            'shortname' => 'Nombre corto',
            'tipo_dependencia' => 'Tipo de dependencia',
            'email' => 'Correo electrónico',
            'telefono' => 'Teléfono',
            'horarios' => 'Horarios',
            'codigo_postal' => 'Código postal',
            'id_municipio' => 'Municipio',
            'colonia' => 'Colonia',
            'calle_numero' => 'Calle y número',
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
        ]);

        try {
            $dependencias->update($data);

            return redirect('/admin/dependencias')
                ->with('success', 'Dependencia actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al actualizar la dependencia: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show($id)
    {
        return Inertia::render('dependencias/show', [
            'dependencia' => ['id' => $id, 'descripcion' => Dependencias::findOrFail($id)->descripcion],
        ]);
    }

    public function estado(Request $request, $id)
    {
        $dependencia = Dependencias::findOrFail($id);

        $data = $request->validate([
            'active' => 'required|integer|in:0,1',
        ], [], [
            'active' => 'Estado',
        ]);

        try {
            $dependencia->update(['active' => $data['active']]);

            return back()->with('success', 'Estado actualizado exitosamente.');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al actualizar el estado: ' . $e->getMessage()]);
        }
    }
}
