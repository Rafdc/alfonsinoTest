<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Clienti extends Model implements AuthAuthenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Authenticatable;

    protected $table = 'clienti';

    protected $fillable = [
        'nome',
        'cognome',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
