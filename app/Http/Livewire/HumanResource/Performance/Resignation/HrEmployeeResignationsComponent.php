<?php

namespace App\Http\Livewire\HumanResource\Performance\Resignation;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\HumanResource\Performance\Resigination\HrEmployeeResignation;

class HrEmployeeResignationsComponent extends Component
{

    use WithFileUploads, WithPagination;
    //Filters
    public $from_date;

    public $to_date;
    public $min_date;

    public $resignationIds;

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
    public $contact;
    public $email;
    public $consent;
    public $subject;
    public $reason;
    public $status;
    public $letter;
    public $created_by;
    public $updated_by;
    public $approved_by;
    public $approved_at;
    public $handover_to;
    public $notice_period;
    public $last_working_day;
    public $department_id;
    public $show = 'personal';

    public function mount($type)
    {
        $this->show = $type;
        $this->employee_id = auth()->user()->employee_id;
        $this->department_id = auth()->user()->employee?->department_id;
        if (!auth()->user()->hasPermission(['create_termination']) && $type == 'all') {
            $this->show = 'personal';
        }
        $this->min_date = Carbon::now()->addDays(30);
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
        $this->employee_id = auth()->user()->employee_id;
        $this->department_id = auth()->user()->employee?->department_id;
        $this->validate([
            // 'file_upload' => 'nullable|mimes:jpg,png,pdf|max:10240|file|min:1',
            'employee_id' => 'required|numeric',
            'contact' => 'required',
            'email' => 'required|email',
            'consent' => 'required',
            'subject' => 'required|string',
            'reason' => 'required|string',
            'letter' => 'required|string',
            'handover_to' => 'required|numeric',
            'notice_period' => 'required',
            'last_working_day' => 'required|date',
            'department_id' => 'required|integer',
        ]);
        $resignation = new HrEmployeeResignation();
        $resignation->employee_id = $this->employee_id;
        $resignation->contact = $this->contact;
        $resignation->email = $this->email;
        $resignation->consent = $this->consent;
        $resignation->subject = $this->subject;
        $resignation->reason = $this->reason;
        $resignation->letter = $this->letter;
        $resignation->handover_to = $this->handover_to;
        $resignation->notice_period = $this->notice_period;
        $resignation->last_working_day = $this->last_working_day;
        $resignation->department_id = $this->department_id;
        // dd($resignation);
        $resignation->save();
        if ($this->file_upload) {
            $resignation->addMedia($this->file_upload)->toMediaCollection();
        }
        $this->dispatchBrowserEvent('close-modal');
        $this->close();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'resignation created successfully!']);
    }

    public function editData(HrEmployeeResignation $resignation)
    {
        $this->edit_id = $resignation->id;
        $this->subject = $resignation->subject;
        $this->reason = $resignation->reason;
        $this->letter = $resignation->letter;
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
            'employee_id',
            'contact',
            'email',
            'consent',
            'subject',
            'reason',
            'status',
            'letter',
            'created_by',
            'updated_by',
            'approved_by',
            'approved_at',
            'handover_to',
            'notice_period',
            'last_working_day',
            'department_id',
        ]);
    }

    public function submitResignation($id)
    {
        $resignation = HrEmployeeResignation::find($id);
        $resignation->status = 'Submitted';
        $resignation->update();
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

        $resignation = HrEmployeeResignation::find($this->edit_id);
        $resignation->comment = $this->comment;
        // $resignation->employee_id = $this->employee_id;
        $resignation->reason = $this->reason;
        $resignation->subject = $this->subject;
        // $resignation->department_id = $this->department_id;
        $resignation->letter = $this->letter;
        $resignation->update();

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
                'type' => 'resignation',
                'message' => 'Oops! Not Found!',
                'text' => 'No budgets selected for export!',
            ]);
        }
    }

    public function mainQuery()
    {
        $resignations = HrEmployeeResignation::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            })->when($this->show != 'all', function ($query) {
            $query->where('employee_id', auth()->user()->employee_id);
        }, function ($query) {
            return $query;
        });

        $this->exportIds = $resignations->pluck('id')->toArray();

        return $resignations;
    }

    public function render()
    {
        $data['resignations'] = $this->mainQuery()->with(['employee', 'createdBy'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['employees'] = Employee::all();
        return view('livewire.human-resource.performance.resignation.hr-employee-resignations-component', $data);
    }
}
