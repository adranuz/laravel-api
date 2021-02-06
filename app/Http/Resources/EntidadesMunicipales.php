<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class EntidadesMunicipales extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'children' => DB::table('secciones')->where('clave_municipio', $this->idmun)->get([DB::raw('CONCAT (clave_entidad_federal,"-",clave_municipio,"-",seccion) as id'), 'seccion as number','seccion as label'])
        ];
    }
}