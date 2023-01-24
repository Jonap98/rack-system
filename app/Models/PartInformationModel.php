<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartInformationModel extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'PFEP_part_information';
    protected $fillable = [
        'REG',
        'PART_NUMBER',
        'PART_DESCRIPTION',
    ];
}
