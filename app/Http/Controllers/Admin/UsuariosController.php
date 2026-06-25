<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;



class UsuariosController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();

        return Inertia::render('usuarios/index', compact('users'));
    }

    public function create()
    {
        $roles = Role::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('usuarios/form', [
            'roles' => $roles,
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
            $user = User::create($data);
            $role = Role::findOrFail($data['id_rol']);
            $user->syncRoles([$role]);

            return redirect('/admin/usuarios')
                ->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al crear el usuario: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $usuario = User::with('roles')->findOrFail($id);
        $roles = Role::select('id', 'name')->orderBy('name')->get();

        return Inertia::render('usuarios/form', [
            'usuario' => $usuario,
            'isEditing' => true,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $usuario = User::findOrFail($id);

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
            $usuario->update($data);
            $role = Role::findOrFail($data['id_rol']);
            $usuario->syncRoles([$role]);

            return redirect('/admin/usuarios')
                ->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al actualizar el usuario: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function show($id)
    {
        // Buscas el usuario por ID y lo mandas a Vue
        return Inertia::render('usuarios/show', [
            'usuario' => ['id' => $id, 'nombre' => 'usuario de Prueba'],
        ]);
    }

    public function password(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $data = $request->validate([
            'password' => 'required|string|min:8',
        ], [], [
            'password' => 'Contraseña',
        ]);

        try {
            $usuario->update(['password' => Hash::make($data['password'])]);

            return back()->with('success', 'Contraseña actualizada exitosamente.');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al actualizar la contraseña: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function estado(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $data = $request->validate([
            'active' => 'required|integer|in:0,1',
        ], [], [
            'active' => 'Estado',
        ]);

        try {
            $usuario->update(['active' => $data['active']]);

            return back()->with('success', 'Estado actualizado exitosamente.');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Error al actualizar el estado: '.$e->getMessage()]);
        }
    }
}
