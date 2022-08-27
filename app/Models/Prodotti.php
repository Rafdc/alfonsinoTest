<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prodotti extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "prodotti";

    protected $fillable = [
        'external_id',
        'titolo',
        'foto'
    ];
}
