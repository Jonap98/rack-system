<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensoresModel;

class SensoresController extends Controller
{
    public function index() {
        $sensores = SensoresModel::select(
            'id',
            'sensor',
            'num_parte',
            'ubicacion_linea',
        )
        ->get();

        return view('sensores.index', array('sensores' => $sensores));
    }

    public function store(Request $request) {
        $sensor = new SensoresModel();

        $sensor->sensor = $request->sensor;
        $sensor->num_parte = $request->num_parte;
        $sensor->ubicacion_linea = $request->ubicacion_linea;

        $sensor->save();

        return back()->with('success', 'El sensor fue registrado exitosamente');
    }

    public function getPart(String $sensor) {
        $data = SensoresModel::select(
            'num_parte',
        )
        ->where('sensor', $sensor)
        ->first();

        return response([
            'num_parte' => $data->num_parte
        ]);
    }
}
