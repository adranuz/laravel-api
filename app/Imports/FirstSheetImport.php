<?php
namespace App\Imports;

use App\Models\PadronElectoral;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterExport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class FirstSheetImport implements ToCollection,  WithHeadingRow, WithValidation
{
    private $rows = 0;

    public function collection(Collection $rows)
    {

            ++$this->rows;

            foreach ($rows as $row) {
                
                PadronElectoral::updateOrCreate(['cve_elector' => $row['cve_elector']],
                    [ 
                    'cve_elector' => $row['cve_elector'] , 
                    'paterno' => $row['paterno'], 
                    'materno' => $row['materno'], 
                    'nombre' => $row['nombre'], 
                    'nacimiento' => $row['nacimiento'],                     
                    'sexo' => $row['sexo'], 
                    'ocupacion' => $row['ocupacion'], 
                    'calle' => $row['calle'], 
                    'num_ext' => $row['num_ext'], 
                    'num_int' => $row['num_int'], 
                    'colonia' => $row['colonia'], 
                    'cp' => $row['cp'],
                    'seccion' => $row['seccion'],
                    'lugar_nacimiento' => $row['lugar_nacimiento'], 
                    'tiempo_residencia' => $row['tiempo_residencia'],
                    'entidad' => $row['entidad'] , 
                    'distrito' => $row['distrito'], 
                    'municipio' => $row['municipio'], 
                    'localidad' => $row['localidad'], 
                    'fecha_inscripcion_padron' => $row['fecha_inscripcion_padron']
                ]);         
            }
        
    }

    public function rules(): array
    {

        return [
            '*.cve_elector' => 'size:18' , 
            '*.paterno' => 'regex:/^[a-zA-Z\s]*$/', 
            '*.materno' => 'regex:/^[a-zA-Z\s]*$/', 
            '*.nombre' => 'regex:/^[a-zA-Z\s]*$/', 
            '*.nacimiento' => 'numeric', 
            '*.lugar_nacimiento' => 'numeric', 
            '*.sexo' => 'size:1|string', 
            '*.ocupacion' => 'alpha', 
            '*.calle' => 'regex:/^[a-zA-Z\s]*$/', 
            '*.num_ext' => '', 
            '*.num_int' => '', 
            '*.colonia' => 'regex:/^[A-Z0-9 _]*[A-Z0-9][A-Z0-9 _]*$/', 
            '*.cp' => 'alpha_num',
            '*.seccion' => 'numeric|exists:secciones,id',
            '*.tiempo_residencia' => 'numeric',
            '*.entidad' => 'numeric|exists:entidades_federales,id' , 
            '*.distrito' => 'numeric', 
            '*.municipio' => 'numeric|exists:municipios,clave_municipio', 
            '*.localidad' => 'numeric|exists:localidades,id', 
            '*.manzana' => 'alpha_num', 
            '*.fecha_inscripcion_padron' => 'numeric'
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $data['municipio'] = $data['municipio'] != ''  ? DB::table('municipios')->where('nombre',$data['municipio'])->first()->clave_municipio : null;
        $data['localidad'] = $data['localidad'] != '' ? DB::table('localidades')->where('nombre','LIKE' ,'%'.$data['localidad'].'%')->first()->id : null;
        $data['lugar_nacimiento'] = $data['lugar_nacimiento'] != '' ? DB::table('entidades_federales')->where('nombre', $data['lugar_nacimiento'])->first()->id : null;
        $data['entidad'] = $data['entidad'] != '' ? DB::table('entidades_federales')->where('nombre', $data['entidad'])->first()->id : null;
        $data['seccion'] = $data['seccion'] != '' ? DB::table('secciones')->where('seccion', $data['seccion'])->first()->id : null;

        return $data;
    }

    public function customValidationMessages()
    {
        return [
            'cve_elector.unique' => 'El valor de :attribute, ya existe en la base de datos',
            'cve_elector.size' => 'El valor de :attribute. no coincide con la longitud requerida(18 digitos)',
            'municipio.numeric' => 'El valor de :attribute, no es un número entero',
            'localidad.numeric' => 'El valor de :attribute, no es un número entero',
            'lugar_nacimiento.numeric' => 'El valor de :attribute, no es un número entero',
            'entidad.numeric' => 'El valor de :attribute, no es un número entero',
            'seccion.numeric' => 'El valor de :attribute, no es un número entero',
        ];
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            AfterExport::class => function(AfterExport $event) {
                $this->getRowCount();
            },
        ];
    }
    /*public function mapping(): array
    {
        return [
            'cve_elector' => 'A1',
            'nombre' => 'B1', 
            'paterno' => 'C1', 
            'materno' => 'D1',
            'sexo' => 'E1',
            'lugar_nacimiento' => 'F1',             
            'nacimiento' => 'G1',                         
            'ocupacion' => 'H1', 
            'calle' => 'I1', 
            'num_ext' => 'J1', 
            'num_int' => 'K1', 
            'colonia' => 'L1', 
            'cp' => 'M1',
            'seccion' => 'N1',
            'tiempo_residencia' => 'O1',
            'entidad' => 'P1' , 
            'distrito' => 'Q1', 
            'municipio' => 'R1', 
            'localidad' => 'S1', 
            'manzana' => 'T1', 
            'fecha_inscripcion_padron' => 'U1'
        ];
    }*/
}
?>