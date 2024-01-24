<?php

namespace App\Http\Livewire\Finance\Settings;

use App\Models\Finance\Settings\FmsFinanceInstitutions;
use Livewire\Component;
use Livewire\WithPagination;

class FmsFinanceInstitutionsComponent extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $institutionIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;
    public $contact;

    public $is_active = 1;

    public $description;

    public $type;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

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
            'contact' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
    }

    public function storeInstitution()
    {
        $this->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'is_active' => 'required|integer',
            'contact' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $institution = new FmsFinanceInstitutions();
        $institution->type = $this->type;
        $institution->name = $this->name;
        $institution->contact = $this->contact;
        $institution->is_active = $this->is_active;
        $institution->description = $this->description;
        $institution->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'FY institution created successfully!']);
    }

    public function editData(FmsFinanceInstitutions $institution)
    {
        $this->type = $institution->type;
        $this->edit_id = $institution->id;
        $this->name = $institution->name;
        $this->contact = $institution->contact;
        $this->is_active = $institution->is_active;
        $this->description = $institution->description;
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

    public function updateInstitution()
    {
        $this->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'is_active' => 'required|integer',
            'contact' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $institution = FmsFinanceInstitutions::find($this->edit_id);
        $institution->name = $this->name;
        $institution->contact = $this->contact;
        $institution->type = $this->type;
        $institution->is_active = $this->is_active;
        $institution->description = $this->description;
        $institution->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'FY institution updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->institutionIds) > 0) {
            // return (new institutionsExport($this->institutionIds))->download('institutions_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No institutions selected for export!',
            ]);
        }
    }

    public function mainQuery()
    {
        $institutions = FmsFinanceInstitutions::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->institutionIds = $institutions->pluck('id')->toArray();

        return $institutions;
    }

    public function render()
    {
        $data['institutions'] = $this->mainQuery()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.finance.settings.fms-finance-institutions-component', $data);
    }
}
