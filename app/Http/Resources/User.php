<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class User extends JsonResource
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
            'nombre' => $this->name,
            "coordinador" => $this->coordinador,
            'rol' => DB::table('roles')->where('id', $this->role_id)->first()->nombre,
            'idcandidato' => ($this->coordinador == "S") ?  DB::table('coordinador')->where('id', $this->candidato_id)->first()->candidato_id
                : $this->candidato_id,
            'candidato' => ($this->coordinador == "S") ?
                DB::table('coordinador')->where('id', $this->candidato_id)->first()->nombre :
                DB::table('candidato')->where('id', $this->candidato_id)->first()->nombre,
        ];
    }
}