<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $table = 'alp_clientes';
    protected $fillable = [
        'ID_CLIENTE',
        'NOMBRE_CLIENTE'
    ];
}