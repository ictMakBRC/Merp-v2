<?php

namespace App\Exports\Inventory;

use App\Models\Inventory\Item\InvDepartmentItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;

class ExportDepartmentItems implements FromCollection, WithHeadings, WithMapping
{
  public $exportIds;
  /**
  * @return \Illuminate\Support\Collection
  */
  public function __construct(array $exportData)
  {
    $this->exportIds = $exportData;
  }
  public function collection()
  {
    return InvDepartmentItem::with('department','item')->whereIn('id', $this->exportIds)->get();
  }
  public function map($item): array
  {
    return [
      $item->item?->name,
      $item->item?->description,
      $item->brand,
      $item->department?->name,
      $item->created_at,
      $item->is_active == 1 ? 'Active' : 'InActive',
    ];
  }

  public function headings(): array
  {
    return [
      'Item',
      'Item Category',
      'Brand',
      'Department / Lab',
      'Date added',
      'Status'
    ];
  }

}
