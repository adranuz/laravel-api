<?php

namespace App\Http\Controllers;

use App\Coordinador;
use App\Demarcaciones;
use App\Mail\PasswordRecovery;
use App\Models\Candidato;
use App\Models\PadronElectoral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getPoblacion($idCandidato){
        $candidato =  DB::table('candidato')->find($idCandidato);
        $municipios = json_decode($candidato->configuacion, true)['registros'];
        $data = DB::table('municipios')
            ->whereIn('clave_municipio', $municipios)
            ->get(['id', 'clave_municipio', 'nombre'])
            ->toArray();
        $p = 0;
        foreach ($data as $item){
            $municipio = $item->clave_municipio;
            $poblacion = PadronElectoral::where("municipio",$municipio)->count();
            $p = $p+$poblacion;
        }
        return $p;
    }
    public function getSimpatizantes($idCandidato){
        $candidato =  DB::table('simpatizantes_candidatos')
            ->where("candidato_id",$idCandidato)
            ->where("simpatiza","SI")
            ->count();
        return $candidato;
    }

    public function getCandidatos(){
        $candidatos =  DB::table('candidato')->get();
        return  ["candidatos"=>$candidatos];
    }

    //obtienes lista de municipios
    public function getMunicipios(Request $request,$idEntidad,$idCandidato){
        $user = User::find($request->id);

        if($user->coordinador == "S"){
            $candidato =  Coordinador::find($user->candidato_id);
            $municipios = json_decode($candidato->configuracion, true)['registros'];
            $arr = explode("-",$municipios);
            if(count($arr) == 2 || count($arr) == 3){
                $muni = $arr[1];
                $data = DB::table('municipios')
                    ->where('clave_municipio', $muni)
                    ->get(['id', 'clave_municipio', 'nombre'])
                    ->toArray();
                $municipios = DB::table("municipios")->where("clave_entidad_federal",$idEntidad)->get();
            }elseif (count($arr) == 1){
                $entidad = $arr[0];
                $data = DB::table('municipios')
                    ->where('clave_entidad_federal', $entidad)
                    ->get(['id', 'clave_municipio', 'nombre'])
                    ->toArray();
                $municipios = DB::table("municipios")->where("clave_entidad_federal",$idEntidad)->get();
            }

            if($user->co_de == "S"){
                $demarcacion_id = $user->demarcacion;
                $demarcacion = Demarcaciones::find($demarcacion_id);
                $data = DB::table('municipios')
                    ->where('clave_municipio', $demarcacion->municipio_id)
                    ->get(['id', 'clave_municipio', 'nombre'])
                    ->toArray();
                $municipios = DB::table("municipios")->where("clave_entidad_federal",$idEntidad)->get();

            }
            return ["municipios"=>$municipios,"municipio"=>$data];
        }else{
            $candidato = DB::table("candidato")->find($idCandidato);
            $muns = json_decode($candidato->configuacion, true)['registros'];
            $arr = explode("-",$muns);
            if(count($arr) == 2 || count($arr) == 3){
                $muni = $arr[1];
                $data = DB::table('municipios')
                    ->where('clave_municipio', $muni)
                    ->get(['id', 'clave_municipio', 'nombre'])
                    ->toArray();
                $municipios = DB::table("municipios")->where("clave_entidad_federal",$idEntidad)->get();
            }elseif (count($arr) == 1){
                $entidad = $arr[0];
                $data = DB::table('municipios')
                    ->where('clave_entidad_federal', $entidad)
                    ->get(['id', 'clave_municipio', 'nombre'])
                    ->toArray();
                $municipios = DB::table("municipios")->where("clave_entidad_federal",$idEntidad)->get();
            }
            $municipios = DB::table("municipios")->where("clave_entidad_federal",$idEntidad)->get();
            return ["municipios"=>$municipios,"municipio"=>$data];
        }

    }
    //obtienes lista de secciones por municipio
    public function getSecciones($entidad,$claveMunicipio,$candidato,Request $request){
        //TODO: coordinador grafica de simpatizantes
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
            $secciones = [];
            $nd = [];
            $nnc = [];
            $ns = [];
            $s = [];
            if($demarcacion){
                foreach ($seccs as $sec){
                    array_push($secciones,"Seccion $sec");
                    array_push($nd,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "NO DECIDE"));
                    array_push($nnc,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "NO LO CONOZCO"));
                    array_push($ns,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "NO"));
                    array_push($s,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "SI"));
                }
                return ["secciones"=>$secciones, "nd"=>$nd, "nnc"=>$nnc, "ns"=>$ns, "s"=>$s,"pages"=>0,"coordinador"=>false];
            }else{
                $sec = json_decode($c->configuracion, true)['registros'];
                $arr = explode("-",$sec);
                if(count($arr) == 3){
                    $sec = $arr[2];
                    array_push($secciones,"Seccion $sec");
                    array_push($nd,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "NO DECIDE"));
                    array_push($nnc,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "NO LO CONOZCO"));
                    array_push($ns,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "NO"));
                    array_push($s,$this->consultaSimpatizantes($entidad, $claveMunicipio,$sec, $candidato, "SI"));
                    return ["secciones"=>$secciones, "nd"=>$nd, "nnc"=>$nnc, "ns"=>$ns, "s"=>$s,"pages"=>0,"coordinador"=>true];
                }elseif (count($arr) == 2) {
                    $muni = $arr[1];
                    $sec = DB::table("secciones")->where("clave_municipio",$muni)->paginate(10);
                    $seccions = DB::table("secciones")->where("clave_municipio",$muni)->count();
                    $pages = round($seccions/10);
                    foreach ($sec as $seccion){
                        array_push($secciones,"Seccion $seccion->seccion");
                        array_push($nd,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "NO DECIDE"));
                        array_push($nnc,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "NO LO CONOZCO"));
                        array_push($ns,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "NO"));
                        array_push($s,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "SI"));
                    }
                    return ["secciones"=>$secciones, "nd"=>$nd, "nnc"=>$nnc, "ns"=>$ns, "s"=>$s,"pages"=>$pages,"coordinador"=>false];
                }

            }
        }else{
            $sec = DB::table("secciones")->where("clave_municipio",$claveMunicipio)->paginate(10);
            $seccions = DB::table("secciones")->where("clave_municipio",$claveMunicipio)->count();
            $pages = round($seccions/10);
            $secciones = [];
            $nd = [];
            $nnc = [];
            $ns = [];
            $s = [];
            foreach ($sec as $seccion){
                array_push($secciones,"Seccion $seccion->seccion");
                array_push($nd,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "NO DECIDE"));
                array_push($nnc,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "NO LO CONOZCO"));
                array_push($ns,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "NO"));
                array_push($s,$this->consultaSimpatizantes($entidad, $claveMunicipio,$seccion->seccion, $candidato, "SI"));
            }
            return ["secciones"=>$secciones, "nd"=>$nd, "nnc"=>$nnc, "ns"=>$ns, "s"=>$s,"pages"=>$pages,"coordinador"=>false];

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
            ->where("sc.simpatiza", $simpatiza)
            ->count();
        return $count;
    }

    public function getMunicipiosCandidato($id){

        $candidato = DB::table("candidato")->find($id);
        $registro = json_decode($candidato->configuacion, true)['registros'];
        $arr = explode("-",$registro);
        $municipios = DB::table("municipios")->where("clave_entidad_federal",$arr[0])->get();
        return $municipios;
    }

    public function consultaDemarcacionesCandidato($municipio_id){
        $demarcaciones = Demarcaciones::where("municipio_id",$municipio_id)->get();
        return $demarcaciones;
    }

    public function solicitaCambioPass(Request $request){
        try {
            $user = User::where("email",'like',$request->email)->first();

            if($user != null){
                $token = $this->generaToken(50);
                $user->pass_token = $token;
                $user->save();
                Mail::to($user->email)->send(new PasswordRecovery($user));
                $respuesta = ["code"=>200];
            }else{
                $respuesta = ["code"=>202];
            }
        }catch (Exception $e){
            $respuesta = ["code"=>500, "error"=>$e];
        }
        return $respuesta;
    }

    public function cambiarContrasena(Request $request){
        try {

            if($request->token == null){
                return ["code"=>202];
            }
            $user = User::where("pass_token", "like",$request->token)->first();
            if($user != null){
                $user->password = bcrypt($request->password);
                $user->pass_token = null;
                $user->save();

                return ["code"=>200];
            }else{
                return ["code"=>202];
            }


        }catch (Exception $e){
            return ["code"=>500, "error"=>$e->getMessage()];

        }
    }

    public function generaToken($tamano){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz---------'.
        '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz----------'.
        '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz----------'.
        '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz----------';
        return substr(str_shuffle($characters),0, $tamano);
    }
}
