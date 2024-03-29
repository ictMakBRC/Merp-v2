<?php

namespace App\Http\Livewire\Finance\Budget;

use App\Models\Finance\Budget\FmsBudget;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\Finance\Settings\FmsCurrencyUpdate;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Services\GeneratorService;
use Livewire\Component;
use Livewire\WithPagination;

class FmsBudgetsComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $budgetIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $is_active = 1;

    public $edit_id;

    public $delete_id;

    public $description;
    public $name;
    public $rate;
    public $estimated_income;
    public $estimated_expenditure;
    public $fiscal_year;
    public $department_id;
    public $project_id;
    public $account_id;
    public $currency_id;
    public $year_name ='Budget';
    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $entry_type = 'Department';
    public $unit_type = 'department';
    public $unit_id = 0;
    public $requestable_type;
    public $requestable_id;
    public $requestable;
    public function mount($type)
    {
        if ($type == 'all') {
            $this->unit_type = 'all';
            $this->unit_id = '0';
        } else {
            if (session()->has('unit_type') && session()->has('unit_id')) {
                $this->unit_id = session('unit_id');
                $this->unit_type = session('unit_type');
                if(session('unit_type') == 'project'){
                    $this->requestable = $requestable = Project::find($this->unit_id);
                    $this->project_id = $requestable->id??null;
                    $this->entry_type = 'Project';
                }else{
                    $this->requestable = $requestable = Department::find($this->unit_id);
                    $this->department_id = $requestable->id??null;
                    $this->entry_type = 'Department';
                }
            } else {
                $this->unit_id = auth()->user()->employee->department_id ?? 0;
                $this->unit_type = 'department';
                $this->requestable = $requestable = Department::find($this->unit_id);
                $this->department_id = $this->unit_id;
                $this->entry_type = 'Department';
            }
            if ($requestable) {
                $this->requestable_type = get_class($requestable);
                $this->requestable_id = $this->unit_id;
            }else{
                abort(403, 'Unauthorized access or action.'); 
            }
        }
    }

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
        $this->createNew = false;
        $this->updatedDepartmentId();
        $this-> updatedProjectId();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedDepartmentId()
    {
        $department = Department::where('id', $this->department_id)->first();
        if($department && $department->name){
            
            $this->name = $department->name.' '.$this->year_name;
            }
    }

    public function updatedProjectId()
    {
        $department = Project::where('id', $this->project_id)->first();
        if($department && $department->name){
            
        $this->name = $department->name.' '.$this->year_name;
        }
    }

    public function updatedFiscalYear()
    {
        $record = FmsFinancialYear::where('id', $this->fiscal_year)->first();
        if($record && $record->name){
            
        $this->year_name = 'Budget '.$record->name;
        // $this->project_id = '';
        // $this->department_id = '';
        $this->name = '';
        }
        $this->updatedDepartmentId();
        $this-> updatedProjectId();
    }

    public function updatedEntryType()
    {
        $this->project_id = '';
        $this->department_id = '';
        $this->name = '';
        $this->year_name = 'Budget';
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'is_active' => 'required|integer',
            // 'estimated_income' =>'required|numeric',
            // 'estimated_expenditure' =>'required|numeric',
            'fiscal_year' =>'required|integer',
            'department_id' =>'required|integer',
            'project_id' =>'required|integer',
            'account_id' =>'nullable|integer',
            'description' =>'nullable|string',
            'currency_id' =>'required|integer',
        ]);
    }
    public function updatedCurrencyId()
    {
        if ($this->currency_id) {
            $latestRate = FmsCurrencyUpdate::where('currency_id', $this->currency_id)->latest()->first();

            if ($latestRate) {
                $this->rate = $latestRate->exchange_rate;
            }
        }
    }

    public function storeBudget()
    {
        $this->validate([
            'name' => 'required|string|unique:fms_budgets',
            'is_active' => 'required|integer',
            'rate' =>'required|numeric',
            // 'estimated_expenditure' =>'required|numeric',
            'fiscal_year' =>'required|integer',
            'department_id' =>'nullable|integer',
            'project_id' =>'nullable|integer',
            'currency_id' =>'required|integer',
            'account_id' =>'nullable|integer',
            'description' =>'nullable|string',

        ]);

        $record = null;
        $requestable = null;
        if ($this->entry_type == 'Project'){
            $this->validate([               
                'project_id' => 'required|integer',    
            ]);
            $this->department_id = null;
            $requestable =  Project::find($this->project_id);
            $record = FmsBudget::where(['project_id' => $this->project_id, 'fiscal_year' => $this->fiscal_year])->first();
        }elseif($this->entry_type == 'Department'){
            $this->validate([               
                'department_id' => 'required|integer',    
            ]);
            $this->project_id = null;
            $requestable =  Department::find($this->department_id);
            $record = FmsBudget::where(['department_id' =>$this->department_id, 'fiscal_year' => $this->fiscal_year])->first();
        }

        if($record){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Duplicate data!',
                'text' => 'the selected unit has a budget for this selected '.$this->fiscal_year.' fiscal Year!',
            ]);
            return false;
        }

        $budget = new FmsBudget();
        $budget->name = $this->name;        
        $budget->code = GeneratorService::budgetIdentifier();
        $budget->is_active = $this->is_active;
        $budget->description = $this->description;
        $budget->rate = $this->rate;
        // $budget->estimated_expenditure = $this->estimated_expenditure;
        $budget->fiscal_year = $this->fiscal_year;
        $budget->department_id = $this->department_id;
        $budget->project_id = $this->project_id;
        $budget->currency_id = $this->currency_id;
        $budget->account_id = $this->account_id;
        $budget->requestable()->associate($requestable);
        $budget->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'budget created successfully!']);
        return redirect()->SignedRoute('finance-budget_lines', $budget->code);
    }

    public function editData(FmsBudget $budget)
    {
        $this->edit_id = $budget->id;
        $this->name = $budget->name;
        $this->is_active = $budget->is_active;
        $this->description = $budget->description;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset([
            'name',
            'estimated_income',
            'estimated_expenditure',
            'fiscal_year',
            // 'department_id',
            // 'project_id',
            'account_id',
            'description',
            'is_active',
            'edit_id']);
    }

    public function updateBudget()
    {
        $this->validate([
            'name' => 'required|unique:fms_budgets,name,' . $this->edit_id . '',
            'is_active' => 'required|numeric',
            'estimated_income' =>'required|numeric',
            'estimated_expenditure' =>'required|numeric',
            'fiscal_year' =>'required|integer',
            'department_id' =>'required|integer',
            'project_id' =>'required|integer',
            'account_id' =>'nullable|integer',
            'currency_id' =>'required|integer',
            'description' =>'nullable|string',
        ]);

        $budget = FmsBudget::find($this->edit_id);
        $budget->name = $this->name;
        $budget->is_active = $this->is_active;
        $budget->description = $this->description;
        $budget->estimated_income = $this->estimated_income;
        $budget->estimated_expenditure = $this->estimated_expenditure;
        $budget->fiscal_year = $this->fiscal_year;
        $budget->department_id = $this->department_id;
        $budget->currency_id = $this->currency_id;
        $budget->project_id = $this->project_id;
        $budget->account_id = $this->account_id;
        $budget->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'budget updated successfully!']);
        return redirect()->SignedRoute('finance-budget_lines', $budget->code);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->budgetIds) > 0) {
            // return (new budgetsExport($this->budgetIds))->download('budgets_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No budgets selected for export!',
            ]);
        }
    }

    public function mainQuery()
    {
        $budgets = FmsBudget::search($this->search)->when($this->requestable_id && $this->requestable_type, function ($query) {
            $query->where(['requestable_id'=> $this->requestable_id,'requestable_type' => $this->requestable_type]);
        })
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->budgetIds = $budgets->pluck('id')->toArray();

        return $budgets;
    }

    public function render()
    {
        $data['budgets'] = $this->mainQuery()->with(['project', 'department','currency','fiscalYear'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['departments'] = Department::all();
        $data['projects'] = Project::all();
        $data['years'] = FmsFinancialYear::all();
        $data['currencies'] = FmsCurrency::all();
        return view('livewire.finance.budget.fms-budgets-component', $data);
    }
}
