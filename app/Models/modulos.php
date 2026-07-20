<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class Modulos extends Authenticatable
{
    protected $table = 'ca_modulos';

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;


    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'detalle_type',
        'detalle_id',
        'contenido',
        'id_categoria',
        'tipo_modulo',
        'estado',
        'fecha_alta',
        'fecha_pub_programada',
        'fecha_baja',
    ];
}
