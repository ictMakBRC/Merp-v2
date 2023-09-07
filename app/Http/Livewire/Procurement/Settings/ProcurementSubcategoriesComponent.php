<?php

namespace App\Http\Livewire\Procurement\Settings;

use Livewire\Component;
use App\Models\Procurement\Settings\ProcurementSubcategory;
use Livewire\WithPagination;

class ProcurementSubcategoriesComponent extends Component
{
    use WithPagination;
    public $category;
    public $name;
    public $is_active;

    public $from_date;

    public $to_date;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $subcategoryIds =[];

    public function storeSubcategory(){
        $this->validate([
            'category' => 'required|string',
            'name' => 'required|string|unique:proc_subcategories',
            'is_active' => 'required|boolean',
        ]);

        $subcategory = ProcurementSubcategory::create([
            'category'=>$this->category,
            'name'=>$this->name,
            'is_active'=>$this->is_active,

            ]
        );

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Sector Subcategory created successfully']);

        $this->reset([
            'category',
            'name',
            'is_active',
        ]);
    }
 
    public function filterSubcategories()
    {
        $subcategories = ProcurementSubcategory::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->subcategoryIds = $subcategories->pluck('id')->toArray();

        return $subcategories;
    }

    public function render()
    {
        $data['subcategories'] = $this->filterSubcategories()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.procurement.settings.procurement-subcategories-component',$data);
    }
}
