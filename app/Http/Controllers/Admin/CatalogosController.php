<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Models\Dependencias;


class CatalogosController extends Controller
{
    public function index()
    {
        $catalogos = Catalogos::get();

        return Inertia::render('catalogos/index');
    }

    public function create()
    {
        $roles = Role::select('id', 'name')->orderBy('name')->get();
        $dependencias = Dependencias::select('id', 'descripcion')->orderBy('descripcion')->get();

        return Inertia::render('catalogos/form', [
            'roles' => $roles,
            'dependencias' => $dependencias,
        ]);
    }


    public function generateSecurePassword($length = 16)
    {
        $password = Str::random($length);
        
        $uppercase = Str::upper(Str::random(1));
        $lowercase = Str::lower(Str::random(1));
        $number = rand(0, 9);
        $special = substr(str_shuffle('!@#$%^&*()_+-=[]{}|;:,.<>?'), 0, 1);
        
        // Combinar y mezclar
        $password = $password . $uppercase . $lowercase . $number . $special;
        
        return str_shuffle($password);
    }

    public function store(Request $request): RedirectResponse
    {
        $password = $this->generateSecurePassword();
        Log::debug('An informational message {password}', ['password' => $password]);
        $request->merge([
            'password' => $password,
        ]);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'string|max:255|nullable',
            'numero_control' => 'required|numeric|digits_between:13,15|unique:users,numero_control',
            'id_rol' => 'required|integer|exists:roles,id',
            'id_dependencia' => 'required|integer|exists:ca_dependencias,id',
            'email' => 'required|string|email|max:255|unique:users|confirmed',
            'password' => 'required|string|min:8',
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
            $Catalogos = Catalogos::create($data);
            $role = Role::findOrFail($data['id_rol']);
            $Catalogos->syncRoles([$role]);

            return redirect('/admin/catalogos')
                ->with('success', 'Catalogo creado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al crear el catalogo: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $catalogo = Catalogos::with('roles')->findOrFail($id);
        $roles = Role::select('id', 'name')->orderBy('name')->get();
        $dependencias = Dependencias::select('id', 'descripcion')->orderBy('descripcion')->get();

        return Inertia::render('catalogos/form', [
            'catalogo' => $catalogo,
            'isEditing' => true,
            'roles' => $roles,
            'dependencias' => $dependencias,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $catalogo = Catalogos::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'string|max:255|nullable',
            'numero_control' => "required|numeric|digits_between:13,15|unique:users,numero_control,$id",
            'id_rol' => 'required|integer|exists:roles,id',
            'id_dependencia' => 'required|integer|exists:ca_dependencias,id',
            'email' => "required|string|email|max:255|unique:users,email,$id|confirmed",
        ], [], [
            // Alias para mensajes de error en español
            'name' => 'Nombre(s)',
            'primer_apellido' => 'Primer apellido',
            'segundo_apellido' => 'Segundo apellido',
            'numero_control' => 'Número de control',
            'id_rol' => 'Rol',
            'id_dependencia' => 'Dependencia',
            'email' => 'Correo electrónico',
        ]);
        
        try {
            $catalogo->update($data);
            $role = Role::findOrFail($data['id_rol']);
            $catalogo->syncRoles([$role]);

            return redirect('/admin/catalogos')
                ->with('success', 'Catalogo actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al actualizar el catalogo: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function show($id)
    {
        // Buscas el catalogo por ID y lo mandas a Vue
        return Inertia::render('catalogos/show', [
            'catalogo' => ['id' => $id, 'nombre' => 'catalogo de Prueba'],
        ]);
    }

    public function password(Request $request, $id)
    {
        $catalogo = Catalogos::findOrFail($id);

        $data = $request->validate([
            'password' => 'required|string|min:8',
        ], [], [
            'password' => 'Contraseña',
        ]);

        try {
            $catalogo->update(['password' => Hash::make($data['password'])]);

            return back()->with('success', 'Contraseña actualizada exitosamente.');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al actualizar la contraseña: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function estado(Request $request, $id)
    {
        $catalogo = Catalogos::findOrFail($id);

        $data = $request->validate([
            'active' => 'required|integer|in:0,1',
        ], [], [
            'active' => 'Estado',
        ]);

        try {
            $catalogo->update(['active' => $data['active']]);

            return back()->with('success', 'Estado actualizado exitosamente.');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al actualizar el estado: '.$e->getMessage()]);
        }
    }
}
