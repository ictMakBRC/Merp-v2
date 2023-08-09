<?php

namespace App\Http\Livewire\Procurement\Settings;

use Livewire\Component;

class ProcurementSubcategoriesComponent extends Component
{
    //PROVIDER DOCUMENTS
    public $category;
    public $name;
    public $is_active;

    public function storeSubcategory(){
        
    }
    public function render()
    {
        return view('livewire.procurement.settings.procurement-subcategories-component');
    }
}
