<?php

namespace App\Http\Livewire\Procurement\Settings\Inc;

use Livewire\Component;

class ProviderSectorsComponent extends Component
{
    //Provider Categories
    public $provider_id;
    public $categories=[];
   
    public function storeCategories(){
        
    }

    public function render()
    {
        return view('livewire.procurement.settings.inc.provider-sectors-component');
    }
}
