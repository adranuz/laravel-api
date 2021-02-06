<?php

namespace App\Http\Controllers;

use App\Coordinador;
use App\Http\Resources\EntidadesFederales;
use App\Http\Resources\EntidadesMunicipales;
use App\Models\Candidato;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Registro extends Controller
{
    public function treeEntidades()
    {
        $entidades = DB::table('entidades_federales')->select('id', 'nombre as text', DB::raw('(select "#") as parent'))->get()->toArray();
        $municipios = DB::table('municipios')->select(DB::raw('CONCAT (clave_entidad_federal,"-",clave_municipio) as id'), 'nombre as text', 'clave_entidad_federal as parent')->get()->toArray();
        $secciones=DB::table('secciones')->select(DB::raw('CONCAT (clave_entidad_federal,"-",clave_municipio) as id'),'seccion as number', 'tipo as text', 'clave_municipio as parent')->get()->toArray();
        $data = array_merge($entidades,$municipios,$secciones);
        return response()->json($data);
    }

    public function registro(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'string|email',
            'nombre' => 'required|string',
            'partido' => 'required|string',
            'ce' => 'string',
            'password' => 'required|string',
            "coordinador" => "string",
            "candidato" => "int",
            #"co_de" => "string",
            #"demarcacion"=> "int"
        ])->validate();

        if($request->coordinador == "true"){

            $jsonData = [
                "partido" => $request->partido,
                "ce" => $request->ce,
                "registros" => ($request->co_de == "true") ? "demarcacion:$request->demarcacion" : $request->values
            ];
            $candidato = Coordinador::create(['nombre' => $request->nombre, 'configuracion' => json_encode($jsonData),"candidato_id"=>$request->candidato]);
            if($request->co_de == "true"){
                User::create(['name' => $request->nombre, 'email' => $request->email, 'username' => null, 'password' => bcrypt($request->password),
                    'candidato_id' => $candidato->id, "role_id" => 1, "coordinador"=>"S", "demarcacion"=> $request->demarcacion, "co_de" => "S"]);
            }else{
                User::create(['name' => $request->nombre, 'email' => $request->email, 'username' => null, 'password' => bcrypt($request->password),
                    'candidato_id' => $candidato->id, "role_id" => 1, "coordinador"=>"S", "demarcacion"=> null, "co_de"=> "N"]);
            }

        }else{
            $jsonData = [
                "partido" => $request->partido,
                "ce" => $request->ce,
                "registros" => $request->values
            ];
            $candidato = Candidato::create(['nombre' => $request->nombre, 'configuacion' => json_encode($jsonData)]);
            User::create(['name' => $request->nombre, 'email' => $request->email, 'username' => null, 'password' => bcrypt($request->password), 'candidato_id' => $candidato->id, "role_id" => 1, "coordinador"=>"N"]);
        }
        return response()->json("Ok", 200);
    }

    public function entidadesMunicipios(Request $request)
    {
        if($request->coordinador == "true"){
            $candidato = Candidato::find($request->id);
            $registro = json_decode($candidato->configuacion, true)['registros'];
            $arr = explode("-",$registro);
            $entidades = DB::table('entidades_federales')->where("id",$arr[0])->get();
        }else{
            $entidades = DB::table('entidades_federales')->get();
        }

        return EntidadesFederales::collection($entidades);
    }


    public function entidadesSecciones()
    {
        $municipios = DB::table('municipios')->get();
        return EntidadesMunicipales::collection($municipios);
    }
  
  

    public function generaArrayRegistros($values)
    {
        $valuesReturn = [];
        //$datas = explode(",", $values);
        for ($i = 0; $i < count($values); $i++) {
            if (strpos($values[$i], "-")) {
                $key = explode("-", $values[$i]);
                $valuesReturn[$key[0]][] = $key[1];
            } else {
                $valuesReturn[$values[$i]] = [];
            }
        }
        return $valuesReturn;
    }
}
