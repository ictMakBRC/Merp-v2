<?php

namespace App\Http\Livewire\Finance\Budget;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Budget\FmsUnitBudgetLine;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Accounting\FmsChartOfAccount;

class FmsDepartmentBudgetLinesComponent extends Component
{

        use WithPagination;
            
            //Filters
            public $from_date;
        
            public $to_date;
        
            public $lineIds;
        
            public $perPage = 10;
        
            public $search = '';
        
            public $orderBy = 'id';
        
            public $orderAsc = 0;
        
            public $name;
        
            public $is_active =1;
        
            public $description;
        
            public $account_id;
            public $type;
        
            public $delete_id;
        
            public $edit_id;
        
            protected $paginationTheme = 'bootstrap';
        
            public $createNew = false;
        
            public $toggleForm = false;
        
            public $filter = false;

            public $requestable_type = null;
            public $requestable = null;
            public $department_id;
            public $project_id;

            public $unitId;

            function mount($id, $type) {                
                $this->unitId = $id;
                if($type == 'department'){
                    $this->department_id =$id;
                    $this->requestable_type =  'App\Models\HumanResource\Settings\Department';
                    $this->requestable =  Department::find($id);
                }elseif($type == 'project'){
                    $this->project_id = $id;
                    $this->requestable_type  = 'App\Models\Grants\Project\Project';
                    $this->requestable =  Project::find($id);
                }

            }
        
            public function updatedCreateNew()
            {
                $this->resetInputs();
                $this->toggleForm = false;
            }
        
            public function updatingSearch()
            {
                $this->resetPage();
            }
        
            public function updated($fields)
            {
                $this->validateOnly($fields, [
                    'name' => 'required|string',
                    'type' => 'required|string',
                    'is_active' => 'required|integer',
                    'account_id' => 'required|integer',
                    // 'description' => 'nullable|string',
                ]);
            }
        
            public function saveBudgetLine($id)
            {
                $this->validate([
                    'name' => 'required',
                    'type' => 'required',
                    // 'description' => 'nullable|string',
                ]);
                $budgetName = $this->name[$id];
                $description = $this->description[$id];
        
                $line = new FmsUnitBudgetLine();
                $line->account_id = $id;
                $line->name = $budgetName;
                $line->is_active = 1;
                $line->description = $description;
                $line->department_id = $this->department_id;
                $line->project_id = $this->project_id;
                $line->type = $this->type;
                $line->requestable()->associate($this->requestable);
                $line->save();
                $this->dispatchBrowserEvent('close-modal');
                $this->resetInputs();
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'line created successfully!']);
            }
        
            public function editData(FmsUnitBudgetLine $line)
            {
                $this->account_id = $line->account_id;
                $this->edit_id = $line->id;
                $this->name = $line->name;
                $this->account_id = $line->account_id;
                $this->type = $line->type;
                $this->is_active = $line->is_active;
                $this->description = $line->description;
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
                $this->reset(['name', 'is_active', 'description']);
            }
        
            public function updateInvline()
            {
                $this->validate([
                    'name' => 'required|string',
                    'description' => 'nullable|string',
                    'is_active' => 'required|integer',
                ]);
        
                $line = FmsUnitBudgetLine::find($this->edit_id);
                $line->name = $this->name;
                $line->description = $this->description;
                $line->is_active = $this->is_active;
                $line->update();
        
                $this->resetInputs();
                $this->createNew = false;
                $this->toggleForm = false;
                $this->dispatchBrowserEvent('close-modal');
                $this->resetInputs();
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'line updated successfully!']);
            }
        
            public function refresh()
            {
                return redirect(request()->header('Referer'));
            }
        
            public function export()
            {
                if (count($this->lineIds) > 0) {
                    // return (new linesExport($this->lineIds))->download('lines_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
                } else {
                    $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                        'type' => 'warning',
                        'message' => 'Oops! Not Found!',
                        'text' => 'No lines selected for export!',
                    ]);
                }
            }
        
            public function filterCategories()
            {
                $lines = FmsUnitBudgetLine::search($this->search)->where('requestable_id', $this->unitId)
                ->where('requestable_type', $this->requestable_type)
                    ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                        $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
                    }, function ($query) {
                        return $query;
                    });
        
                $this->lineIds = $lines->pluck('id')->toArray();
        
                return $lines;
            }
        
            public function render()
            {
                $data['budget_lines'] = $this->filterCategories()
                    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
                    $data['incomes'] = FmsChartOfAccount::where('account_type', 4)->with(['type'])->where(['is_active'=> 1, 'is_budget'=>1])->get();
                    $data['expenses'] = FmsChartOfAccount::where(['is_active'=> 1, 'is_budget'=>1])->with(['type'])->where('account_type', 3)->get();
                    return view('livewire.finance.budget.fms-department-budget-lines-component', $data);
            }
    }
    
