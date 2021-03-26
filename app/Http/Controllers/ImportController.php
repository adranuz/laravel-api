<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PadronImport;
use App\Import;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function importPadron(Request $request, int $candidato_id) 
    {        

        $fileName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(storage_path('framework/laravel-excel'), $fileName);
        //return $fileName;
        try {
            
            $import = new PadronImport;            
            Excel::import($import, storage_path('framework/laravel-excel/'.$fileName));
            
            
            $import = Import::create(['url' => 'none',
                                      'state' => 'success',
                                      'message' => 'Importacion correcta',
                                      'type' => 'poblacion',
                                      'total' => 0,
                                      'candidato_id' => $candidato_id,
                                      'created_by' => $request->user_id]);
            return $import;

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             $errors = '';
             foreach ($failures as $failure) {
                 $failure->row(); // row that went wrong
                 $failure->attribute(); // either heading key (if using heading row concern) or column index
                 $errors .= " FILA: ". $failure->row().' ERROR: '.implode(',', $failure->errors()).'|'; // Actual error messages from Laravel validator
                 $failure->values(); // The values of the row that has failed.
             }

             $import = Import::create(['url' => 'none',
                                       'state' => 'error',
                                       'message' => $errors,
                                       'type' => 'poblacion',
                                       'total' => 0,
                                       'candidato_id' => $candidato_id,
                                       'created_by' => $request->user_id]);
             return $import;
        }        
    }

    public function byCandidato($candidato_id){

        $result = ['data' => [], 
                   'message' => 'no encontrados',
                   'state' => '404',
                   'total' => 0];

        $importsRecords = Import::where('candidato_id', $candidato_id)
                                ->orderBy('created_at','desc')
                                ->get();

        if(!$importsRecords->isEmpty()){
            $result = ['data' => $importsRecords, 
            'message' => 'encontrados', 
            'state' => '404',
            'total' => $importsRecords->count()];
        }

        return response()->json($result);
    }
}
