<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class UsuariosController extends Controller
{
    public function index() {
        $users = User::all();
        return Inertia::render('usuarios/index', compact('users'));
    }

    public function create() {
        return Inertia::render('usuarios/create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'string|max:255',
            'numero_control' => 'required|number|max:15|unique:users',
            'id_rol' => 'required|integer|exists:ca_roles,id',
            'id_dependencia' => 'required|integer|exists:ca_dependencias,id',
            'email' => 'required|string|email|max:255|unique:users|confirmed',
            'password' => 'required|string|min:8|confirmed',
        ], [], [
            // Alias para mensajes de error en español
            'name' => 'Nombre(s)',
            'primer_apellido' => 'Primer apellido',
            'segundo_apellido' => 'Segundo apellido',
            'numero_control' => 'Número de control',
            'id_rol' => 'Rol',
            'id_dependencia' => 'Dependencia',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
        ]);

        try {
            $user = User::create($data);
            
            return redirect()->route('usuarios')
                ->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al crear el usuario: ' . $e->getMessage()])
                ->withInput();
        }
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
