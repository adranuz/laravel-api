<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\SimpatizanteCandidato;
use App\Coordinador;
use App\PadronElectoral;
class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        return response()->json(["data"=>$teams]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $team = Team::create($input);
        
        return response()->json(["data"=>$team]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);
        return response()->json(["data"=>$team]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $team = Team::findOrFail($id);
        $team->fill($input);

        return response()->json(["data"=>$team]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->destroy();
        return response()->json(["data"=>$team]);
    }

    public function showTeamsByCandidato(int $candidato_id){
        
        $teams = Team::where('candidato_id', $candidato_id)->get();
        return response()->json(["data"=>$teams]);
    }

    public function showTeamMembers(int $candidato_id, int $team_id){
                
        $team = Team::where('id',$team_id)
                    ->where('candidato_id',$candidato_id)
                    ->first();

        return response()->json(["data"=>["simpatizantes" => $team->simpatizantes,
                                          "coordinadores" => $team->coordinadores]]);
    }

    public function addToTeam(Request $request, int $candidato_id, int $team_id){
        
        $input = $request->all();
        $team = Team::where('id',$team_id)
        ->where('candidato_id',$candidato_id)
        ->first();

        if($input['memberType'] === 'coordinador'){
            $coordinador = Coordinador::findOrFail($input['memberId']);
            $coordinador->team_id = $team->id;
            $coordinador->save();
        }else{
            $padron = PadronElectoral::findOrFail($input['memberId']);
            $padron->team_id = $team->id;
            $padron->save();
        }

        return response()->json(["data" => 'Integrante agregado']);
    }

    public function dettachToTeam(Request $request, int $candidato_id, int $team_id){
        
        $input = $request->all();
        $team = Team::where('id',$team_id)
        ->where('candidato_id',$candidato_id)
        ->first();

        if($input['memberType'] === 'coordinador'){
            $coordinador = Coordinador::findOrFail($input['memberId']);
            $coordinador->team_id = null;
            $coordinador->save();
        }else{
            $padron = PadronElectoral::findOrFail($input['memberId']);
            $padron->team_id = null;
            $padron->save();
        }

        return response()->json(["data" => 'Integrante agregado']);
    }
}
