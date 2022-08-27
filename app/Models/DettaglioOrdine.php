<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DettaglioOrdine extends Model
{
    use HasFactory;

    protected $table = 'dettaglio_ordine';

    protected $fillable = [
        'id_prodotto',
        'id_ordine'
    ];
}
