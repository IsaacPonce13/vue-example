<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class Dependencias extends Authenticatable
{
    protected $table = 'ca_dependencias';

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;


    protected $fillable = [
        'descripcion',
        'adscripcion',
        'id_padre',
        'metadatos',
        'shortname',
        'tipo_dependencia',
        'ubicacion',
        'telefono',
        'email',
        'horarios',
        'active',
    ];
}
