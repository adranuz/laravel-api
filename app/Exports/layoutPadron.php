<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\catalogByCandidato;
use App\Exports\Sheets\padron;
class layoutPadron implements WithMultipleSheets
{
    use Exportable;

    protected $candidatoId;
    
    public function __construct(int $candidatoId)
    {
        $this->candidatoId = $candidatoId;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new padron('informacion');
        $sheets[] = new catalogByCandidato($this->candidatoId, 'estados');
        $sheets[] = new catalogByCandidato($this->candidatoId, 'municipios');
        $sheets[] = new catalogByCandidato($this->candidatoId, 'localidades');
        $sheets[] = new catalogByCandidato($this->candidatoId, 'secciones');
        

        return $sheets;
    }
}
?>