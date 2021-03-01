<?php

namespace App\Http\Controllers\Busquedas;

use App\Coordinador;
use App\Demarcaciones;
use App\Models\User;
use App\SimpatizanteCandidato;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PadronElectoral;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BusquedasCandidatos extends Controller
{

    public function getSimpatizan(int $candidato_id){
        /*$simpatizantes = SimpatizanteCandidato::where('candidato_id',$candidato_id)                                    
                                                ->first();*/
        $people = [];                                                
        $simpatizantes = SimpatizanteCandidato::with('people:padronelectoral.nombre,padronelectoral.cve_elector,padronelectoral.id')
                                                ->where('candidato_id', $candidato_id)
                                                ->get();
        
        
        foreach($simpatizantes as $simpatizante){

            $people[]=$simpatizante->people;
        }

        return response()->json(["data" => $people]);        
    }
    public function getCoordinadores(int $candidato_id){

        $coordinadores = Coordinador::where('candidato_id',$candidato_id)                                      
                                      ->get();

        return response()->json(["data" => $coordinadores]);
    }

    public function entidadesFederativas()
    {
        $data = DB::table('entidades_federales')
            ->get(['id', 'nombre'])
            ->toArray();

        return response()->json(["data" => $data], 200);
    }

    public function getColonias($cve_municipio)
    {
        $data = DB::table('secciones_colonias')
            ->where('clave_municipio', $cve_municipio)
            ->groupBy('nombre')
            ->get(['nombre'])
            ->toArray();

        return response()->json(["data" => $data], 200);
    }

    public function getMunicip($entidad)
    {
        $data = DB::table('municipios')
            ->where('clave_entidad_federal', $entidad)
            ->get(["id",'nombre'])
            ->toArray();

        return response()->json(["data" => $data], 200);
    }

    public function getColoniasSecciones($cve_municipio, $colonia)
    {
        $data = DB::table('secciones_colonias')
            ->where('clave_municipio', $cve_municipio)
            ->where('nombre', $colonia)
            ->get(['id', 'seccion'])
            ->toArray();

        return response()->json(["data" => $data], 200);
    }

    public function getSeccionesUsuario(Request $request,$id)
    {
        $user = User::find($id);
        if($user->coordinador == "S"){
            $candidato =  Coordinador::find($user->candidato_id);
            $municipios = json_decode($candidato->configuracion, true)['registros'];
            $arr = explode("-",$municipios);
            if(count($arr) == 2 || count($arr) == 3){
                $muni = $arr[1];
                $data = DB::table('secciones')
                    ->where('clave_municipio', $muni)
                    ->get(['id', 'seccion'])
                    ->toArray();
            }elseif (count($arr) == 1){
                $entidad = $arr[0];
                $data = DB::table('secciones')
                    ->where('clave_entidad_federal', $entidad)
                    ->get(['id', 'seccion'])
                    ->toArray();
            }

            if($user->co_de == "S"){
                $demarcacion_id = $user->demarcacion;
                $demarcacion = Demarcaciones::find($demarcacion_id);
                $data = DB::table('secciones')
                    ->where('clave_municipio', $demarcacion->municipio_id)
                    ->get(['id', 'seccion'])
                    ->toArray();
            }
            return response()->json(["data" => $data], 200);
        }else{
            $candidato = DB::table("candidato")->find($user->candidato_id);
            $muns = json_decode($candidato->configuacion, true)['registros'];
            $arr = explode("-",$muns);
            if(count($arr) == 2 || count($arr) == 3){
                $muni = $arr[1];
                $data = DB::table('secciones')
                    ->where('clave_municipio', $muni)
                    ->get(['id', 'seccion'])
                    ->toArray();
            }elseif (count($arr) == 1){
                $entidad = $arr[0];
                $data = DB::table('secciones')
                    ->where('clave_entidad_federal', $entidad)
                    ->get(['id', 'seccion'])
                    ->toArray();
            }
            return response()->json(["data" => $data], 200);
        }

    }

    public function getDemarcacionesUsuario(Request $request,$id)
    {
        $user = User::find($id);
        if($user->coordinador == "S"){
            $candidato =  Coordinador::find($user->candidato_id);
            $municipios = json_decode($candidato->configuracion, true)['registros'];
            $arr = explode("-",$municipios);

            if(count($arr) == 2 || count($arr) == 3){
                $muni = $arr[1];
                $data = DB::table('demarcaciones')
                    ->where('municipio_id', $muni)
                    ->get(['id', 'demarcacion', "secciones"])
                    ->toArray();
            }elseif (count($arr) == 1){
                $entidad = $arr[0];
                $data = DB::table('demarcaciones')
                    ->get(['id', 'demarcacion', "secciones"])
                    ->toArray();
            }

            if($user->co_de == "S"){
                $ar = explode(":",$arr[0]);
                $data = DB::table('demarcaciones')->find($ar[1]);
                $data = DB::table('demarcaciones')
                    ->where('municipio_id', $data->municipio_id)
                    ->get(['id', 'demarcacion', "secciones"])
                    ->toArray();
            }

            return response()->json(["data" => $data], 200);
        }else{
            $candidato = DB::table("candidato")->find($user->candidato_id);
            $muns = json_decode($candidato->configuacion, true)['registros'];
            $arr = explode("-",$muns);
            if(count($arr) == 2 || count($arr) == 3){
                $muni = $arr[1];
                $data = DB::table('demarcaciones')
                    ->where('municipio_id', $muni)
                    ->get(['id', 'demarcacion', "secciones"])
                    ->toArray();
            }elseif (count($arr) == 1){
                $entidad = $arr[0];
                $data = DB::table('demarcaciones')
                    ->get(['id', 'demarcacion', "secciones"])
                    ->toArray();
            }
            return response()->json(["data" => $data], 200);
        }

    }

    public function candidatoEntidades(Request $request, $id)
    {
        //if ($request->user()->candidato_id != $id) return response()->json(["data" => "No tiene Permisos"], 401);

        Validator::make(array_merge($request->all(), ["id" => $id]), [
            'id' => 'required|integer|exists:candidato,id'
        ])->validate();

        $candidato =  DB::table('candidato')->find($id);
        $configCandidato = json_decode($candidato->configuacion, true)['registros'];
        $arr = explode("-",$configCandidato."");

        $data = DB::table('entidades_federales')
            ->where('id', $arr[0])
            ->get(['id', 'nombre'])
            ->toArray();

        return response()->json(["data" => $data], 200);
    }


    public function candidatoMunicipios(Request $request, $id, $entidad)
    {
        //if ($request->user()->candidato_id != $id) return response()->json(["data" => "No tiene Permisos"], 401);

        $user = User::find($request->id);

        if($user->coordinador == "S"){
            $candidato =  Coordinador::find($user->candidato_id);
            $municipios = json_decode($candidato->configuracion, true)['registros'];
            $arr = explode("-",$municipios);
            if(count($arr) == 2 || count($arr) == 3){
                $muni = $arr[1];
                $data = DB::table('municipios')
                    ->where('clave_entidad_federal', $entidad)
                    ->where('clave_municipio', $muni)
                    ->get(['id', 'clave_municipio', 'nombre'])
                    ->toArray();
            }elseif (count($arr) == 1){
                $ent = $arr[0];
                $data = DB::table('municipios')
                    ->where('clave_entidad_federal', $ent)
                    ->get(['id', 'clave_municipio', 'nombre'])
                    ->toArray();
            }
            if($user->co_de == "S"){
                $demarcacion_id = $user->demarcacion;
                $demarcacion = Demarcaciones::find($demarcacion_id);
                $data = DB::table('municipios')
                    ->where('clave_municipio', $demarcacion->municipio_id)
                    ->get(['id', 'clave_municipio', 'nombre'])
                    ->toArray();
            }

            return response()->json(["data" => $data], 200);
        }else {
            $candidato =  DB::table('candidato')->find($id);
            $municipios = json_decode($candidato->configuacion, true)['registros'];
            $arr = explode("-",$municipios."");
            if(count($arr) == 2 || count($arr) == 3){
                $muni = $arr[1];
                $data = DB::table('municipios')
                    ->where('clave_entidad_federal', $entidad)
                    ->where('clave_municipio', $muni)
                    ->get(['id', 'clave_municipio', 'nombre'])
                    ->toArray();
            }elseif (count($arr) == 1){
                $ent = $arr[0];
                $data = DB::table('municipios')
                    ->where('clave_entidad_federal', $ent)
                    ->get(['id', 'clave_municipio', 'nombre'])
                    ->toArray();
            }

            return response()->json(["data" => $data], 200);
        }
    }

    public function candidatoSecciones(Request $request, $id, $entidad, $municipio_id)
    {
        //TODO: coordinador en select de seccion poblacion
        $user = User::find($request->id);
        $demarcacion=false;
        $seccs = [];
        if($user->co_de == "S"){
            $demarcaciones = Demarcaciones::find($user->demarcacion);
            $seccs = explode(",",$demarcaciones->secciones);
            $demarcacion = true;
        }
        if($user->coordinador == "S"){
            $c = Coordinador::find($user->candidato_id);
            $coordinador = true;
        }else {
            $c = null;
            $coordinador = false;
        }
        if($coordinador){
           if($demarcacion){
               $candidato =  DB::table('candidato')->find($id);
               $municipio =  DB::table('municipios')->find($municipio_id);

               $data = DB::table('secciones')
                   ->where('clave_entidad_federal', $entidad)
                   ->where('clave_municipio', $municipio_id)
                   ->whereIn('seccion', $seccs)
                   ->get(['id', 'seccion', 'tipo'])
                   ->toArray();
               $seccionid = DB::table("secciones")->where('clave_entidad_federal', $entidad)
                   ->where('clave_municipio', $municipio_id)->where("seccion",$seccs[0])->first();
               return response()->json(["data" => $data,"seccion"=>$seccionid->id, "coordinador"=>true], 200);
           }else{
               $sec = json_decode($c->configuracion, true)['registros'];
               $arr = explode("-",$sec);
               if(count($arr) == 1){
                   $ent = $arr[0];
                   $data = DB::table('secciones')
                       ->where('clave_entidad_federal', $ent)
                       ->where('clave_municipio', $municipio_id)
                       ->get(['id', 'seccion', 'tipo'])
                       ->toArray();
                   $seccionid = DB::table("secciones")->where('clave_entidad_federal', $entidad)
                       ->where('clave_municipio', $municipio_id)->where("seccion",$sec)->first();
                   return response()->json(["data" => $data, "coordinador"=>true], 200);
               }
               if(count($arr) == 2){
                   $muni = $arr[1];
                   $data = DB::table('secciones')
                       ->where('clave_entidad_federal', $entidad)
                       ->where('clave_municipio', $muni)
                       ->get(['id', 'seccion', 'tipo'])
                       ->toArray();
                   $seccionid = DB::table("secciones")->where('clave_entidad_federal', $entidad)
                       ->where('clave_municipio', $municipio_id)->where("seccion",$sec)->first();
                   return response()->json(["data" => $data, "coordinador"=>true], 200);
               }
               if(count($arr) == 3){
                   $sec = $arr[2];
                   $data = DB::table('secciones')
                       ->where('clave_entidad_federal', $entidad)
                       ->where('clave_municipio', $municipio_id)
                       ->where('seccion', $sec)
                       ->get(['id', 'seccion', 'tipo'])
                       ->toArray();
                   $seccionid = DB::table("secciones")->where('clave_entidad_federal', $entidad)
                       ->where('clave_municipio', $municipio_id)->where("seccion",$sec)->first();
                   return response()->json(["data" => $data,"seccion"=>$seccionid->id, "coordinador"=>true], 200);
               }

               //if ($request->user()->candidato_id != $id) return response()->json(["data" => "No tiene Permisos"], 401);

               /*Validator::make(array_merge($request->all(), ["id" => $id, "entidad" => $entidad, "municipio_id" => $municipio_id]), [
                   'id' => 'required|integer|exists:candidato,id',
                   'entidad' => 'required|integer',
                   'municipio_id' => 'required|integer'
               ])->validate();*/

               $candidato =  DB::table('candidato')->find($id);
               $municipio =  DB::table('municipios')->find($municipio_id);
               //$municipios = json_decode($candidato->configuacion, true)['registros'][$entidad];

               //if (!in_array($municipio->clave_municipio, $municipios)) return response()->json(["data" => "No tiene Permisos del municipio"], 401);

               $data = DB::table('secciones')
                   ->where('clave_entidad_federal', $entidad)
                   ->where('clave_municipio', $municipio_id)
                   ->where('seccion', $sec)
                   ->get(['id', 'seccion', 'tipo'])
                   ->toArray();
               $seccionid = DB::table("secciones")->where('clave_entidad_federal', $entidad)
                   ->where('clave_municipio', $municipio_id)->where("seccion",$sec)->first();
               return response()->json(["data" => $data,"seccion"=>$seccionid->id, "coordinador"=>true], 200);
           }
        }else{
            //if ($request->user()->candidato_id != $id) return response()->json(["data" => "No tiene Permisos"], 401);

            /*Validator::make(array_merge($request->all(), ["id" => $id, "entidad" => $entidad, "municipio_id" => $municipio_id]), [
                'id' => 'required|integer|exists:candidato,id',
                'entidad' => 'required|integer',
                'municipio_id' => 'required|integer'
            ])->validate();*/

            $candidato =  DB::table('candidato')->find($id);
            $municipio =  DB::table('municipios')->find($municipio_id);
            $municipios = json_decode($candidato->configuacion, true)['registros'];
            $arr = explode("-",$municipios);
            $data = [];
            if(count($arr) == 1){
                $ent = $arr[0];
                $data = DB::table('secciones')
                    ->where('clave_entidad_federal', $ent)
                    ->where('clave_municipio', $municipio_id)
                    ->get(['id', 'seccion', 'tipo'])
                    ->toArray();
            }
            if(count($arr) == 2){
                $muni = $arr[1];
                $data = DB::table('secciones')
                    ->where('clave_entidad_federal', $entidad)
                    ->where('clave_municipio', $muni)
                    ->get(['id', 'seccion', 'tipo'])
                    ->toArray();
            }
            if(count($arr) == 3){
                $sec = $arr[2];
                $data = DB::table('secciones')
                    ->where('clave_entidad_federal', $entidad)
                    ->where('clave_municipio', $municipio_id)
                    ->where('seccion', $sec)
                    ->get(['id', 'seccion', 'tipo'])
                    ->toArray();
            }
            //if (!in_array($municipio->clave_municipio, $municipios)) return response()->json(["data" => "No tiene Permisos del municipio"], 401);

            $data = DB::table('secciones')
                ->where('clave_entidad_federal', $entidad)
                ->where('clave_municipio', $municipio_id)
                ->get(['id', 'seccion', 'tipo'])
                ->toArray();

            return response()->json(["data" => $data,"coordinador"=>false], 200);
        }
    }

    public function candidatoPoblacion(Request $request, $id, $entidad, $municipio_id, $seccion_id)
    {
        //TODO: coordinador busqueda en tabla poblacion

        $user = User::find($request->id);
        $demarcacion=false;
        $seccs = [];
        if($user->co_de == "S"){
            $demarcaciones = Demarcaciones::find($user->demarcacion);
            $seccs = explode(",",$demarcaciones->secciones);
            $demarcacion = true;
        }
        if($user->coordinador == "S"){
            $c = Coordinador::find($user->candidato_id);
            $coordinador = true;
        }else {
            $c = null;
            $coordinador = false;
        }
        //if ($request->user()->candidato_id != $id) return response()->json(["data" => "No tiene Permisos"], 401);

        $candidato =  DB::table('candidato')->find($id);
        $seccion =  DB::table('secciones')->find($seccion_id);
        $municipio = null;
        if($municipio_id != "null"){
            $municipio =  DB::table('municipios')->find($municipio_id);
        }


        //if (!in_array($municipio->clave_municipio, $municipios)) return response()->json(["data" => "No tiene Permisos del municipio"], 401);

        $userString = $candidato->id;
        if($coordinador) {
            if($demarcacion){
                $data = PadronElectoral::leftjoin("simpatizantes_candidatos as sc", function ($join) use ($userString) {
                    $join->on("sc.padronelectoral_id", "padronelectoral.id")
                        ->where("sc.candidato_id", $userString);
                })
                    ->where("entidad", $entidad)
                    ->where("municipio", $municipio->clave_municipio)
                    ->whereIn("seccion", $seccs);
            }else {
                $sec = json_decode($c->configuracion, true)['registros'];
                $arr = explode("-",$sec);
                if(count($arr) == 1){
                    $enti = $arr[0];
                    $data = PadronElectoral::leftjoin("simpatizantes_candidatos as sc", function ($join) use ($userString) {
                        $join->on("sc.padronelectoral_id", "padronelectoral.id")
                            ->where("sc.candidato_id", $userString);
                    })
                        ->where("entidad", $enti);
                }
                if(count($arr) == 2){
                    $muni = $arr[1];
                    $data = PadronElectoral::leftjoin("simpatizantes_candidatos as sc", function ($join) use ($userString) {
                        $join->on("sc.padronelectoral_id", "padronelectoral.id")
                            ->where("sc.candidato_id", $userString);
                    })
                        ->where("entidad", $entidad)
                        ->where("municipio", $muni);
                }
                if(count($arr) == 3){
                    $sec = $arr[2];
                    $data = PadronElectoral::leftjoin("simpatizantes_candidatos as sc", function ($join) use ($userString) {
                        $join->on("sc.padronelectoral_id", "padronelectoral.id")
                            ->where("sc.candidato_id", $userString);
                    })
                        ->where("entidad", $entidad)
                        ->where("municipio", $municipio->clave_municipio)
                        ->where("seccion", $sec);
                }

            }
        }else{
            $data = PadronElectoral::leftjoin("simpatizantes_candidatos as sc", function ($join) use ($userString) {
                $join->on("sc.padronelectoral_id", "padronelectoral.id")
                    ->where("sc.candidato_id", $userString);
            })
                ->where("entidad", $entidad);
                //->where("municipio", $municipio->clave_municipio);
        }
            if($municipio_id != "null"){
                $data->where("municipio", $municipio_id);
            }
            //dd($seccion_id);
            if($seccion_id != "null"){
                $seccion  = DB::table("secciones")->find($seccion_id);
                $data->where("seccion","LIKE", $seccion->seccion);
            }
           if($request->busqueda != "null"){
                //$data->where('cve_elector','LIKE', "%$request->busqueda%");
                $data->where(function ($query) use ($request){
                    $query->where('cve_elector','LIKE', "%$request->busqueda%")
                        ->orWhere(DB::raw('CONCAT_WS(" ", nombre, paterno, materno)'),'LIKE', "%$request->busqueda%")
                        ->orWhere("sc.data",'LIKE', "%$request->busqueda%")
                    ;
                });
           }

        $data = $data->select("padronelectoral.id", "nombre", "paterno", "materno", "calle", "num_ext", "colonia", "cp", "seccion", "sc.simpatiza","cve_elector","sc.data")->paginate(15);
        return response()->json(["data" => $data], 200);
    }
    
}
