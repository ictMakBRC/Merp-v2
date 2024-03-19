<?php

namespace App\Exports\Projects;

use App\Models\Grants\Project\Project;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GrantListExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $projectIds;

    public function __construct(array $projectIds)
    {
        $this->count = 0;
        $this->projectIds = $projectIds;
    }

    public function collection()
    {
        return Project::with('sponsor', 'principalInvestigator', 'coordinator')->whereIn('id', $this->projectIds)->latest()->get();
    }

    public function map($project): array
    {
        $this->count++;

        return [
            $this->count,
            $project->project_code,
            $project->project_category,
            $project->project_type ?? 'N/A',
            $project->name ?? 'N/A',
            $project->sponsor->name ?? 'N/A',
            $project->funding_amount ?? 'N/A',
            $project->currency->code ?? 'N/A',
            $project->start_date ?? 'N/A',
            $project->end_date?? 'N/A',
            $project->principalInvestigator->fullName ?? 'N/A',
            $project->coordinator->fullName?? 'N/A',
            $project->progress_status ?? 'N/A',
           
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Code',
            'Category',
            'Type',
            'Name',
            'Sponsor',
            'Funding Amount',
            'Currency',
            'Start Date',
            'End Date',
            'Principle Investigator',
            'Coordinator',
            'Progress Status',
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
