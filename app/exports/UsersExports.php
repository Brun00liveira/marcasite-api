<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Illuminate\Support\Collection;

class UsersExports implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
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
                $item->name,
                $item->email,
                $item->phone,
                $item->cpf,
                $item->customer ? $item->customer->subscription->billing_type ?? '' : '',
                $item->customer ? $item->customer->subscription->value ?? '' : '',
                $item->customer ? $item->customer->subscription->due_date ?? '' : '',
                $item->customer ? $item->customer->subscription->status ?? '' : ''

            ];
        }

        return new Collection($data);
    }

    public function headings(): array
    {
        return [
            'Nome',
            'E-mail',
            'Phone',
            'CPF',
            'Forma de Pagamento',
            'Valor',
            'Vencimento',
            'status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
