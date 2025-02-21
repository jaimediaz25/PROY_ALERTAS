<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'nombre', 'apellidos', 'edad', 'email', 'password', 'rol', 'intentos_fallidos', 'bloqueado_hasta'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'bloqueado_hasta' => 'datetime',
    ];  
}
