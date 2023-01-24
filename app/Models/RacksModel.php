<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RacksModel extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'RACK_racks';
    protected $fillable = [
        'id',
        'num_parte',
        'ubicacion_linea',
        'sensor_min',
        'sensor_max'
    ];
}
