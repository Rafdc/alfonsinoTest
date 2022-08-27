<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Ordini extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'ordini';

    protected $fillable = [
        'id_partner',
        'totale',
        'id_cliente'
    ];
}
