<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\SimpatizanteCandidatoExport;
use App\Exports\layoutPadron;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function exportarEncuestaBy(Request $request, int $candidato_id){

        $headers = [];
        $simpatizantes = DB::table('simpatizantes_candidatos')
                            ->join('padronelectoral','simpatizantes_candidatos.padronelectoral_id','=','padronelectoral.id')
                            ->join('municipios','municipios.id','=','padronelectoral.municipio')
                            ->leftjoin('demarcaciones','demarcaciones.id','=','simpatizantes_candidatos.data->demarcacion_id')
                            ->select(   'padronelectoral.cve_elector',
                                        'padronelectoral.nombre',
                                        'padronelectoral.paterno',
                                        'padronelectoral.materno',                                        
                                        'padronelectoral.colonia',
                                        'padronelectoral.calle',
                                        'padronelectoral.seccion',
                                        'padronelectoral.municipio',
                                        'simpatizantes_candidatos.data->demarcacion_id as demarcacion',
                                        'simpatizantes_candidatos.data->participacion as participacion',
                                        'simpatizantes_candidatos.data->redsocial as redsocial',
                                        'simpatizantes_candidatos.data->telefonos as telefonos',
                                        'municipios.nombre as nombre_municipio',
                                        'demarcaciones.demarcacion',
                                        'simpatizantes_candidatos.created_at as fecha_captura'
                                        )
                            ->where('simpatizantes_candidatos.candidato_id',$candidato_id)
                            ->where('simpatizantes_candidatos.data','like','%"participacion":"'.$request->type.'"%')
                            ->orderBy('padronelectoral.seccion','asc')
                            ->get();
        if(!$simpatizantes->isEmpty()){
            $headers = array_keys(json_decode(json_encode($simpatizantes[0]) ,true));
        }
    
        return Excel::download(new SimpatizanteCandidatoExport(["data" => $simpatizantes, "headers" => $headers]), 'simpatizantes_type_'.$request->type .'.xlsx');
                                
    }

    public function descargarLayout(int $candidato_id){
         return Excel::download(new layoutPadron($candidato_id), 'preparado'.$candidato_id .'.xlsx');
    }
}
