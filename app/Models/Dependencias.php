<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class Dependencias extends Authenticatable
{
    protected $table = 'ca_dependencias';

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;


    protected $fillable = [
        'id',
        'descripcion',
        'adscripcion',
        'id_padre',
        'metadatos',
        'shortname',
        'tipo_dependencia',
        'calle_numero',
        'colonia',
        'id_municipio',
        'codigo_postal',
        'latidud',
        'longitud',
        'telefono',
        'email',
        'horarios',
        'active',
    ];
}
