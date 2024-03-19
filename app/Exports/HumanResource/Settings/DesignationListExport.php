<?php

namespace App\Exports\HumanResource\Settings;

use App\Models\HumanResource\Settings\Designation;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DesignationListExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $designationIds;

    public function __construct(array $designationIds)
    {
        $this->count = 0;
        $this->designationIds = $designationIds;
    }

    public function collection()
    {
        return Designation::whereIn('id', $this->designationIds)->latest()->get();
    }

    public function map($designation): array
    {
        $this->count++;

        return [
            $this->count,
            $designation->name,
            $designation->description ?? 'N/A',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Description',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
