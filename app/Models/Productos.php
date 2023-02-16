<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;
    protected $table = 'alp_productos';
    protected $fillable = [
        'ID_PRODUCTO',
        'NOMBRE_PRODUCTO',
        'PRECIO'
    ];
}