<?php

namespace App\Exports\HumanResource\Settings;

use App\Models\HumanResource\Settings\Station;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StationListExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $stationIds;

    public function __construct(array $stationIds)
    {
        $this->count = 0;
        $this->stationIds = $stationIds;
    }

    public function collection()
    {
        return Station::whereIn('id', $this->stationIds)->latest()->get();
    }

    public function map($station): array
    {
        $this->count++;

        return [
            $this->count,
            $station->name,
            $station->description ?? 'N/A',
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
