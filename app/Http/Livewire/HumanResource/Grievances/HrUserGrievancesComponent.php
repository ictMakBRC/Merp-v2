<?php

namespace App\Http\Livewire\HumanResource\Grievances;

use App\Models\HumanResource\Grievance;
use App\Models\HumanResource\GrievanceType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class HrUserGrievancesComponent extends Component
{
    use WithFileUploads, WithPagination;
    //Filters
    public $from_date;

    public $to_date;

    public $grievanceIds;

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

    public $comment;
    public $g_comment;
    public $file_upload;
    public $employee_id;
    public $grievance_type_id;
    public $subject;
    public $department_id;
    public $addressee;
    public $acknowledged_by_comment;

    public function mount()
    {
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

    public function updatedGrievanceTypeId()
    {
        $record = GrievanceType::where('id', $this->grievance_type_id)->first();
        if ($record) {

            $this->g_comment = $record?->name . ' ' . $record?->comment;
        }
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'file_upload' => 'required|string',
            'employee_id' => 'required|numeric',
            'grievance_type_id' => 'required|numeric',
            'department_id' => 'required|integer',
            'subject' => 'required|string',
            'addressee' => 'required|string',
            'comment' => 'nullable|string',
        ]);
    }

    public function storeData()
    {
        $this->validate([
            'file_upload' => 'nullable|mimes:jpg,png,pdf|max:10240|file|min:1',
            'employee_id' => 'required|numeric',
            'grievance_type_id' => 'required|numeric',
            'subject' => 'required|string',
            'addressee' => 'required|string',
            'comment' => 'nullable|string',
        ]);
        $grievance = new Grievance();
        $grievance->comment = $this->comment;
        $grievance->employee_id = $this->employee_id;
        $grievance->grievance_type_id = $this->grievance_type_id;
        $grievance->subject = $this->subject;
        $grievance->department_id = $this->department_id;
        $grievance->addressee = $this->addressee;
        $grievance->save();        
        if ($this->file_upload) {
            $grievance->addMedia($this->file_upload)->toMediaCollection();
        } 
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'budget created successfully!']);
    }

    public function editData(Grievance $grievance)
    {
        $this->edit_id = $grievance->id;
        $this->subject = $grievance->subject;
        $this->comment = $grievance->comment;
        $this->grievance_type_id = $grievance->grievance_type_id;
        $this->addressee = $grievance->addressee;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function showGrievance(Grievance $grievance)
    {
        
        $this->acknowledged_by_comment = $grievance->acknowledged_by_comment;
        $this->subject = $grievance->subject;
        $this->comment = $grievance->comment;
        $this->grievance_type_id = $grievance->grievance_type_id;
        $this->addressee = $grievance->addressee;
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
            'grievance_type_id',
            'subject',
            'addressee',
            'comment',
            'g_comment',
            'edit_id']);
    }

    public function submitGrievance($id){
        $grievance = Grievance::find($id);
        $grievance->status = 'Submitted';
        $grievance->update();
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
            'grievance_type_id' => 'required|numeric',
            'subject' => 'required|string',
            'addressee' => 'required|string',
            'comment' => 'nullable|string',
        ]);

        $grievance = Grievance::find($this->edit_id);
        $grievance->comment = $this->comment;
        // $grievance->employee_id = $this->employee_id;
        $grievance->grievance_type_id = $this->grievance_type_id;
        $grievance->subject = $this->subject;
        // $grievance->department_id = $this->department_id;
        $grievance->addressee = $this->addressee;
        $grievance->update();

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
        $grievances = Grievance::search($this->search)->where('created_by', auth()->user()->id)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->exportIds = $grievances->pluck('id')->toArray();

        return $grievances;
    }

    public function render()
    {
        $data['grievances'] = $this->mainQuery()->with(['employee', 'comments','department','type','acknowledgedBy'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['types'] = GrievanceType::all();

        return view('livewire.human-resource.grievances.hr-user-grievances-component', $data);
    }
}
