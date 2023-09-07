<?php

namespace App\Exports\Inventory;

use App\Models\Inventory\Item\InvItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCommodities implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return InvItem::all();
    }
}
