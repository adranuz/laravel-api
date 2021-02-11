<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeSympathizer;
class TypeSympathizerController extends Controller
{
    public function index(){

        return response()->json(['data' => TypeSympathizer::all()], 200);
    }
}
