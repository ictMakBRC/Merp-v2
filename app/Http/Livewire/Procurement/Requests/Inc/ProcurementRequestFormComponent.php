<?php

namespace App\Http\Livewire\Procurement\Requests\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\HumanResource\Settings\Station;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\HumanResource\Settings\Department;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Data\Procurement\Requests\ProcurementRequestData;
use App\Models\Procurement\Settings\ProcurementSubcategory;
use App\Services\Procurement\Requests\ProcurementRequestService;

class ProcurementRequestFormComponent extends Component
{
    public $budget_line_id;
    public $request_type;
    public $project_id;
    public $subject;
    public $body;
    public $procuring_entity_code;
    public $procurement_sector;
    public $subcategory_id;
    public $financial_year_id;
    public $currency_id;
    // public $sequence_number;
    public $procurement_plan_ref;
    public $location_of_delivery;
    public $date_required;

    public $procurementRequest;
    public $procurement_request_id;
    public $loadingInfo='';

    public $budget_line_balance;
    public $currency;
    public $subcategories;

    public $editMode=false;

    protected $listeners = [
        'loadProcurementRequest'=>'loadProcurementRequest',
    ];

    public function mount(){
        $this->subcategories=collect([]);
    }

    public function updatedBudgetLineId(){
        $budgetLine = FmsBudgetLine::with('budget','budget.currency')->findOrFail($this->budget_line_id);
        $this->currency_id = $budgetLine->budget->currency_id;
        $this->currency = $budgetLine->budget->currency->code;
        $this->budget_line_balance = $budgetLine->primary_balance;
    }

    public function updatedProcurementSector(){
        $this->subcategories = ProcurementSubcategory::where('category',$this->procurement_sector)->get();
    }

    public function loadProcurementRequest($details)
    {
        $this->procurement_request_id = $details['procurementRequestId'];
        $this->loadingInfo = $details['info'];
        $procurementRequest=ProcurementRequest::findOrFail($this->procurement_request_id);
        $this->procurementRequest = $procurementRequest;

        $this->request_type = $procurementRequest->request_type;
        if ($this->request_type != 'Department') {
            $this->project_id = $procurementRequest->requestable->id;
        }

        $this->financial_year_id = $procurementRequest->financial_year_id;
        $this->currency_id = $procurementRequest->currency_id;
        $this->budget_line_id = $procurementRequest->budget_line_id;
        $budgetLine = FmsBudgetLine::with('budget','budget.currency')->findOrFail($this->budget_line_id);
        $this->currency = $budgetLine->budget->currency->code;
        $this->budget_line_balance = $budgetLine->primary_balance;
        
        
        $this->subject = $procurementRequest->subject;
        $this->body = $procurementRequest->body;
        $this->procuring_entity_code = $procurementRequest->procuring_entity_code;
        $this->procurement_sector = $procurementRequest->procurement_sector;
        $this->subcategories = ProcurementSubcategory::where('category',$this->procurement_sector)->get();
        $this->subcategory_id = $procurementRequest->subcategory_id;
     
        // $this->sequence_number = $procurementRequest->sequence_number;
        $this->procurement_plan_ref = $procurementRequest->procurement_plan_ref;
        $this->location_of_delivery = $procurementRequest->location_of_delivery;
        $this->date_required = $procurementRequest->date_required;

        $this->editMode=true;

    }

    public function storeProcurementRequest()
    {
        $procurementRequestDTO = new ProcurementRequestData();
        $this->validate($procurementRequestDTO->rules());

        DB::transaction(function (){

            if ($this->request_type == 'Department') {
                // dd('TRUE');
                $requestableModel = Department::findOrFail(auth()->user()->employee->department->id);

            } else {
                $requestableModel = Project::findOrFail($this->project_id);
            }

            $procurementRequestDTO = ProcurementRequestData::from([
                'budget_line_id' => $this->budget_line_id,
                'request_type' => $this->request_type,
                'subject' => $this->subject,
                'body' => $this->body,
                'procuring_entity_code' => $this->procuring_entity_code,
                'procurement_sector' => $this->procurement_sector,
                'subcategory_id' => $this->subcategory_id,
                'financial_year_id' => $this->financial_year_id,
                'currency_id' => $this->currency_id,
                // 'sequence_number' => $this->sequence_number,
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

            $this->reset(...$procurementRequestDTO->resetInputs(),...['budget_line_balance','currency']);

        });
    }

    public function updateProcurementRequest()
    {
        $procurementRequestDTO = new ProcurementRequestData();
        $this->validate($procurementRequestDTO->rules());

        DB::transaction(function (){

            $procurementRequestDTO = ProcurementRequestData::from([
                'budget_line_id' => $this->budget_line_id,
                'request_type' => $this->request_type,
                'subject' => $this->subject,
                'body' => $this->body,
                'procuring_entity_code' => $this->procuring_entity_code,
                'procurement_sector' => $this->procurement_sector,
                'subcategory_id' => $this->subcategory_id,
                'financial_year_id' => $this->financial_year_id,
                'currency_id' => $this->currency_id,
                // 'sequence_number' => $this->sequence_number,
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
        $data['projects'] = auth()->user()->employee->projects??Collect([]);
        $data['financial_years'] = FmsFinancialYear::where('is_budget_year',true)->get();
        $data['stations'] = Station::where('is_active',true)->get();

        $data['budget_lines'] = FmsBudgetLine::where('type','Expense')->whereHas('budget', function ($query) {
            $query->where(['fiscal_year' => $this->financial_year_id,'department_id' => auth()->user()->employee->department_id]);
        })->latest()->get();
        
        if ($this->project_id) {
            $data['budget_lines'] = FmsBudgetLine::where('type','Expense')->whereHas('budget', function ($query) {
                $query->where(['fiscal_year' => $this->financial_year_id,'project_id' => $this->project_id]);
            })->latest()->get();
            
            $data['ledger']=Project::findOrFail($this->project_id)->ledger;
        }else{
            $data['ledger']=auth()->user()->employee->department->ledger;
        }

        return view('livewire.procurement.requests.inc.procurement-request-form-component',$data);
    }
}
