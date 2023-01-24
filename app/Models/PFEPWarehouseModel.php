<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PFEPWarehouseModel extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'PFEP_warehouse';
    protected $fillable = [
        'REG',
        'PART_NUMBER',
        'D_PICK_LOCATION',
    ];
}
