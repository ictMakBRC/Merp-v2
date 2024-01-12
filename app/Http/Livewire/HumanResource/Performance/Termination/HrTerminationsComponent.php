<?php

namespace App\Http\Livewire\HumanResource\Performance\Termination;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\Performance\Termination\HrEmployeeTermination;

class HrTerminationsComponent extends Component
{
    use WithFileUploads, WithPagination;
    //Filters
    public $from_date;

    public $to_date;

    public $warningIds;

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
    public $reason;
    public $subject;
    public $letter;
    public $department_id;
    public $show = 'personal';

    public function mount($type)
    {
        $this->show = $type;
        $this->employee_id = auth()->user()->employee_id;
        $this->department_id = auth()->user()->employee?->department_id;
        if (!auth()->user()->hasPermission(['create_termination']) && $type =='all') {
            $this->show = 'personal';
        }
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
        $this->dispatchBrowserEvent('initializeEditor');
        $this->validateOnly($fields, [
            'file_upload' => 'nullable|mimes:jpg,png,pdf|max:10240|file|min:1',
            'employee_id' => 'required|numeric',
            'reason' => 'required',
            'subject' => 'required|string',
            'letter' => 'required|string',
        ]);
    }

    public function storeData()
    {
        $this->validate([
            'file_upload' => 'nullable|mimes:jpg,png,pdf|max:10240|file|min:1',
            'employee_id' => 'required|numeric',
            'reason' => 'required|string',
            'subject' => 'required|string',
            'letter' => 'required|string',
        ]);
        $warning = new HrEmployeeTermination();
        $warning->employee_id = $this->employee_id;
        $warning->reason = $this->reason;
        $warning->subject = $this->subject;
        $warning->letter = $this->letter;
        // dd($warning);
        $warning->save();        
        if ($this->file_upload) {
            $warning->addMedia($this->file_upload)->toMediaCollection();
        } 
        $this->dispatchBrowserEvent('close-modal');
        $this->close();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Warning created successfully!']);
    }

    public function editData(HrEmployeeTermination $warning)
    {
        $this->edit_id = $warning->id;
        $this->subject = $warning->subject;
        $this->reason = $warning->reason;
        $this->letter = $warning->letter;
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
            'reason',
            'subject',
            'letter',
            'edit_id',
        'employee_id'
    ]);
    }

    public function submitwarning($id){
        $warning = HrEmployeeTermination::find($id);
        $warning->status = 'Submitted';
        $warning->update();
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
            'is_active' => 'required|numeric',
            'employee_id' => 'required|numeric',
            'reason' => 'required|numeric',
            'subject' => 'required|string',
            'letter' => 'required|string',
            'comment' => 'nullable|string',
        ]);

        $warning = HrEmployeeTermination::find($this->edit_id);
        $warning->comment = $this->comment;
        // $warning->employee_id = $this->employee_id;
        $warning->reason = $this->reason;
        $warning->subject = $this->subject;
        // $warning->department_id = $this->department_id;
        $warning->letter = $this->letter;
        $warning->update();

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
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No budgets selected for export!',
            ]);
        }
    }

    public function mainQuery()
    {
        $warnings = HrEmployeeTermination::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            })->when($this->show != 'all' , function ($query) {
                $query->where('employee_id', auth()->user()->employee_id);
            }, function ($query) {
                return $query;
            });

        $this->exportIds = $warnings->pluck('id')->toArray();

        return $warnings;
    }

    public function render()
    {
        $data['terminations'] = $this->mainQuery()->with(['employee','createdBy'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['employees'] = Employee::all();
        return view('livewire.human-resource.performance.termination.hr-terminations-component', $data);
    }
}
