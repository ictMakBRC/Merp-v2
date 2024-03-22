<?php

namespace App\Exports\HumanResource\Settings;

use App\Models\HumanResource\Settings\Department;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DepartmentListExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $departmentIds;

    public function __construct(array $departmentIds)
    {
        $this->count = 0;
        $this->departmentIds = $departmentIds;
    }

    public function collection()
    {
        return Department::with('dept_supervisor', 'ast_supervisor')->whereIn('id', $this->departmentIds)->latest()->get();
    }

    public function map($department): array
    {
        $this->count++;

        return [
            $this->count,
            $department->prefix??'N/A',
            $department->name,
            $department->type ?? 'N/A',
            $department->dept_supervisor->fullName ?? 'N/A',
            $department->ast_supervisor->fullName ?? 'N/A',
            $department->description ?? 'N/A',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'ShortCode',
            'Name',
            'Type',
            'Supervisor',
            'Asst Supervisor',
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
