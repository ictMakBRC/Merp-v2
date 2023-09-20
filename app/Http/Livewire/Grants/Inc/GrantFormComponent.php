<?php

namespace App\Http\Livewire\Grants\Inc;

use Livewire\Component;
use App\Models\Grants\Grant;
use App\Data\Grants\GrantData;
use Illuminate\Support\Facades\DB;
use App\Services\Grants\GrantService;
use App\Models\HumanResource\EmployeeData\Employee;

class GrantFormComponent extends Component
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

    public $grant;
    public $grant_id;

    protected $listeners = [
        'switchGrant' => 'setGrantId',
    ];

    public function setGrantId($details)
    {
        $this->grant_id = $details['grantId'];

        $grant = Grant::findOrFail($this->grant_id);
        $this->grant = $grant;
        
    }

    public function storeGrant()
    {
       
        $grantDTO = new GrantData();
       
        $this->validate($grantDTO->rules());
        // dd('YES');
        DB::transaction(function (){

            $grantDTO = GrantData::from([
                'grant_code' => $this-> grant_code,
                'grant_name' => $this->grant_name,
                'grant_type' => $this->grant_type,
                'funding_source' => $this->funding_source,
                'funding_amount' => $this->funding_amount,
                'currency' => $this->currency,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'proposal_submission_date' => $this->proposal_submission_date,
                'pi' => $this->pi,
                'proposal_summary' => $this->proposal_summary,
                'award_status' => $this->award_status,
                ]
            );

            $grantService = new GrantService();
            $grant = $grantService->createGrant($grantDTO);

            $this->emit('grantCreated', [
                'grantId' => $grant->id,
            ]);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Grant details created successfully']);
            $this->reset($grantDTO->resetInputs());

        });
    }

    public function updateGrant()
    {
        $grantDTO = new GrantData();
        $this->validate($grantDTO->rules());

        DB::transaction(function (){

            $grantDTO = GrantData::from([
                'grant_code' => $this-> grant_code,
                'grant_name' => $this->grant_name,
                'grant_type' => $this->grant_type,
                'funding_source' => $this->funding_source,
                'funding_amount' => $this->funding_amount,
                'currency' => $this->currency,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'proposal_submission_date' => $this->proposal_submission_date,
                'pi' => $this->pi,
                'proposal_summary' => $this->proposal_summary,
                'award_status' => $this->award_status,
                ]
            );
  
            $grantService = new GrantService();

            $grant = $grantService->updateGrant($this->grant,$grantDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Grant details updated successfully']);

            $this->reset($grantDTO->resetInputs());

        });
    }

    public function render()
    {
        $data['employees'] = Employee::where('is_active',true)->get();
        return view('livewire.grants.inc.grant-form-component',$data);
    }
}
