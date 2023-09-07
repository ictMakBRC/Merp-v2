<?php

namespace App\Http\Livewire\Inventory\Manage;

use Livewire\Component;
use App\Models\inventory\invRequest;
use App\Models\inventory\invRequestitem;

class RequestApprovalComponent extends Component
{
    public $code;
    public function mount($request_code)
    {
        $this->code = $request_code;
    }
    public function render()
    {
        $data['requestDetails']=  invRequest::with('requester','approver','department','borrower')->where(['request_code'=> $this->code])->first();
        $data['requestItems']=invRequestitem::with('item','item.parentUom','item.subUnit','stockCards')->where('request_code', $this->code)->get();

        return view('livewire.inventory.manage.request-approval-component',$data)->layout('inventdashboard.layouts.app');
    }
}
