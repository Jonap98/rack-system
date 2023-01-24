<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledModel extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'V_Scheduled_Material';
    protected $fillable = [
        'modeloIngenieria',
        'Parte',
        'ParteNombre',
        'Linea',
        'QtyProgram',
        'Turno',
        'Sec',
        'Fecha',
        'Fecha_registro',
        'Sesion',
        'Uso',
        'UM',
        'Necesario',
    ];
}
