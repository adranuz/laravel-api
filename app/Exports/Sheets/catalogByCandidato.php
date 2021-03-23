<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Illuminate\Support\Facades\DB;

class catalogByCandidato implements FromQuery, WithTitle, WithHeadings,ShouldAutoSize
{
    private $candidatoId;
    private $type;

    public function __construct(int $candidatoId, string $type)
    {
        $this->candidatoId = $candidatoId;
        $this->type  = $type;
    }

    /**
     * @return Builder
     */
    public function query()
    {

        $clave_municipio = 8;
        $result = [];

        switch($this->type){
            case 'estados':
                $result = DB::table('entidades_federales')->select(['id','nombre'])->orderBy('id','asc');
            break;
            case 'municipios':
                $result = DB::table('municipios')->where('clave_municipio',$clave_municipio)->select(['id', 'nombre'])->orderBy('clave_municipio','asc');
                
            break;
            case 'localidades':
                $result = DB::table('localidades')->where('clave_municipio',$clave_municipio)->select(['id', 'nombre'])->orderBy('nombre','asc');
            break;
            case 'secciones':
                $result =  DB::table('secciones')->where('clave_municipio',$clave_municipio)->select(['id', 'seccion'])->orderBy('seccion','asc');
            break;
        }

        return $result;
        
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->type;
    }

    public function headings(): array
    {
        return [            
            'ID',
            $this->type
        ];
    }
}
?>