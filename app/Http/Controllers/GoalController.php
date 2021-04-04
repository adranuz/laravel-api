<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goal;
use App\Models\User;
use App\Coordinador;
use App\Demarcaciones;
use App\Models\PadronElectoral;
use App\TypeSympathizer;
use Illuminate\Support\Facades\DB;
use App\SimpatizanteCandidato;
class GoalController extends Controller
{

    private $recordPerPage;

    function  __construct(){
        $this->recordPerPage = 10;
    }
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
        $id = $request->id;
        $user = User::find($id);
        $counter = $request->counter;
        $fields = ['goals.id','secciones.seccion','goals.desired_quantity','type_sympathizer.name', "demarcaciones.demarcacion"];
        if($user->coordinador == "S" && $user->co_de == "N"){
            
            $coordinador = Coordinador::find($user->candidato_id);
            
            $sec = json_decode($coordinador->configuracion, true)['registros'];
            $arr = explode("-",$sec);
            
            if(count($arr) == 3){
                $seccion = DB::table('secciones')->where('seccion',$arr[2])->get();
                $sec = $arr[2];
                $metas = DB::table("secciones")
                ->join('goals','secciones.id',"=",'goals.seccion_id')
                ->join("type_sympathizer","type_sympathizer.id","=",'goals.type_sympathizer_id')
                ->join("demarcaciones","goals.demarcaciones_id", "=", "demarcaciones.id")
                ->where("goals.candidato_id", $candidatoId)
                ->where("type_sympathizer.name", $param)
                ->where("goals.seccion_id",$seccion[0]->id)                
                ->select($fields)
                ->paginate($this->recordPerPage);
                $metas->appends(request()->query())->links();


                return $counter == "true" ? ["type" => "counter","totalGoal" => count($metas)] : ["data" => $metas, "total" => count($metas)];
            }

            else            
            {
                $metas = DB::table("secciones")
                ->join('goals','secciones.id',"=",'goals.seccion_id')
                ->join("type_sympathizer","type_sympathizer.id","=",'goals.type_sympathizer_id')
                ->join("demarcaciones","goals.demarcaciones_id", "=", "demarcaciones.id")
                ->where("goals.candidato_id", $candidatoId)
                ->where("type_sympathizer.name", $param)
                ->select($fields)
                ->paginate($this->recordPerPage);
                $metas->appends(request()->query())->links();
                
                return $counter == "true" ? ["type" => "counter","totalGoal" => count($metas)] : ["data" => $metas, "total" => count($metas)];
                //return $metas;
            }
        }else if($user->co_de == "S"){
            $demarcacion = Demarcaciones::find($user->demarcacion);
            
            $metas = DB::table("secciones")
            ->join('goals','secciones.id',"=",'goals.seccion_id')
            ->join("type_sympathizer","type_sympathizer.id","=",'goals.type_sympathizer_id')
            ->join("demarcaciones","goals.demarcaciones_id", "=", "demarcaciones.id")
            ->where("goals.candidato_id", $candidatoId)
            ->where("goals.demarcaciones_id",$demarcacion->id)
            ->where("type_sympathizer.name", $param)                
            ->select($fields)
            ->paginate($this->recordPerPage);
            $metas->appends(request()->query())->links();
            
            return $counter == "true" ? ["type" => "counter","totalGoal" => count($metas)] : ["data" => $metas, "total" => count($metas)];
           // return $metas;
        }else{
                        // return $param;
            $metas = DB::table("secciones")
            ->join('goals','secciones.id',"=",'goals.seccion_id')
            ->join("type_sympathizer","type_sympathizer.id","=",'goals.type_sympathizer_id')
            ->join("demarcaciones","goals.demarcaciones_id", "=", "demarcaciones.id")
            ->where("goals.candidato_id", $candidatoId)
            ->where("type_sympathizer.name", $param)
            ->orderBy('secciones.seccion','asc')
            ->select($fields)         
            ->paginate($this->recordPerPage);
            $metas->appends(request()->query())->links();
            
            return $counter == "true" ? ["type" => "counter","totalGoal" => count($metas)] : ["data" => $metas, "total" => count($metas)];
            //return $metas;

        }       
    }
    
    public function getMetasPorDemarcacion(Request $request,int $candidatoId){
        //$metas = Goal::whereCandidatoId($candidatoId)->get();
        $user = User::find($request->id);
        $param = $request->goal_type;
        $counter = $request->counter;
        $fields = ['goals.id','demarcaciones.demarcacion','goals.desired_quantity','type_sympathizer.name'];
        if($user->co_de == "S" ){

            $demarcacion = Demarcaciones::find($user->demarcacion);
            
            $metas = DB::table("demarcaciones")
            ->join('goals','demarcaciones.id',"=",'goals.demarcaciones_id')
            ->join("type_sympathizer","type_sympathizer.id","=",'goals.type_sympathizer_id')
            ->where("goals.demarcaciones_id", $demarcacion->id)
            ->where("goals.candidato_id", $candidatoId)
            ->where("type_sympathizer.name", $param)
            ->orderBy('goals.demarcaciones_id','asc')
            ->get($fields);
            //return $metas;
            return $counter == "true" ? ["type" => "counter","totalGoal" => count($metas)] : ["data" => $metas, "total" => count($metas)];
        }else if($user->coordinador == "S" && $user->co_De == "N"){
            /*se debe de cambiar esto*/
            $metas = DB::table("demarcaciones")
            ->join('goals','demarcaciones.id',"=",'goals.demarcaciones_id')
            ->join("type_sympathizer","type_sympathizer.id","=",'goals.type_sympathizer_id')
            ->where("goals.candidato_id", $candidatoId)
            ->where("type_sympathizer.name", $param)
            ->orderBy('goals.demarcaciones_id','asc')
            ->get($fields);
            return $counter == "true" ? ["type" => "counter","totalGoal" => count($metas)] : ["data" => $metas, "total" => count($metas)];
        }        
        else{

        $metas = DB::table("demarcaciones")
        ->join('goals','demarcaciones.id',"=",'goals.demarcaciones_id')
        ->join("type_sympathizer","type_sympathizer.id","=",'goals.type_sympathizer_id')
        ->where("goals.candidato_id", $candidatoId)
        ->where("type_sympathizer.name", $param)
        ->orderBy('goals.demarcaciones_id','asc')
        ->select($fields)         
        ->paginate($this->recordPerPage);
        $metas->appends(request()->query())->links();

        //return $metas;
        return $counter == "true" ? ["type" => "counter","totalGoal" => count($metas)] : ["data" => $metas, "total" => count($metas)];
        }

    }
    
    
    public function getSimpatizantesMetasDemarcacion($candidatoId,$entidadId,$municipioId, Request $request){
        $user = User::find($request->id);
        $goal_type = $request->goal_type;
        $total_demarcaciones = [];
        $nombres_demarcaciones = [];

        if($user->co_de == "S" ){
            $demarcacion = Demarcaciones::find($user->demarcacion);
                 
                array_push($nombres_demarcaciones,'Demarcacion '.$demarcacion->demarcacion);
                array_push($total_demarcaciones,$this->consultaSimpatizantesPorDemarcacion($entidadId, $municipioId,$demarcacion->id, $candidatoId, $goal_type));
            
             return ["demarcaciones"=>$nombres_demarcaciones, "conteo_demarcacion"=>$total_demarcaciones, "pages"=>1,"coordinador"=>true];
        }else {
            
            $demarcaciones = DB::table("demarcaciones")->where("municipio_id",$municipioId)->pluck('id');
            return $this->newFunctionDem($entidadId, $municipioId,$demarcaciones, $candidatoId, $goal_type);
        }
    }

    public function newFunctionDem($entidad, $clave_municipio,$demarcaciones, $user, $simpatiza){

        $result = DB::table('padronelectoral')
                        ->join('simpatizantes_candidatos','simpatizantes_candidatos.padronelectoral_id','=','padronelectoral.id')
                        ->join('demarcaciones','simpatizantes_candidatos.demarcacion_id','=','demarcaciones.id')
                        ->join('goals','goals.demarcaciones_id','=','demarcaciones.id')
                        ->join('type_sympathizer','type_sympathizer.id','=','goals.type_sympathizer_id')
                        ->where("entidad", $entidad)
                        ->where("municipio", $clave_municipio)
                        ->whereIn("demarcaciones.id",$demarcaciones)
                        ->where("simpatizantes_candidatos.candidato_id", $user)                        
                        ->where("simpatizantes_candidatos.data",'like' ,"%".$simpatiza."%")
                        ->where("type_sympathizer.name",$simpatiza)
                        ->select(DB::raw('concat("Demarcacion ",sop_demarcaciones.demarcacion) as name'), DB::raw('count(sop_demarcaciones.demarcacion) as y'))
                        ->groupBy('demarcaciones.demarcacion')
                        ->paginate(1000);

        $result->appends(request()->query())->links();
                        //->get(['simpatizantes_candidatos.seccion_id']);
        return $result;

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
            $seccs = array_map('trim',explode(",",$demarcaciones->secciones));
            $seccs = array_map('intval', $seccs);
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
            //verifica si es coordinador de demarcacion
            if($demarcacion){                
                return $this->newFunction($entidad, $claveMunicipio,$seccs, $candidato, $goal_type);
            }else{
                //obtiene los registros de la configuracion y los guarda en un array
                $sec = json_decode($c->configuracion, true)['registros'];
                $arr = explode("-",$sec);
                //verifica si es un coordinador de tipo seccional o municipal
                if(count($arr) == 3){
                    # coord seccional
                    $sec = $arr[2];
                    $seccion = DB::table("secciones")->where("seccion",$sec)->pluck('seccion');
                    return $this->newFunction($entidad, $claveMunicipio,$seccion, $candidato, $goal_type);

                }elseif (count($arr) == 2) {
                    # coord municipal
                    $muni = $arr[1];
                    $sec = DB::table("secciones")->where("clave_municipio",$muni)->pluck('seccion');
                    return $this->newFunction($entidad, $claveMunicipio,$sec, $candidato, $goal_type);
                }

            }
        }else{
            $secciones = DB::table("secciones")->where("clave_municipio",$claveMunicipio)->pluck('seccion');

            return $this->newFunction($entidad, $claveMunicipio,$secciones, $candidato, $goal_type);

        }
    }
    public function consultaSimpatizantes($entidad, $clave_municipio,$seccion, $user, $simpatiza)
    {
        $count = PadronElectoral::join("simpatizantes_candidatos as sc", function ($join) use ($user,$seccion) {
            $join->on("sc.padronelectoral_id", "padronelectoral.id")
                ->where("sc.candidato_id", $user)
                ->where("sc.seccion_id",$seccion);
        })
            ->where("entidad", $entidad)
            ->where("municipio", $clave_municipio)
            //->where("seccion", $seccion)
            ->where("sc.data",'like' ,"%".$simpatiza."%")
            ->count();
        return $count;
    }
    
    public function newFunction($entidad, $clave_municipio,$secciones, $user, $simpatiza){

        $result = DB::table('padronelectoral')
                        ->join('simpatizantes_candidatos','simpatizantes_candidatos.padronelectoral_id','=','padronelectoral.id')
                        ->join('secciones','simpatizantes_candidatos.seccion_id','=','secciones.id')
                        ->join('goals','goals.seccion_id','=','secciones.id')
                        ->join('type_sympathizer','type_sympathizer.id','=','goals.type_sympathizer_id')
                        ->where("entidad", $entidad)
                        ->where("municipio", $clave_municipio)
                        ->whereIn("secciones.seccion",$secciones)
                        ->where("simpatizantes_candidatos.candidato_id", $user)                        
                        ->where("simpatizantes_candidatos.data",'like' ,"%".$simpatiza."%")
                        ->where("type_sympathizer.name",$simpatiza)                      
                        ->select(DB::raw('concat("Seccion ",sop_secciones.seccion) as name'),/*'secciones.seccion as name',*/ DB::raw('count(sop_secciones.seccion) as y'))
                        ->orderBy('secciones.seccion','asc')
                        ->groupBy('secciones.seccion')
                        ->paginate(500);

        $result->appends(request()->query())->links();
                        //->get(['simpatizantes_candidatos.seccion_id']);
        return $result;

    }
    public function goalCounter($candidato_id, Request $request){
        
        $param['municipio_id'] = $request->municipio_id;       
        $param['usuario_id'] = $request->usuario_id;
        $user = User::find($param['usuario_id']);
        
        if($user->co_de == "S"){
            $demarcaciones = Demarcaciones::find($user->demarcacion);
            $seccs = explode(",",$demarcaciones->secciones);
            $demarcacion = true;

            $goals = DB::table('goals')
            ->join('type_sympathizer','goals.type_sympathizer_id','=','type_sympathizer.id')
            ->select([DB::raw('count(sop_goals.type_sympathizer_id) as total'),'type_sympathizer.name'])
            ->where('municipios_id',$param['municipio_id'])
            ->where('candidato_id',$candidato_id)
            ->where('demarcaciones_id',$demarcaciones->id)                        
            ->groupBy('goals.type_sympathizer_id')
            ->get();

            return ['data'=> $goals];

        }else if($user->co_de == "N" && $user->coordinador == "S"){

            $c = Coordinador::find($user->candidato_id);
            $sec = json_decode($c->configuracion, true)['registros'];
            $arr = explode("-",$sec);

            

            if(count($arr) == 3){

                $seccion= DB::table('secciones')->where('seccion',$arr[2])->first();

                
                $goals = DB::table('goals')
                ->join('type_sympathizer','goals.type_sympathizer_id','=','type_sympathizer.id')
                ->select([DB::raw('count(sop_goals.type_sympathizer_id) as total'),'type_sympathizer.name'])
                ->where('municipios_id',$param['municipio_id'])
                ->where('candidato_id',$candidato_id)
                ->where('seccion_id',$seccion->id)                        
                ->groupBy('goals.type_sympathizer_id')
                ->get();
                
                return ['data'=> $goals];
            }
        }

        $goals = DB::table('goals')
                ->join('type_sympathizer','goals.type_sympathizer_id','=','type_sympathizer.id')
                ->select([DB::raw('count(sop_goals.type_sympathizer_id) as total'),'type_sympathizer.name'])
                ->where('municipios_id',$param['municipio_id'])
                ->where('candidato_id',$candidato_id)                        
                ->groupBy('goals.type_sympathizer_id')
                ->get();


        return ['data'=> $goals];

    }

    public function getSimpatizantesByType(Request $request, int $candidato_id){


        $simpatizantes = DB::table('simpatizantes_candidatos')
                            ->join('padronelectoral','simpatizantes_candidatos.padronelectoral_id','=','padronelectoral.id')
                            ->leftjoin('demarcaciones','simpatizantes_candidatos.demarcacion_id', '=', 'demarcaciones.id')
                            ->where('simpatizantes_candidatos.candidato_id',$candidato_id)
                            ->where('simpatizantes_candidatos.data','like','%"participacion":"'.$request->type.'"%')
                            ->orderBy('demarcaciones.demarcacion','asc')
                            ->orderBy('padronelectoral.seccion','asc')
                            ->paginate(100);
        $simpatizantes->appends(request()->query())->links();

     return $simpatizantes;
    }

    public function countSimpatizantes($candidato_id){
        $typeSympathizers = TypeSympathizer::all();
        $counter = [];

        foreach($typeSympathizers as $type){
            
            $counter[$type->name] = SimpatizanteCandidato::with('people')
                               ->where('candidato_id', $candidato_id)
                               ->where('simpatiza','SI')
                               ->where('data','like','%"participacion":"'.$type->name.'"%')
                               ->count();
        }

        return ["data" =>$counter];
    }

    public function destroy(int $id){
        $goal = Goal::findOrFail($id);
        $goal->delete();

        return ["data" => 'Meta eliminada correctamente'];

    }

    public function update(Request $request, int $id){
        $input = $request->all();
        $goal = Goal::findOrFail($id);
        $goal->fill($input);
        $goal->save();

        return ["data" => 'Meta actualizada correctamente'];

    }
}