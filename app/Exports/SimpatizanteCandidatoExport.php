<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class SimpatizanteCandidatoExport implements FromCollection, WithHeadings
{
    use Exportable;


    public function __construct(Array $input)
    {
        $this->headers = $input['headers'];
        $this->data= $input['data'];
    }


    public function collection()
    {        
        return $this->data;        
    }

    public function headings(): array
    {
        return $this->headers;
    }
 
}
?>