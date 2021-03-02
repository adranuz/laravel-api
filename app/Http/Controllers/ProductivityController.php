<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SimpatizanteCandidato;
use App\Team;
use App\PadronElectoral;
use App\Coordinador;
class ProductivityController extends Controller
{

    //obtienes el conteo por persona
    public function getEncuestadores(/*$entidad,$claveMunicipio,*/$candidato,Request $request){

        $simpatizantes = SimpatizanteCandidato::with('assign')
                                                ->where('assign_type','<>',null)
                                                ->where('assign_id','<>',null)                                                
                                                ->get();                                                                                            
        $nombres = [];
        $nd = [];
        $nnc = [];
        $ns = [];
        $s = [];
        //return $simpatizantes;
        foreach ($simpatizantes as $simpatizante){
            if(!in_array("nombre ".$simpatizante->assign->nombre,$nombres)){
                array_push($nombres,"nombre ".$simpatizante->assign->nombre);
                array_push($nd,$this->consultaEncuestadores($candidato, $simpatizante->assign->id, $simpatizante->assign_type,"NO DECIDE"));
                array_push($nnc,$this->consultaEncuestadores($candidato, $simpatizante->assign->id,  $simpatizante->assign_type, "NO LO CONOZCO"));
                array_push($ns,$this->consultaEncuestadores($candidato, $simpatizante->assign->id, $simpatizante->assign_type, "NO"));
                array_push($s,$this->consultaEncuestadores($candidato, $simpatizante->assign->id, $simpatizante->assign_type, "SI"));
            }
        }
        return ["nombres"=>$nombres, "nd"=>$nd, "nnc"=>$nnc, "ns"=>$ns, "s"=>$s,"pages"=>0,"coordinador"=>false];                                                
    }

    public function consultaEncuestadores($candidato_id, $id, $type,$simpatiza)
    {
       $count = SimpatizanteCandidato::where('candidato_id',$candidato_id)
                                            ->where('assign_type',$type)
                                            ->where('assign_id',$id)
                                            ->where('simpatiza',$simpatiza)
                                            ->count();
        return $count;
    }
}
