<?php
namespace App\Imports;

use App\Models\PadronElectoral;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class FirstSheetImport implements ToModel, WithValidation
{
    public function model(array $row)
    {
        PadronElectoral::create([ 
            'cve_elector' => $row['cve_elector'] , 
            'paterno' => $row['paterno'], 
            'materno' => $row['materno'], 
            'nombre' => $row['nombre'], 
            'nacimiento' => $row['nacimiento'], 
            'lugar_nacimiento' => $row['lugar_nacimiento'], 
            'sexo' => $row['sexo'], 
            'ocupacion' => $row['ocupacion'], 
            'calle' => $row['calle'], 
            'num_ext' => $row['num_ext'], 
            'num_int' => $row['num_int'], 
            'colonia' => $row['colonia'], 
            'cp' => $row['cp'],
            'seccion' => $row['seccion'],
            'tiempo_residencia' => $row['tiempo_residencia'],
            'entidad' => $row['entidad'] , 
            'distrito' => $row['distrito'], 
            'municipio' => $row['municipio'], 
            'localidad' => $row['localidad'], 
            'manzana' => $row['manzana'], 
            'en_lista_nominal' => $row['en_lista_nominal'], 
            'fecha_inscripcion_padron' => $row['fecha_inscripcion_padron']
        ]);
    }

    public function rules(): array
    {

        return [
            'cve_elector' => 'size:18' , 
            'paterno' => 'alpha', 
            'materno' => 'alpha', 
            'nombre' => 'alpha', 
            'nacimiento' => 'numeric', 
            'lugar_nacimiento' => 'numeric', 
            'sexo' => 'size:1|string', 
            'ocupacion' => 'alpha', 
            'calle' => 'alpha_num', 
            'num_ext' => 'alpha_num', 
            'num_int' => 'alpha_num', 
            'colonia' => 'alpha_num', 
            'cp' => 'alpha_num',
            'seccion' => 'numeric|exists:secciones',
            'tiempo_residencia' => $row['tiempo_residencia'],
            'entidad' => 'numeric|exists:entidades_federales' , 
            'distrito' => 'numeric', 
            'municipio' => 'numeric|exists:municipios', 
            'localidad' => 'numeric|exists:localidades', 
            'manzana' => 'alpha_num', 
            'en_lista_nominal' => $row['en_lista_nominal'], 
            'fecha_inscripcion_padron' => 'numeric'
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $data['municipio'] = Municipio::whereNombre($data['municipio'])->first()->id;
        $data['localidad'] = Municipio::whereNombre($data['localidad'])->first()->id;
        $data['lugar_nacimiento'] = EntidadesFederales::whereNombre($data['lugar_nacimiento'])->first()->id;


        
        return $data;
    }
}
?>