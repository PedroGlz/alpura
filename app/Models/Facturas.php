<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    use HasFactory;
    protected $table = 'alp_facturas';
    protected $primaryKey = 'ID_FACTURA';
    protected $fillable = [
        'ID_FACTURA',
        'ID_CLIENTE',
        'FOLIO',
        'FECHA_FACTURA',
        'TOTAL'
    ];
}