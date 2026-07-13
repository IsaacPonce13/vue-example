<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class Catalogos extends Authenticatable
{
    protected $table = 'ca_dependencias';

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;


    // protected $fillable = [
    //     'name',
    //     'primer_apellido',
    //     'segundo_apellido',
    //     'numero_control',
    //     'id_dependencia',
    //     'email',
    //     'password',
    //     'active',
    // ];
}
