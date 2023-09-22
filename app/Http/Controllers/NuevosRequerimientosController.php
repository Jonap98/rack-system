<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequerimientosModel;
use App\Models\RacksModel;
use Illuminate\Support\Str;
// use App\Models\Pfep_part_information;
use App\Models\PartInformationModel;
use App\Models\PFEPWarehouseModel;
use Illuminate\Support\Facades\DB;

class NuevosRequerimientosController extends Controller
{
    public function index() {
        return view('newFunctions');
    }

    public function getRackInfo() {

        // return response([
        //     'data' => ([
        //         'requerimientoGuid' => 'Str::uuid()',
        //         'folio' => '$request->folio',
        //         'tipo_requerimiento' => 'e-kanban',
        //         'parte' => '$lt[0]->part_number',        
        //     ])
        // ]);

        

        // ===========================================
        // Requerimientos rack
        // ===========================================
        $folioDuplicado = RequerimientosModel::select(
            'id',
            'folio'
        )
        // ->where('folio', $request->folio)
        ->where('comentarios', 'rack')
        ->orderBy('id', 'desc')
        ->first();

        // return response([
        //     'data' => $folioDuplicado
        // ]);

        $reqs = [];

        if($folioDuplicado) {
            // 1- Obtiene todos los registros de los racks
            $racks = RacksModel::select(
                'num_parte',
                'ubicacion_linea',
                'sensor_min',
                'sensor_max',
            )
            ->get();

            $list = array();

            // 2- Para cada uno de los números en los racks, verifica si están en el programa de producción
            foreach ($racks as $rack) {
                $complete_join = DB::connection('sqlsrv')
                    ->table('PFEP_supply as pfep')
                    ->leftJoin('V_Scheduled_Material as scheduled', 'scheduled.Parte', '=', 'pfep.part_number')
                    ->select(
                        'pfep.part_number',
                        'pfep.where_used_line',
                        'pfep.method_of_part_delivery',
                        'pfep.route',
                        'pfep.delivery_location',
                        'pfep.max_units_per_rack',
                        'pfep.min_units_per_rack',
                    )
                    ->where('pfep.method_of_part_delivery', 'SUPERMERCADO')
                    ->where('pfep.route', '1J')
                    // ->where('pfep.route', $request->ruta)
                    ->where('pfep.part_number', $rack->num_parte)
                    ->where('pfep.where_used_line', $rack->ubicacion_linea)
                    ->distinct()
                    ->get();

                if(count($complete_join) > 0) {
                    array_push($list, $complete_join);

                    $list[count($list)-1][0]->sensor_min = $rack->sensor_min;
                    $list[count($list)-1][0]->sensor_max = $rack->sensor_max;

                }
            }

            // 3- Calcular la cantidad que se va a pedir de cada material
            foreach ($list as $list_in_prod) {
                // Caso 1: Sin Stock
                // sensor_min = 0 y sensor_max = 0
                if($list_in_prod[0]->sensor_min == 0 && $list_in_prod[0]->sensor_max == 0) {
                    $list_in_prod[0]->cantidad = 0;
                }

                // Caso 2: Stock
                // sensor_min = 0 y sensor_max = 1
                if($list_in_prod[0]->sensor_min == 0 && $list_in_prod[0]->sensor_max == 1) {
                    $list_in_prod[0]->cantidad = $list_in_prod[0]->min_units_per_rack;
                }

                // Caso 3: No existe, error del sensor o del rack
                // sensor_min = 0 y sensor_max = 1
                if($list_in_prod[0]->sensor_min == 1 && $list_in_prod[0]->sensor_max == 1) {
                    $list_in_prod[0]->cantidad = 0;
                }
                
            }


            foreach ($list as $lt) {
                // $info = Pfep_part_information::select(
                $info = PartInformationModel::select(
                    'PART_DESCRIPTION as descripcion',
                )
                ->where('PART_NUMBER', $lt[0]->part_number)
                ->first();

                $warehouseInfo = PFEPWarehouseModel::select(
                    'D_PICK_LOCATION as ubicacion_almacen',
                )
                ->where('PART_NUMBER', $lt[0]->part_number)
                ->first();

                if($lt[0]->cantidad > 0) {

                    array_push($reqs, [
                        'folio' => $folioDuplicado->folio, // Test, no hay folio actual
                        'tipo_requerimiento' => 'e-kanban',
                        'parte' => $lt[0]->part_number,
                        'descripcion' => $info->descripcion,
                        'area' => $lt[0]->delivery_location, // PFEP_supply - delivery_location
                        'ubicacion_linea' => $lt[0]->where_used_line,
                        'ubicacion_almacen' => $warehouseInfo->ubicacion_almacen, // PFEP_warehouse - d_pick_location
                        'ruta' => $lt[0]->route,
                        'cantidad_solicitada' => $lt[0]->cantidad,
                        'quien_solicita' => '1J',
                        'status' => 'pendiente',
                        'max' => 2,
                        'min' => 1,
                        'folio_creado' => '2023-05-02 11:09',
                        'comentarios' => 'rack',
                        ]);
                        
                    // Jala ok - Prueba local storage
                    // array_push($reqs, [
                    //     // $requerimiento = Requerimientos::create([
                    //         'requerimientoGuid' => Str::uuid(),
                    //         // 'folio' => $request->folio,
                    //         'folio' => $folioDuplicado->folio, // Test, no hay folio actual
                    //         'tipo_requerimiento' => 'e-kanban',
                    //         'parte' => $lt[0]->part_number,
                    //         // 'area' => $request->area, // PFEP_supply - delivery_location
                    //         'area' => $lt[0]->delivery_location, // PFEP_supply - delivery_location
                    //         'ubicacion_linea' => $lt[0]->where_used_line,
                    //         'ubicacion_almacen' => $warehouseInfo->ubicacion_almacen, // PFEP_warehouse - d_pick_location
                    //         'ruta' => $lt[0]->route,
                    //         'cantidad_solicitada' => $lt[0]->cantidad,
                    //         // 'quien_solicita' => $request->quien_solicita,
                    //         'quien_solicita' => '1J',
                    //         'status' => 'pendiente',
                    //         'cantidad_surtida' => '',
                    //         'cantidad_recibida' => '',
                    //         'quien_entrega' => '',
                    //         'quien_recibe' => '',
                    //         'comentarios' => 'rack',
                    //     ]);

                    // Jala ok
                    // $requerimiento = Requerimientos::create([
                    //     'requerimientoGuid' => Str::uuid(),
                    //     'folio' => $request->folio,
                    //     'tipo_requerimiento' => 'e-kanban',
                    //     'parte' => $lt[0]->part_number,
                    //     // 'area' => $request->area, // PFEP_supply - delivery_location
                    //     'area' => $lt[0]->delivery_location, // PFEP_supply - delivery_location
                    //     'ubicacion_linea' => $lt[0]->where_used_line,
                    //     'ubicacion_almacen' => $warehouseInfo->ubicacion_almacen, // PFEP_warehouse - d_pick_location
                    //     'ruta' => $lt[0]->route,
                    //     'cantidad_solicitada' => $lt[0]->cantidad,
                    //     // 'quien_solicita' => $request->quien_solicita,
                    //     'quien_solicita' => '1J',
                    //     'status' => 'pendiente',
                    //     'cantidad_surtida' => '',
                    //     'cantidad_recibida' => '',
                    //     'quien_entrega' => '',
                    //     'quien_recibe' => '',
                    //     'comentarios' => 'rack',
                    // ]);

                }
            }
        }

        return response([
            'data' => $reqs
        ]);
    }
}
