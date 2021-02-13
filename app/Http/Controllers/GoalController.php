<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goal;
use App\Models\User;
use App\Coordinador;
use App\Demarcaciones;
use App\Models\PadronElectoral;
use Illuminate\Support\Facades\DB;
class GoalController extends Controller
{
    public function store(Request $request, int $id){
        $input = $request->all();
        $input['created_by'] = $id;
        $data = Goal::create($input);
        return response()->json(["data" => $data], 202);
    }

    //obtiene metas que necesitan una seccion
    public function getMetasPorSeccion(Request $request,int $candidatoId){
        //$metas = Goal::whereCandidatoId($candidatoId)->get();

        $param = $request->goal_type;
       // return $param;
        $metas = DB::table("secciones")
            ->join('goals','secciones.id',"=",'goals.seccion_id')
            ->join("type_sympathizer","type_sympathizer.id","=",'goals.type_sympathizer_id')
            ->where("goals.candidato_id", $candidatoId)
            ->where("type_sympathizer.name", $param)
            ->get();

        return $metas;
    }
    
    public function getMetasPorDemarcacion(Request $request,int $candidatoId){
        //$metas = Goal::whereCandidatoId($candidatoId)->get();
        $user = User::find($request->id);
        $param = $request->goal_type;
        if($user->co_de == "S" ){

            $demarcacion = Demarcaciones::find($user->demarcacion);
            
            $metas = DB::table("demarcaciones")
            ->join('goals','demarcaciones.id',"=",'goals.demarcaciones_id')
            ->join("type_sympathizer","type_sympathizer.id","=",'goals.type_sympathizer_id')
            ->where("goals.demarcaciones_id", $demarcacion->id)
            ->where("goals.candidato_id", $candidatoId)
            ->where("type_sympathizer.name", $param)
            ->orderBy('goals.demarcaciones_id','asc')
            ->get();
            return $metas;
        }else{

        $metas = DB::table("demarcaciones")
        ->join('goals','demarcaciones.id',"=",'goals.demarcaciones_id')
        ->join("type_sympathizer","type_sympathizer.id","=",'goals.type_sympathizer_id')
        ->where("goals.candidato_id", $candidatoId)
        ->where("type_sympathizer.name", $param)
        ->orderBy('goals.demarcaciones_id','asc')
        ->get();

    return $metas;
        }

    }
    
    
    public function getSimpatizantesMetasDemarcacion($candidatoId,$entidadId,$municipioId, Request $request){
        $user = User::find($request->id);
        $goal_type = $request->goal_type;
        $total_demarcaciones = [];
        $nombres_demarcaciones = [];

        if($user->co_de == "S" ){
            $demarcacion = Demarcaciones::find($user->demarcacion);
            //$demarcacion = true;
            //$demarcaciones = DB::table("demarcaciones")->where("municipio_id",$municipioId)->paginate(10);
            
                        
                array_push($nombres_demarcaciones,'Demarcacion '.$demarcacion->demarcacion);
                array_push($total_demarcaciones,$this->consultaSimpatizantesPorDemarcacion($entidadId, $municipioId,$demarcacion->id, $candidatoId, $goal_type));
            
             return ["demarcaciones"=>$nombres_demarcaciones, "conteo_demarcacion"=>$total_demarcaciones, "pages"=>1,"coordinador"=>true];
        }else {
            
            $demarcaciones = DB::table("demarcaciones")->where("municipio_id",$municipioId)->paginate(10);
            $pages = round($demarcaciones->count()/10);
            foreach($demarcaciones as $demarcacion){
                
                array_push($nombres_demarcaciones,'Demarcacion '.$demarcacion->demarcacion);
                array_push($total_demarcaciones,$this->consultaSimpatizantesPorDemarcacion($entidadId, $municipioId,$demarcacion->id, $candidatoId, $goal_type));
            }
             return ["demarcaciones"=>$nombres_demarcaciones, "conteo_demarcacion"=>$total_demarcaciones, "pages"=>$pages,"coordinador"=>true];
        }
    }

    public function consultaSimpatizantesPorDemarcacion($entidad, $clave_municipio,$demarcacion, $user, $simpatiza)
    {

        $count = PadronElectoral::join("simpatizantes_candidatos as sc", function ($join) use ($user) {
            $join->on("sc.padronelectoral_id", "padronelectoral.id")
                ->where("sc.candidato_id", $user);
        })
            ->where("entidad", $entidad)
            ->where("municipio", $clave_municipio)
            ->where("sc.data",'like','%"demarcacion_id":'.$demarcacion.'%')
            ->where("sc.data",'like' ,"%".$simpatiza."%")
            ->count();
        return $count;
    } 


        #obtienes el conteo por seccion
    public function getSimpatizantesMetas($candidato,$entidad,$claveMunicipio,Request $request){
        //TODO: coordinador grafica de simpatizantes
        $user = User::find($request->id);
        $goal_type = $request->goal_type;
        
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
            $secciones = [];
            $nd = [];
            $nnc = [];
            $ns = [];
            $s = [];
            if($demarcacion){
                foreach ($seccs as $sec){
                    array_push($secciones,"Seccion $sec");
                    array_push($nd,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, $goal_type));
                   /* array_push($nnc,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "NO LO CONOZCO"));
                    array_push($ns,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "NO"));
                    array_push($s,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "SI"));*/
                }
                return ["secciones"=>$secciones, "nd"=>$nd,"pages"=>0,"coordinador"=>false];
            }else{
                $sec = json_decode($c->configuracion, true)['registros'];
                $arr = explode("-",$sec);
                if(count($arr) == 3){
                    $sec = $arr[2];
                    array_push($secciones,"Seccion $sec");
                    array_push($nd,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, $goal_type));
                   /* array_push($nnc,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "NO LO CONOZCO"));
                    array_push($ns,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "NO"));
                    array_push($s,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "SI"));*/
                    return ["secciones"=>$secciones, "nd"=>$nd, "pages"=>0,"coordinador"=>true];
                }elseif (count($arr) == 2) {
                    $muni = $arr[1];
                    $sec = DB::table("secciones")->where("clave_municipio",$muni)->paginate(100);
                    $seccions = DB::table("secciones")->where("clave_municipio",$muni)->count();
                    $pages = round($seccions/10);
                    foreach ($sec as $seccion){
                        array_push($secciones,"Seccion $seccion->seccion");
                        array_push($nd,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato,$goal_type));
                        /*array_push($nnc,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "NO LO CONOZCO"));
                        array_push($ns,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "NO"));
                        array_push($s,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "SI"));*/
                    }
                    return ["secciones"=>$secciones, "nd"=>$nd, "pages"=>$pages,"coordinador"=>false];
                }

            }
        }else{
            $sec = DB::table("secciones")->where("clave_municipio",$claveMunicipio)->paginate(100);
            $seccions = DB::table("secciones")->where("clave_municipio",$claveMunicipio)->count();
            $pages = round($seccions/10);
            $secciones = [];
            $nd = [];
            $nnc = [];
            $ns = [];
            $s = [];
            foreach ($sec as $seccion){
                array_push($secciones,"Seccion $seccion->seccion");
                array_push($nd,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, $goal_type));
                /*array_push($nnc,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "NO LO CONOZCO"));
                array_push($ns,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "NO"));
                array_push($s,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "SI"));*/
            }
            return ["secciones"=>$secciones, "nd"=>$nd, "pages"=>$pages,"coordinador"=>false];

        }
    }
    public function consultaSimpatizantes($entidad, $clave_municipio,$seccion, $user, $simpatiza)
    {


        $count = PadronElectoral::join("simpatizantes_candidatos as sc", function ($join) use ($user) {
            $join->on("sc.padronelectoral_id", "padronelectoral.id")
                ->where("sc.candidato_id", $user);
        })
            ->where("entidad", $entidad)
            ->where("municipio", $clave_municipio)
            ->where("seccion", $seccion)
            ->where("sc.data",'like' ,"%".$simpatiza."%")
            ->count();
        return $count;
    }    
}