<?php

namespace App\Exports\HumanResource\EmployeeData\OfficialContract;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;

class EmployeeContractExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $contractIds;

    public function __construct(array $contractIds)
    {
        $this->count = 0;
        $this->contractIds = $contractIds;
    }

    public function collection()
    {
        return OfficialContract::with('employee','employee.department','employee.designation','currency')->whereIn('id', $this->contractIds)
        ->addSelect([
            'official_contracts.*', // Include other fields from the contracts table
            DB::raw('DATEDIFF(end_date, CURRENT_DATE()) as days_to_expire')
        ])
        ->latest()->get();
    }

    public function map($contract): array
    {
        $this->count++;

        return [
            $this->count,
            $contract->employee->employee_number,
            $contract->employee->fullname,
            $contract->employee?->department?->name ?? 'N/A',
            $contract->employee?->designation?->name ?? 'N/A',
            formatDate($contract->start_date) ?? 'N/A',
            formatDate($contract->end_date) ?? 'N/A',
            $contract->currency->code.''.moneyFormat($contract->gross_salary) ?? 'N/A',
            $contract->end_date >= today()? ($contract->days_to_expire >= 0? '+'.$contract->days_to_expire.'days':''):'Expired',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Employee Number',
            'Name',
            'Department',
            'Designation',
            'Start Date',
            'End Date',
            'Gross Salary',
            'Status',
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
