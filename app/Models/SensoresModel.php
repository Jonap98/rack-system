<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensoresModel extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'RACK_sensores';
    protected $fillable = [
        'sensor',
        'num_parte',
        'ubicacion_linea',
    ];
}
