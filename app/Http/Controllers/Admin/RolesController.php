<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Mostrar lista de roles con sus permisos
     */
public function index(): \Inertia\Response
{
    return Inertia::render('roles/index', [ 
        'roles' => Role::with('permissions')->get(),
        'permisos' => Permission::all()
    ]);
}

    /**
     * Mostrar formulario para crear rol
     */
    public function create(): Response
    {
        $permisos = Permission::all(); 

        return Inertia::render('roles/create', [
            'permisos' => $permisos
        ]);
    }

    /**
     * Guardar nuevo rol
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permisos' => 'nullable|array',
            'permisos.*' => 'integer|exists:permissions,id',
        ], [
            'name.required' => 'El nombre del rol es requerido',
            'name.unique' => 'Este rol ya existe',
        ]);

        // Crear el rol (asume el guard por defecto, usualmente 'web')
        $role = Role::create(['name' => $validated['name']]);
        
        // Si no se envían permisos, sincroniza un array vacío (limpia/no asigna nada)
        $role->syncPermissions($request->input('permisos', []));

        return redirect()
            ->route('roles')
            ->with('success', 'Rol creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar rol
     */
    public function edit($id): Response
    {
        // Trae el rol con sus permisos actuales para marcarlos en el frontend
        $role = Role::with('permissions')->findOrFail($id);
        $permisos = Permission::all();
        
        return Inertia::render('roles/edit', [
            'rol' => $role,
            'permisos' => $permisos,
        ]);
    }

    /**
     * Actualizar rol y sus permisos
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permisos' => 'nullable|array',
            'permisos.*' => 'integer|exists:permissions,id',
        ], [
            'name.required' => 'El nombre del rol es requerido',
            'name.unique' => 'Este rol ya existe',
        ]);

        $role->update(['name' => $validated['name']]);
        
        // Al usar de esta manera, si el usuario desmarca todos los permisos, 
        // se removerán correctamente de la base de datos.
        $role->syncPermissions($request->input('permisos', []));

        return redirect()
            ->route('roles')
            ->with('success', 'Rol actualizado exitosamente.');
    }

    /**
     * Alternar el estado activo/inactivo de un rol
     */
    public function estado(Request $request, $id): RedirectResponse
    {
        Log::info("Actualizando estado del rol con ID: $id y datos: ", $request->all());
        
        $role = Role::findOrFail($id);

        $data = $request->validate([
            'active' => 'required|integer|in:0,1',
        ], [], [
            'active' => 'Estado',
        ]);

        try {
            // Evitamos MassAssignmentException asignando directamente a la propiedad
            $role->active = $data['active'];
            $role->save();

            return back()->with('success', 'Estado actualizado exitosamente.');

        } catch (\Exception $e) {
            Log::error("Error al actualizar estado del rol: " . $e->getMessage());
            return back()
                ->withErrors(['general' => 'Error al actualizar el estado en el servidor.']);
        }
    }
}