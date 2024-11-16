<?php

namespace App\Exportar;

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

class PartidaPresupuestariaExcel implements FromCollection, WithMapping, ShouldAutoSize, WithChunkReading, WithHeadings, WithStyles, WithTitle, WithColumnWidths{
    use Exportable;

    public function __construct($partidas_presupuestarias){
        $this->partidas_presupuestarias = $partidas_presupuestarias;
    }

    public function title(): string
    {
        return 'Partidas Presupuestarias';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
            'E' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,//NUMERACION
            'B' => 15,//CODIGO
            'C' => 80,//NOMBRE
            'D' => 100,//DESCRIPCION
            'E' => 15,//ESTADO
        ];
    }

    public function collection()
    {
        return $this->partidas_presupuestarias;
    }

    public function map($row): array
    {
        $status = $row['estado'] == '1' ? 'HABILITADO' : 'NO HABILITADO';
        return [
            $row['numeracion'],
            $row['codigo'],
            $row['nombre'],
            $row['descripcion'],
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            'NUMERACION',
            'CODIGO',
            'PARTIDA',
            'DETALLE',
            'ESTADO',
        ];
    }

    public function chunkSize(): int
    {
        return 1000; // Tamaño del bloque
    }
}
