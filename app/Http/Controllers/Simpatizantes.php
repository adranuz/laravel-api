<?php

namespace App\Http\Controllers;

use App\Coordinador;
use App\Models\PadronElectoral;
use App\Models\SimpatizantesCandidato;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Simpatizantes extends Controller
{

    public function registroPoblacion(Request $request)
    {
        try {

            $getDatos = DB::table('secciones_colonias')->where("id", $request->seccion)->first();
            # conversion de secciones colonias a secciones, parche...
            $seccionId = DB::table('secciones')->where('seccion',$getDatos->seccion)->first();
            $localidad = DB::table('localidades_secciones')
                ->where("clave_entidad_federal", $getDatos->clave_entidad_federal)
                ->where("clave_municipio", $getDatos->clave_municipio)
                ->where("seccion", $getDatos->seccion)
                ->first();

            $simpatizante = PadronElectoral::where("cve_elector",'like',"%".$request->cve_elector."%")->first();
           /* return 
            if($simpatizante != null){
                return response()->json(202, 200);
            }*/
            $data = $request->except('seccion', 'cve_elector', 'simpatiza', 'year', 'month', 'day', 'data');
            $dataCandidato = $request->only('simpatiza', 'data','assign_type','assign_id');
            $dataCandidato["created_by"] = $request->user()->id;
            $dataCandidato["seccion_id"] = $seccionId->id;//$getDatos->id;
            $data["seccion"] = $getDatos->seccion;
            $data["entidad"] = $getDatos->clave_entidad_federal;
            $data["municipio"] = $getDatos->clave_municipio;
            $data["localidad"] = $localidad->localidad;
            $data["nacimiento"] = $request->year . $request->month . $request->day;
            $data["created_by"] = $request->user()->id;

            $claveElector = $request->cve_elector;
            $exist = PadronElectoral::where("cve_elector", "like", $claveElector . "%")->get();
            $claveElector = $claveElector . "000";
            if (count($exist)>0) $claveElector = $exist[0]["cve_elector"];
            if($request->user()->coordinador == "S"){
                $coordinador = Coordinador::find($request->user()->candidato_id);
                $idcandidato = $coordinador->candidato_id;
            }else{
                $idcandidato = $request->user()->candidato_id;
            }

            $row = PadronElectoral::updateOrCreate(['cve_elector' => $claveElector], $data);
            SimpatizantesCandidato::updateOrCreate(
                [
                    'candidato_id' => $idcandidato,
                    'padronelectoral_id' => $row->id,
                ],
                $dataCandidato
            );
            return response()->json("Ok", 200);
        } catch (\Throwable $th) {
            return response()->json(["error"=>$th->getMessage()], 404);
        }
    }

    public function compruebaClave(Request $request){
        
        $simpatizante =  DB::table('padronelectoral')
                                    ->join('simpatizantes_candidatos','padronelectoral.id','=','simpatizantes_candidatos.padronelectoral_id')
                                    ->where('padronelectoral.cve_elector',$request->cve_elector)
                                    ->first();

        if($simpatizante === null){
            $simpatizante = DB::table('padronelectoral')
            ->where('padronelectoral.cve_elector',$request->cve_elector)
            ->first();
        }
        
        if($simpatizante != null){
            return response()->json($simpatizante);
        }


    }

    public function registroSimpatizante(Request $request)
    {
        Validator::make($request->all(), [
            'simpatizante'         => 'required|integer|exists:padronelectoral,id',
            'simpatiza'         => 'required|string',
            'seccion'      => 'required|integer|exists:secciones,id',
            'data'      => 'required|json'
        ])->validate();
        
        $input= $request->all();
        $dataCandidato = $request->only('simpatiza', 'data','assign_type','assign_id');
        $dataCandidato["created_by"] = $request->user()->id;
        $dataCandidato["seccion_id"] = $request->seccion;
        SimpatizantesCandidato::updateOrCreate(
            [
                'candidato_id' => $request->candidato_id,
                'padronelectoral_id' => $request->simpatizante,
            ],
            $dataCandidato
        );
        return response()->json("Ok", 200);
    }

    public function busquedaPadron(Request $request){

        $param['searchType'] = $request->searchType;

        $params = $request->query();

        if($param['searchType'] === 'multiple'){

            unset($params['searchType']);
            
                $query = DB::table('padronelectoral')
                            ->leftJoin('simpatizantes_candidatos','padronelectoral.id','=','simpatizantes_candidatos.padronelectoral_id');

                foreach($params as $key => $value){

                    if(isset($params[$key]) && $params[$key] !== null){
                            $query->where($key,'like','%'.$value.'%');
                    }
                }

                $padron = $query->orderBy('municipio','asc')->paginate(20);            
            return response()->json($padron);
        }
    }

    public function updatePoblacion(Request $request, string $cve){
        
        
        $padron = PadronElectoral::where('cve_elector',$cve)->first();
        $response = ['data' => [],
                     'message' => 'algo salio mal',
                     'status' => 'error'];
        
        if($padron != null){
            $input = $request->except('seccion');

            $getDatos = DB::table('secciones_colonias')->where("id", $request->seccion)->first();
            # conversion de secciones colonias a secciones, parche...
            $seccionId = DB::table('secciones')->where('seccion',$getDatos->seccion)->first();
            
            $simpatizanteCandidato = SimpatizantesCandidato::where('padronelectoral_id',$padron->id)->first();
            $parsedJson = json_decode($simpatizanteCandidato->data,1);
            $parsedJson['telefonos'] = [ $input['telefono'] ];
            $parsedJson['redsocial'] = $input['redsocial'];
            $simpatizanteCandidato->data = json_encode($parsedJson);
            $padron->fill($input);
            $padron->seccion = $seccionId->seccion;
            $padron->save();
            $simpatizanteCandidato->save();
            $response = ['data' => $padron,
                         'message' => 'Actualizado correctamente',
                         'status' => 'ok'];
        }
        
        return response()->json($response);
    }
}
