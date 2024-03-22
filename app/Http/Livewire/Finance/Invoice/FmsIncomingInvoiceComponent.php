<?php

namespace App\Http\Livewire\Finance\Invoice;

use Livewire\Component;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\HumanResource\Settings\Department;

class FmsIncomingInvoiceComponent extends Component
{
    public $from_date;

    public $to_date;

    public $invoiceIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $invoice_no;

    public $billed_project;
    public $billed_department;
    public $invoice_date;
    public $total_amount;
    public $total_paid;
    public $invoice_from;
    public $department_id;
    public $project_id;
    public $customer_id;
    public $currency_id;
    public $tax_id;
    public $terms_id;
    public $description;
    public $created_by;
    public $updated_by;
    public $adjustment = 0;
    public $discount_type = 'Percent';
    public $discount = 0;
    public $discount_total = 0;
    public $discount_percent = 0;
    public $due_date;
    public $recurring;
    public $custom_recurring;
    public $recurring_type;
    public $cycles = 0;
    public $total_cycles;
    public $recurring_from;
    public $recurring_to;
    public $last_due_reminder;
    public $last_overdue_reminder;
    public $cancel_overdue_reminders = 0;
    public $status;
    public $entry_type = 'Department';
    public $invoice_to = 'Customer';
    public $reminder_sent_at;

    public $billed_by;
    public $billed_to;
    public $unit_type ='department';
    public $unit_id=0;
    public $requestable;
    public $requestable_type;
    public $requestable_id;
    public function mount(){
       
            if (session()->has('unit_type') && session()->has('unit_id') && session('unit_type') == 'project') {
                $this->unit_id = session('unit_id');
                $this->unit_type = session('unit_type');
                $this->requestable = $requestable = Project::find($this->unit_id);
                $this->project_id = $requestable->id??null;
                $this->entry_type = 'Project';
            } else {
                $this->unit_id = auth()->user()->employee->department_id ?? 0;
                $this->unit_type = 'department';
                $this->entry_type = 'Department';
                $this->requestable = $requestable = Department::find($this->unit_id);
                $this->department_id = $requestable->id??null;
            }
            if ($requestable) {
                $this->requestable_type = get_class($requestable);
                $this->requestable_id = $this->unit_id;
            }else{
                abort(403, 'Unauthorized access or action.'); 
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
        $this->validateOnly($fields, $this->validateInputs());
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
            'invoice_no',
            'invoice_date',
            'total_amount',
            'total_paid',
            'invoice_from',
            'department_id',
            'project_id',
            'customer_id',
            'currency_id',
            'tax_id',
            'terms_id',
            'description',
            'created_by',
            'updated_by',
            'status',
            'reminder_sent_at',
            'edit_id',
            'adjustment',
            'discount_type',
            'discount',
            'discount_total',
            'discount_percent',
            'due_date',
            'recurring',
            'custom_recurring',
            'recurring_type',
            'cycles',
            'total_cycles',
            'recurring_from',
            'recurring_to',
            'last_due_reminder',
            'last_overdue_reminder',
            'cancel_overdue_reminders',
        ]);
    }

    public function updateInvoice()
    {
        $this->validate($this->validateCustomer());

        $invoice = FmsInvoice::find($this->edit_id);
        $invoice->invoice_date = $this->invoice_date;
        $invoice->total_amount = $this->total_amount;
        $invoice->total_paid = $this->total_paid;
        $invoice->invoice_from = $this->invoice_from;
        $invoice->department_id = $this->department_id;
        $invoice->project_id = $this->project_id;
        $invoice->customer_id = $this->customer_id;
        $invoice->currency_id = $this->currency_id;
        $invoice->tax_id = $this->tax_id;
        $invoice->terms_id = $this->terms_id;
        $invoice->description = $this->description;
        $invoice->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'customer updated successfully!']);

    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->customerIds) > 0) {
            // return (new invoicesExport($this->customerIds))->download('invoices_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No invoices selected for export!',
            ]);
        }
    }

    public function filterInvoices()
    {
        $invoices = FmsInvoice::search($this->search)->where(['billtable_id'=> $this->requestable_id,'billtable_type' => $this->requestable_type])->where('status','!=','Pending')
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->invoiceIds = $invoices->pluck('id')->toArray();

        return $invoices;
    }
    public function render()
    {
        $data['invoice_counts'] = $this->filterInvoices()->get();
        $data['invoices'] = $this->filterInvoices()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.finance.invoice.fms-incoming-invoice-component', $data);
    }
}
