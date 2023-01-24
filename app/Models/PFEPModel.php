<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PFEPModel extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'PFEP_supply';
    protected $fillable = [
        'folio',
        'part_number',
        'where_used_item',
        'where_used_line',
        'delivery_location',
        'route',
        'method_of_part_delivery',
        'max_units_per_route',
        'min_units_per_route',
        'route_pitch',
        'stop',
        'display_device',
        'n_tarjetas',
        'max_units_per_rack',
        'min_units_per_rack',
        'delivery_uom',

    ];
}
