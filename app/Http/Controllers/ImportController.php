<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PadronImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function importPadron() 
    {
        
        try {
            Excel::import(new PadronImport, storage_path('framework/laravel-excel/LAYOUT-IMPORTACION.xlsx'));
            return 'ok, alls good';
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             
             foreach ($failures as $failure) {
                 $failure->row(); // row that went wrong
                 $failure->attribute(); // either heading key (if using heading row concern) or column index
                 $failure->errors(); // Actual error messages from Laravel validator
                 $failure->values(); // The values of the row that has failed.                 
             }

             return $failures;
        }
        
    }
}
