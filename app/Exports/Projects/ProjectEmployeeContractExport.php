<?php

namespace App\Exports\Projects;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Grants\Project\EmployeeProject;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectEmployeeContractExport implements FromCollection, WithMapping, WithHeadings, WithStyles
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
        return EmployeeProject::with('employee','project','project.currency','designation')
        ->addSelect([
            'employee_project.*', // Include other fields from the contracts table
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
            $contract->project->project_code,
            $contract->employee?->designation?->name ?? 'N/A',
            formatDate($contract->start_date) ?? 'N/A',
            formatDate($contract->end_date) ?? 'N/A',
            $contract->fte,
            $contract->project->currency->code.''.moneyFormat($contract->gross_salary) ?? 'N/A',
            $contract->end_date >= today()? ($contract->days_to_expire >= 0? '+'.$contract->days_to_expire.'days':''):'Expired',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Employee Number',
            'Name',
            'Project',
            'Designation',
            'Start Date',
            'End Date',
            'FTE',
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
