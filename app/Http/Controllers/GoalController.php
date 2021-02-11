<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goal;
class GoalController extends Controller
{
    public function store(Request $request, int $id){
        $input = $request->all();
        $input['created_by'] = $id;
        $data = Goal::create($input);
        return response()->json(["data" => $data], 202);
    }
}