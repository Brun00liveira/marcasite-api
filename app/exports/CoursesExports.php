<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Illuminate\Support\Collection;

class CoursesExports implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {

        $data = [];


        foreach ($this->data as $item) {

            $data[] = [
                $item->title,
                $item->category ? $item->category->name : 'Sem categoria',
                $item->enrollments_count
            ];
        }

        return new Collection($data);
    }

    public function headings(): array
    {
        return [
            'Nome',
            'Categoria',
            'Qte. de Inscritos',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
