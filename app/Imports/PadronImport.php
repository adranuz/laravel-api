<?php
    namespace App\Imports;

    use Maatwebsite\Excel\Concerns\WithMultipleSheets;
    
    class PadronImport implements WithMultipleSheets 
    {
       
        public function sheets(): array
        {
            return [
                new FirstSheetImport()
            ];
        }
    }
?>