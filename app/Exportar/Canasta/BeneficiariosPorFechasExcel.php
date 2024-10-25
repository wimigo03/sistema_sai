<?php

namespace App\Exportar\Canasta;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;



use Carbon\Carbon;

class BeneficiariosPorFechasExcel implements FromCollection, WithMapping, ShouldAutoSize, WithChunkReading, WithHeadings, WithStyles, WithTitle, WithColumnWidths{
    use Exportable;
    private $rowNumber = 0;

    public function __construct($beneficiarios){
        $this->beneficiarios = $beneficiarios;
    }

    public function title(): string
    {
        return 'Beneficiarios';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
            'A' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT]],
            'B' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'G' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'H' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'I' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'J' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'K' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'L' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'M' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'N' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'O' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'P' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,//NRO
            'B' => 10,//DTTO
            'C' => 50,//BARRIO
            'D' => 30,//NOMBRES
            'E' => 30,//AP. PATERNO
            'F' => 30,//AP. MATERNO
            'G' => 15,//NRO. CARNET
            'H' => 10,//EXPEDIDO
            'I' => 15,//FECHA NAC.
            'J' => 15,//ESTADO CIVIL
            'K' => 10,//SEXO
            'L' => 10,//FIRMA
            'M' => 20,//CELULAR
            'N' => 10,//ESTADO
            'O' => 10,//CENSADO
            'P' => 20,//FECHA
            'Q' => 50,//OBSERVACIONES
        ];
    }

    public function collection()
    {
        return $this->beneficiarios;
    }

    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $row['distrito'],
            $row['barrio'],
            $row['nombres'],
            $row['apellido_paterno'],
            $row['apellido_materno'],
            $row['nro_carnet'],
            $row['expedido'],
            $row['_fecha_nac'],
            $row['estado_civil'],
            $row['sexo'],
            $row['firma'],
            $row['celular'],
            $row['_estado'],
            $row['_censado'],
            $row['_fecha'],
            $row['observacion'],
        ];
    }

    public function headings(): array
    {
        return [
            'N°',
            'DTTO.',
            'BARRIO',
            'NOMBRE COMPLETO',
            'AP. PATERNO',
            'AP. MATERNO',
            'NRO_CARNET',
            'EXPEDIDO',
            'FECHA NAC.',
            'ESTADO CIVIL',
            'SEXO',
            'FIRMA',
            'CELULAR',
            'ESTADO',
            'CENSADO',
            'FECHA EVENTO',
            'ULTIMA OBSERVACION',
        ];
    }

    public function chunkSize(): int
    {
        return 1000; // Tamaño del bloque
    }
}
