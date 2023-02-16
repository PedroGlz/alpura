<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas_Detalle extends Model
{
    use HasFactory;
    protected $table = 'alp_facturas_detalle';
    protected $fillable = [
        'ID_FACTURA_DETALLE',
        'ID_FACTURA',
        'ID_PRODUCTO',
        'CANTIDAD',
        'IMPORTE'
    ];
}