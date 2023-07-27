<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithProperties
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $userIds;

    public function __construct(array $userIds)
    {
        $this->count = 0;
        $this->userIds = $userIds;
    }

    public function properties(): array
    {
        return [
            'creator' => auth()->user()->fullName,
            'lastModifiedBy' => 'NIMS',
            'title' => 'Users',
            'description' => 'Users export',
            'subject' => 'Users export',
            'keywords' => 'NIMS exports',
            'category' => 'NIMS Exports',
            'manager' => 'AFRICA PGI',
            'company' => 'AFRICA PGI',
        ];
    }

    public function collection()
    {
        return User::with('institution', 'institution.country', 'institution.country.region')->whereIn('id', $this->userIds)->latest()->get();
    }

    public function map($user): array
    {
        $this->count++;

        return [
            $this->count,
            $user->fullName,
            $user->name,
            $user->category ?? 'N/A',
            $user->institution->country->region->name ?? 'N/A',
            $user->institution->country->name ?? 'N/A',
            $user->institution->name ?? 'N/A',
            $user->email ?? 'N/A',
            str_replace('-', '', $user->contact ?? 'N/A'),
            $user->is_active === 1 ? 'Active' : 'Suspended',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Username',
            'Category',
            'Region',
            'Country',
            'Institution',
            'Email',
            'Contact',
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
