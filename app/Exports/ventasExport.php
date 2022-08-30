<?php

namespace App\Exports;

use App\Models\Venta;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ventasExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->datosPDF;
    }
/* 
public function drawings()
{
    $drawing = new Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('Logo CDK');
    $drawing->setPath(public_path('vendor/adminlte/dist/img/AdminLTELogo.png'));
    $drawing->setHeight(100);
    $drawing->setCoordinates('K1');

    return $drawing;
} */
    
    public function map($datos): array
    {
        return [
            $datos->id_venta,
            $datos->user_sede,
            $datos->user_create_venta,
            $datos->nombre_emb,
            $datos->matricula_emb,
            $datos->nombre_tipo_pago,
            $datos->fecha_venta,
            $datos->precio_x_galon_venta,
            $datos->galonaje_venta,
            $datos->precio_venta,
        ];
    }
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT,
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => '10',
            'B' => '30',
            'C' => '20',
            'D' => '20',
            'E' => '20',
            'F' => '30',
            'G' => '20',
            'H' => '20',
            'I' => '20',
            'J' => '20',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:J1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('0016A2');

                $event->sheet->getDelegate()->getStyle('A1:J1')
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');
            },
        ];
    }
    public function headings(): array
    {
        return [
            'ID VENTA',
            'PUNTO',
            'OPERARIO',
            'EMBARCACIÓN PESQUERA',
            'MATRICULA',
            'TIPO DE PAGO',
            'FECHA',
            'PRECIO POR GALON',
            'GALONES',
            'PAGO',
        ];
    }
    public function __construct($datosPDF)
    {
        $this->datosPDF = $datosPDF;
    }
}
