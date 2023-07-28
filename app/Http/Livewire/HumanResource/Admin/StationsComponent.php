<?php

namespace App\Http\Livewire\HumanResource\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Global\Station;

class StationsComponent extends Component
{

    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $stationIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active;

    public $description;

    public $totalMembers;

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
            'is_active' => 'required|string',
            'description' => 'required|string',
        ]);
    }

    public function storeStation()
    {
        $this->validate([
            'name' => 'required|string|unique:Stations',
            'is_active' => 'required|numeric',
            'description' => 'required|string',

        ]);

        $station = new Station();
        $station->name = $this->name;
        $station->is_active = $this->is_active;
        $station->description = $this->description;
        $station->save();
        $this->emit('close-modal');
        $this->resetInputs();
        $this->dispatch('alert', ['type' => 'success',  'message' => 'Station created successfully!']);
    }

    public function editData($id)
    {
        $station = Station::where('id', $id)->first();
        $this->edit_id = $station->id;
        $this->name = $station->name;
        $this->is_active = $station->is_active;
        $this->description = $station->description;
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

    public function updateStation()
    {
        $this->validate([
            'name' => 'required|unique:stations,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $station = Station::find($this->edit_id);
        $station->name = $this->name;
        $station->is_active = $this->is_active;
        $station->description = $this->description;
        $station->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatch('close-modal');
        $this->resetInputs();
        $this->dispatch('alert', ['type' => 'success',  'message' => 'Station updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->stationIds) > 0) {
            // return (new StationsExport($this->stationIds))->download('Stations_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Stations selected for export!',
            ]);
        }
    }

    public function filterStations()
    {
        $stations = Station::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->stationIds = $stations->pluck('id')->toArray();

        return $stations;
    }

    public function render()
    {
        $data['stations'] = $this->filterStations()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.admin.stations-component', $data)->layout('layouts.app');
    }
}
