<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PadronImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function import() 
    {
        Excel::import(new PadronImport, 'layout.xlsx');
        
        return redirect('/')->with('success', 'All good!');
    }
}
