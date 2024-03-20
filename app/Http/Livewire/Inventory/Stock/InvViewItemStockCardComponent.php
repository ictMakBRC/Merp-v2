<?php

namespace App\Http\Livewire\Inventory\Stock;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inventory\Stock\InvItemStockCard;

class InvViewItemStockCardComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;
    public $item_id;
    public function mount($id)
    {
        $this->item_id = $id;
    }
    public function mainQuery()
    {
        $services = InvItemStockCard::search($this->search)->where('inv_item_id',$this->item_id)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        // $this->exportData = $services->pluck('id')->toArray();

        return $services;
    }
    public function render()
    {
        $data['stockcards'] =$this->mainQuery()->with(['departmentItem','departmentItem.item','createdBy'])->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.inventory.stock.inv-view-item-stock-card-component', $data);
    }
}
