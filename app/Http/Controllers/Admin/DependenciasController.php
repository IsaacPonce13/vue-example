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
use App\Models\Dependencia;


class DependenciasController extends Controller
{
    public function index()
    {
        $dependencias = Dependencias::with('descripcions')->get();
        return Inertia::render('usuarios/index', compact('users'));
    }
}