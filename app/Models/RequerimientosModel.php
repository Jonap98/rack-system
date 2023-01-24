<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequerimientosModel extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'RACK_requerimientos';
    protected $fillable = [
        'id',
        'requerimientoGuid',
        'folio',
        'tipo_requerimiento',
        'parte',
        'area',
        'ubicacion_linea',
        'ruta',
        'cantidad_solicitada',
        'cantidad_surtida',
        'cantidad_recibida',
        'quien_solicita',
        'quien_entrega',
        'quien_recibe',
        'status',
        'created_at',
        'updated_at',
        'ubicacion_almacen',
        'cantidad_cajas',
        'descripcion',
        'en_transito',
        'folioCreado',
        'criticoCreado',
        'enTransitoCreado',
        'comentarios',
    ];
}
