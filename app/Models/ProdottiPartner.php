<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class ProdottiPartner extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes;

    protected $table = 'prodotti_partner';

    protected $fillable = [
        'partner_id',
        'prodotto_id',
        'prezzo'
    ];

}
