<?php

namespace App\Http\Livewire\Procurement\Requests\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Data\Procurement\Requests\ProcurementRequestData;
use App\Services\Procurement\Requests\ProcurementRequestService;

class ProcurementRequestFormComponent extends Component
{
    public $budget_line;
    public $request_type;
    public $project_id;
    public $subject;
    public $body;
    public $procuring_entity_code;
    public $procurement_sector;
    public $financial_year;
    public $currency;
    public $sequence_number;
    public $procurement_plan_ref;
    public $location_of_delivery;
    public $date_required;

    public $procurementRequest;
    public $procurement_request_id;
    public $loadingInfo='';

    protected $listeners = [
        'loadProcurementRequest'=>'loadProcurementRequest',
    ];

    public function updatedProjectId(){
        $this->currency=Project::findOrFail($this->project_id)->currency;
    }

    public function loadProcurementRequest($details)
    {
        $this->procurement_request_id = $details['procurementRequestId'];
        $this->loadingInfo = $details['info'];

        $procurementRequest=ProcurementRequest::findOrFail($this->procurement_request_id);
        $this->procurementRequest = $procurementRequest;
        $this->budget_line = $procurementRequest->budget_line;
        $this->request_type = $procurementRequest->request_type;
        $this->project_id = $procurementRequest->requestable->id;
        // if ($this->request_type == 'Departmental') {
        //     $this->project_id = $procurementRequest->requestable->id;
        // } else {
        //     $this->project_id = $procurementRequest->requestable->id;
        // }
        
        $this->subject = $procurementRequest->subject;
        $this->body = $procurementRequest->body;
        $this->procuring_entity_code = $procurementRequest->procuring_entity_code;
        $this->procurement_sector = $procurementRequest->procurement_sector;
        $this->financial_year = $procurementRequest->financial_year;
        $this->currency = $procurementRequest->currency;
        $this->sequence_number = $procurementRequest->sequence_number;
        $this->procurement_plan_ref = $procurementRequest->procurement_plan_ref;
        $this->location_of_delivery = $procurementRequest->location_of_delivery;
        $this->date_required = $procurementRequest->date_required;

    }

    public function storeProcurementRequest()
    {
        $procurementRequestDTO = new ProcurementRequestData();
        $this->validate($procurementRequestDTO->rules());

        DB::transaction(function (){

            if ($this->request_type == 'Departmental') {
                // dd('TRUE');
                $requestableModel = Department::findOrFail(auth()->user()->employee->department->id);

            } else {
                $requestableModel = Project::findOrFail($this->project_id);
            }

            
            $procurementRequestDTO = ProcurementRequestData::from([
                'budget_line' => $this->budget_line,
                'request_type' => $this->request_type,
                'subject' => $this->subject,
                'body' => $this->body,
                'procuring_entity_code' => $this->procuring_entity_code,
                'procurement_sector' => $this->procurement_sector,
                'financial_year' => $this->financial_year,
                'currency' => $this->currency,
                'sequence_number' => $this->sequence_number,
                'procurement_plan_ref' => $this->procurement_plan_ref,
                'location_of_delivery' => $this->location_of_delivery,
                'date_required' => $this->date_required,

                ]
            );
  
            $procurementRequestService = new ProcurementRequestService();
            $procurementRequest = $procurementRequestService->createProcurementRequest($requestableModel,$procurementRequestDTO);


            $loadingInfo = 'For '.$procurementRequest->subject.' | '.$procurementRequest->reference_no;
            $this->emit('procurementRequestCreated', [
                'procurementRequestId' => $procurementRequest->id,
                'info'=>$loadingInfo,
            ]);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Request created successfully']);

            $this->reset($procurementRequestDTO->resetInputs());

        });
    }

    public function updateProcurementRequest()
    {
        $procurementRequestDTO = new ProcurementRequestData();
        $this->validate($procurementRequestDTO->rules());

        DB::transaction(function (){

            $procurementRequestDTO = ProcurementRequestData::from([
                'budget_line' => $this->budget_line,
                'request_type' => $this->request_type,
                'subject' => $this->subject,
                'body' => $this->body,
                'procuring_entity_code' => $this->procuring_entity_code,
                'procurement_sector' => $this->procurement_sector,
                'financial_year' => $this->financial_year,
                'currency' => $this->currency,
                'sequence_number' => $this->sequence_number,
                'procurement_plan_ref' => $this->procurement_plan_ref,
                'location_of_delivery' => $this->location_of_delivery,
                'date_required' => $this->date_required,

                ]
            );

            $procurementRequestService = new ProcurementRequestService();
            $procurementRequest = $procurementRequestService->updateProcurementRequest($this->procurementRequest,$procurementRequestDTO);

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Request updated successfully']);

            $this->reset($procurementRequestDTO->resetInputs());

        });
    }


    public function render()
    {
        $data['projects'] = Project::all();
        return view('livewire.procurement.requests.inc.procurement-request-form-component',$data);
    }
}