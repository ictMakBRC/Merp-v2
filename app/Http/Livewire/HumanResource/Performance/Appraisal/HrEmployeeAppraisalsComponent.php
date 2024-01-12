<?php

namespace App\Http\Livewire\HumanResource\Performance\Appraisal;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\Performance\Appraisal\HrEmployeeAppraisal;

class HrEmployeeAppraisalsComponent extends Component
{
    use WithFileUploads, WithPagination;
    //Filters
    public $from_date;

    public $to_date;

    public $appraisalIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;
    public $exportIds;
    public $is_active = 1;
    protected $paginationTheme = 'bootstrap';

    public $edit_id;

    public $delete_id;
    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $file_upload;
    public $employee_id;
    public $department_id;
    public $app_from_date;
    public $app_to_date;
    public $comment;
    public $consent;
    public $show = 'personal';

    public function mount($type)
    {
        $this->show = $type;
        $this->employee_id = auth()->user()->employee_id;
        $this->department_id = auth()->user()->employee?->department_id;
    }

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
        $this->createNew = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'file_upload' => 'nullable|mimes:jpg,png,pdf|max:10240|file|min:1',
            'employee_id' => 'required|numeric',
            'department_id' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'comment' => 'required|string',
        ]);
    }

    public function updatedEmployeeId()
    {
        $data = Employee::where('id', $this->employee_id)->first(); 
        $this->department_id = $data?->department_id;
    }


    public function storeData()
    {
        
       $data = Employee::where('id', $this->employee_id)->first(); 
       $this->department_id = $data?->department_id;
        // dd($this->department_id );
        $this->validate([
            'file_upload' => 'nullable|mimes:jpg,png,pdf|max:10240|file|min:1',
            'employee_id' => 'required|numeric',
            'department_id' => 'required|numeric', 
            'app_from_date' => 'required|date',
            'app_to_date' => 'required|date',
            'comment' => 'required|string',
        ]);
        $appraisal = new HrEmployeeAppraisal();
        $appraisal->employee_id = $this->employee_id;
        $appraisal->department_id = $this->department_id;
        $appraisal->from_date = $this->app_from_date;        
        $appraisal->to_date = $this->app_to_date;
        $appraisal->comment = $this->comment;
        $appraisal->save();        
        if ($this->file_upload) {
            $appraisal->addMedia($this->file_upload)->toMediaCollection();
        } 
        $this->dispatchBrowserEvent('close-modal');
        $this->close();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'appraisal created successfully!']);
    }

    public function editData(HrEmployeeAppraisal $appraisal)
    {
        $this->edit_id = $appraisal->id;
        $this->from_date = $appraisal->app_from_date;
        $this->to_date = $appraisal->app_to_date;
        $this->department_id = $appraisal->department_id;
        $this->comment = $appraisal->comment;
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
            'file_upload',
            'department_id',
            'app_from_date',
            'app_to_date',
            'comment',
            'edit_id',
        'employee_id'
    ]);
    }

    public function submitappraisal($id){
        $appraisal = HrEmployeeAppraisal::find($id);
        $appraisal->status = 'Submitted';
        $appraisal->update();
        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record submitted successfully!']);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
    }

    public function updateData()
    {
     
        $this->validate([
            'file_upload' => 'nullable|mimes:jpg,png,pdf|max:10240|file|min:1',
            // 'employee_id' => 'required|numeric',
            'app_from_date' => 'required|date',
            'app_to_date' => 'required|date',
            'comment' => 'required|string',
        ]);
        $appraisal = HrEmployeeAppraisal::find($this->edit_id);
        $appraisal->comment = $this->comment;
        // $appraisal->employee_id = $this->employee_id;
        $appraisal->department_id = $this->department_id;
        $appraisal->to_date = $this->app_to_date;
        $appraisal->from_date = $this->app_from_date;
        // $appraisal->department_id = $this->department_id;
        $appraisal->comment = $this->comment;
        $appraisal->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->exportIds) > 0) {
            // return (new budgetsExport($this->exportIds))->download('budgets_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'appraisal',
                'message' => 'Oops! Not Found!',
                'text' => 'No budgets selected for export!',
            ]);
        }
    }

    public function mainQuery()
    {
        $appraisals = HrEmployeeAppraisal::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            })->when($this->show != 'all' , function ($query) {
                $query->where('employee_id', auth()->user()->employee_id);
            }, function ($query) {
                return $query;
            });

        $this->exportIds = $appraisals->pluck('id')->toArray();

        return $appraisals;
    }

    public function render()
    {
        $data['appraisals'] = $this->mainQuery()->with(['employee', 'comments','createdBy'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['employees'] = Employee::all();
   
        return view('livewire.human-resource.performance.appraisal.hr-employee-appraisals-component', $data);
    }
}
