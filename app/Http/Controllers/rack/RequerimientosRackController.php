<?php

namespace App\Http\Controllers\rack;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RequerimientosModel;
use App\Models\RacksModel;
use App\Models\PFEPModel;
use App\Models\ScheduledModel;
use App\Models\PartInformationModel;
use App\Models\PFEPWarehouseModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RequerimientosRackController extends Controller
{
    public function index() {
        $requerimientos = RequerimientosModel::select(
            'id',
            'folio',
            'tipo_requerimiento',
            'created_at',
            'created_at',
            'ubicacion_linea',
            'parte',
            'ubicacion_linea',
            'cantidad_solicitada',
            'cantidad_surtida',
        )
        // ->where('tipo_requerimiento', 'Rack system')
        ->orderBy('id', 'desc')
        ->get();

        return view('requerimientos.index', array('requerimientos' => $requerimientos));
    }

    public function store(Request $request) {
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
                // ->where('pfep.part')
                ->where('pfep.method_of_part_delivery', 'SUPERMERCADO')
                ->where('pfep.route', $request->ruta)
                ->where('pfep.part_number', $rack->num_parte)
                ->where('pfep.where_used_line', $rack->ubicacion_linea)
                ->distinct()
                ->get();

            // $complete_join->another_property = 'Holis';
            if(count($complete_join) > 0) {
                array_push($list, $complete_join);

                $list[count($list)-1][0]->sensor_min = $rack->sensor_min;
                $list[count($list)-1][0]->sensor_max = $rack->sensor_max;

            }
        }

        // 3- Calcular la cantidad que se va a pedir de cada material
        foreach ($list as $list_in_prod) {
            // Caso 1: Stock menor del mínimo
            // sensor_min = 0 y sensor_max = 0
            if($list_in_prod[0]->sensor_min == 0 && $list_in_prod[0]->sensor_max == 0) {
                $list_in_prod[0]->cantidad = $list_in_prod[0]->max_units_per_rack -1;
                // $list_in_prod[0]->cantidad = 'Stock menor del mínimo';
            }

            // Caso 2: Stock mínimo
            // sensor_min = 0 y sensor_max = 0
            if($list_in_prod[0]->sensor_min == 1 && $list_in_prod[0]->sensor_max == 0) {
                $list_in_prod[0]->cantidad = $list_in_prod[0]->min_units_per_rack;
                // $list_in_prod[0]->cantidad = 'Stock mínimo';
            }

            // Caso 3: Stock completo, no solicitar material
            // sensor_min = 0 y sensor_max = 1
            if($list_in_prod[0]->sensor_min == 1 && $list_in_prod[0]->sensor_max == 1) {
                $list_in_prod[0]->cantidad = 0;
                // $list_in_prod[0]->cantidad = $list_in_prod[0]->min_units_per_rack;
                // $list_in_prod[0]->cantidad = 'Stock full';
            }
            

            // Caso 4: No existe, error del sensor o del rack
            // sensor_min = 0 y sensor_max = 1
            if($list_in_prod[0]->sensor_min == 0 && $list_in_prod[0]->sensor_max == 1) {
                $list_in_prod[0]->cantidad = 0;
                // $list_in_prod[0]->cantidad = 'NA';
            }
               
        }

        // Crear solicitud de material
        foreach ($list as $lt) {
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

                $requerimiento = RequerimientosModel::create([
                    'requerimientoGuid' => Str::uuid(),
                    'folio' => 1,
                    'tipo_requerimiento' => 'e-kanban',
                    'parte' => $lt[0]->part_number,
                    // 'area' => $request->area, // PFEP_supply - delivery_location
                    'area' => $lt[0]->delivery_location, // PFEP_supply - delivery_location
                    'ubicacion_linea' => $lt[0]->where_used_line,
                    'ruta' => $lt[0]->route,
                    'cantidad_solicitada' => $lt[0]->cantidad,
                    'cantidad_surtida' => 0,
                    'cantidad_recibida' => 0,
                    'quien_solicita' => 'JONA',
                    'quien_entrega' => '',
                    'quien_recibe' => '',
                    'status' => 'pendiente',
                    // 'ubicacion_almacen' => $request->ubicacion_almacen, // PFEP_warehouse - d_pick_location
                    'ubicacion_almacen' => $warehouseInfo->ubicacion_almacen, // PFEP_warehouse - d_pick_location
                    'cantidad_cajas' => 0,
                    'descripcion' => $info->descripcion,
                    'en_transito' => '',
                    'folioCreado' => '',
                    'criticoCreado' => '',
                    'enTransitoCreado' => '',
                    'comentarios' => '',
                ]);
            }
        }

        return back()->with('success', 'Requerimiento solicitado exitosamente');

    }
}
