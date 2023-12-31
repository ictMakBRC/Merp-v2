<?php

namespace App\Http\Livewire\Procurement\Requests\ContractsManager;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Procurement\Request\ProcurementRequest;

class ContractsManagerPanelComponent extends Component
{
    use WithPagination;

    public $from_date;

    public $to_date;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $filter = false;

    public $procurementRequestIds =[];
    
    public function filterProcurementRequests()
    {
        $procurementRequests = ProcurementRequest::search($this->search)
        ->where('step_order','>=',7)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->procurementRequestIds = $procurementRequests->pluck('id')->toArray();

        return $procurementRequests;
    }

    public function render()
    {
        $data['procurementRequests'] = $this->filterProcurementRequests()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.procurement.requests.contracts-manager.contracts-manager-panel-component',$data);
    }
}
