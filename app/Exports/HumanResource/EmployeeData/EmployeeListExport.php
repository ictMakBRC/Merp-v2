<?php

namespace App\Exports\HumanResource\EmployeeData;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\HumanResource\EmployeeData\Employee;

class EmployeeListExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $employeeIds;

    public function __construct(array $employeeIds)
    {
        $this->count = 0;
        $this->employeeIds = $employeeIds;
    }

    public function collection()
    {
        return Employee::with('department', 'designation', 'station')->whereIn('id', $this->employeeIds)->latest()->get();
    }

    public function map($employee): array
    {
        $this->count++;

        return [
            $this->count,
            $employee->employee_number,
            $employee->fullName,
            $employee->gender ?? 'N/A',
            $employee->nationality ?? 'N/A',
            $employee->birth_date ?? 'N/A',
            $employee->email ?? 'N/A',
            str_replace('-', '', $employee->contact ?? 'N/A'),
            $employee->station->name ?? 'N/A',
            $employee->department->name?? 'N/A',
            $employee->designation->name ?? 'N/A',
            $employee->supervisor->fullName?? 'N/A',
            $employee->nssf_number ?? 'N/A',
            $employee->tin_number ?? 'N/A',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Employee Number',
            'Name',
            'Gender',
            'Nationality',
            'DOB',
            'Email',
            'Contact',
            'Station',
            'Department',
            'Designation',
            'Supervisor',
            'SSN',
            'TIN',
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
