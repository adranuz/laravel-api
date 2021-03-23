<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

use App\PadronElectoral;


use Illuminate\Support\Facades\DB;

class padron extends DefaultValueBinder implements  WithTitle, WithHeadings,FromQuery, WithCustomValueBinder, ShouldAutoSize
{
    private $candidatoId;
    private $type;

    public function __construct(string $type)
    {
        $this->type  = $type;
    }

    public function bindValue(Cell $cell, $value)
    {

            switch($cell->getCoordinate()){
                case 'F2':
                    $this->setPickupList($cell, 'estados!$B$2:$B$33');
                    return true;
                break;
                case 'N2':
                    $this->setPickupList($cell, 'secciones!$B$2:$B$100');
                    return true;
                break;
                case 'P2':
                    $this->setPickupList($cell, 'estados!$B$2:$B$33');
                    return true;
                break;
                case 'R2':
                    $this->setPickupList($cell, 'municipios!$B$2:$B$2'); 
                    return true;               
                break;
                case 'S2':
                    $this->setPickupList($cell, 'localidades!$B$2:$B$100');
                    return true;
                break;
            }       
            
            return parent::bindValue($cell, $value);
    }

    public function query()
    {
        return PadronElectoral::where('id',1)
                                ->select([
                                    'cve_elector',
                                    'nombre',	
                                    'paterno',	
                                    'materno',	
                                    'sexo',
                                    'lugar_nacimiento',
                                    'nacimiento',	
                                    'ocupacion',
                                    'calle',
                                    'num_ext',
                                    'num_int',
                                    'colonia',
                                    'cp',
                                    'seccion',
                                    'tiempo_residencia',
                                    'entidad',
                                    'distrito',
                                    'municipio',
                                    'localidad',
                                    'fecha_inscripcion_padron'
                                ]);
    }

    private function setPickupList(Cell $cell, $spreadSheet){
        $validation = new DataValidation();
        $validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
        $validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Error');
        $validation->setError('Valor incorrecto');
        $validation->setPromptTitle('Selecciona valores de la lista');
        $validation->setPrompt('Selecciona un valor');
        $validation->setFormula1($spreadSheet);
        $cell->setDataValidation($validation);
        return true;
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
            'cve_elector',
            'nombre',	
            'paterno',	
            'materno',	
            'sexo',
            'lugar_nacimiento',
            'nacimiento',	
            'ocupacion',
            'calle',
            'num_ext',
            'num_int',
            'colonia',
            'cp',
            'seccion',
            'tiempo_residencia',
            'entidad',
            'distrito',
            'municipio',
            'localidad',
            'fecha_inscripcion_padron'
        ];
    }
}
?>