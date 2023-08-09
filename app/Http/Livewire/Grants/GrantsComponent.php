<?php

namespace App\Http\Livewire\Grants;

use Livewire\Component;

class GrantsComponent extends Component
{
    public $grant_code;
    public $grant_name;
    public $grant_type;
    public $funding_source;
    public $funding_amount;
    public $currency;
    public $start_date;
    public $end_date;
    public $proposal_submission_date;
    public $pi;
    public $proposal_summary;
    public $award_status;

    public function storeGrantProfile(){
        
    }

    public function render()
    {
        return view('livewire.grants.grants-component');
    }
}
