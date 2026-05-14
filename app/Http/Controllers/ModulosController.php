<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ModulosController extends Controller
{
    public function index()
    {
        return Inertia::render('modulos/index');
    }
}
