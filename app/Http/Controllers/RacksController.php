<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\RacksModel;

class RacksController extends Controller
{
    public function index() {
        $racks = RacksModel::select(
            'num_parte',
            'ubicacion_linea',
            'sensor_min',
            'sensor_max',
        )
        ->get();

        return view('racks.index', array('racks' => $racks));
    }

    public function store(Request $request) {
        $rack = new RacksModel();

        $rack->num_parte = $request->num_parte;
        $rack->ubicacion_linea = $request->ubicacion_linea;
        $rack->sensor_min = '0';
        $rack->sensor_max = '0';

        $rack->save();

        return back()->with('success', 'El rack fue registrado exitosamente');
    }

    public function update(Request $request) {

        $rack = RacksModel::where('num_parte', $request->num_parte)->update([
            'sensor_min' => $request->sensor_min,
            'sensor_max' => $request->sensor_max
        ]);

       return response([
        'msg' => 'Rack actualizado exitosamente',
        'data' => $rack
       ]);

    }

    public function getApi() {
        $racks = RacksModel::select(
            'num_parte',
            'ubicacion_linea',
            'sensor_min',
            'sensor_max',
        )
        ->get();

        return response([
            'msg' => 'OK',
            'data' => $racks
        ]);
    }

    public function updateGet(String $num_parte, String $sensor_min, String $sensor_max) {

        RacksModel::where('num_parte', $num_parte)->update([
            'sensor_min' => $sensor_min,
            'sensor_max' => $sensor_max
        ]);

        return response([
            'num_part' => $num_parte,
            'min' => $sensor_min,
            'max' => $sensor_max,
            'msg' => 'Rack actualizado exitosamente',
            // 'data' => $rack
        ]);

    }
}
