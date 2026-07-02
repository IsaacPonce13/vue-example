<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('the roles index page exposes permissions under the expected prop for the modal', function () {
    $user = User::factory()->create([
        'primer_apellido' => 'Apellido',
        'numero_control' => '123456',
        'id_dependencia' => 1,
    ]);

    $this->actingAs($user);

    Permission::create(['name' => 'roles.view']);
    $role = Role::create(['name' => 'Admin']);
    $role->givePermissionTo('roles.view');

    $response = $this->get(route('roles.index'));

    $response->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('permissions', 1)
            ->where('permissions.0.name', 'roles.view')
            ->has('roles', 1)
        );
});
