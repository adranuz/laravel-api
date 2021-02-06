<?php

namespace App\Http\Resources;

use App\Models\Candidato;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\EntidadesMunicipales;
class EntidadesFederales extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($request->coordinador == "true"){
            $candidato = Candidato::find($request->id);
            $registro = json_decode($candidato->configuacion, true)['registros'];
            $arr = explode("-",$registro);
            if(count($arr) == 1){
                $temp=DB::table('municipios')->where('clave_entidad_federal', $arr[0])->get([DB::raw('CONCAT (clave_entidad_federal,"-",clave_municipio) as id'), 'nombre as label',"id as idmun"]);
            }else{
                $temp=DB::table('municipios')->where('clave_entidad_federal', $this->id)->where("id",$arr[1])->get([DB::raw('CONCAT (clave_entidad_federal,"-",clave_municipio) as id'), 'nombre as label',"id as idmun"]);
            }
        }else{
            $temp=DB::table('municipios')->where('clave_entidad_federal', $this->id)->get([DB::raw('CONCAT (clave_entidad_federal,"-",clave_municipio) as id'), 'nombre as label',"id as idmun"]);
        }
        return [
            'id' => $this->id,
            'label' => $this->nombre,
            'children' => EntidadesMunicipales::collection($temp)
        ];
    }
}
