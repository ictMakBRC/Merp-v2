<?php

namespace App\Http\Livewire\Finance\Invoice;

use Livewire\Component;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\Auth;
use App\Models\Grants\Project\Project;
use App\Models\Finance\Banking\FmsBank;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCustomer;
use App\Models\Procurement\Settings\Provider;
use App\Models\HumanResource\Settings\Department;
use App\Models\Finance\Settings\FmsCurrencyUpdate;

class FmsInvoiceListsComponent extends Component
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
    public $rate;
    public $bank_id;
    public $entry_type = 'Department';
    public $invoice_to;
    public $reminder_sent_at;
    public $supplier_id;
    public $billed_by;
    public $billed_to;
    public $unit_type ='department';
    public $unit_id=0;
    public $type ='all';
    public function mount(){
        if(Auth::user()->hasPermission(['view_all_invoices'])){
            if (session()->has('unit_type') && session()->has('unit_id')) {
                $this->unit_id = session('unit_id');
                $this->unit_type = session('unit_type');
            }else{
                $this->unit_type = 'all';
            }
        }else{
            abort(403, 'No permission to access this page');
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

    public function validateInputs()
    {
        return [
            'invoice_date' => 'required|date',
            'entry_type' => 'required',
            'invoice_to' => 'required',
            'department_id' => 'nullable',
            'project_id' => 'nullable',
            'customer_id' => 'nullable',
            'currency_id' => 'required',
            'tax_id' => 'nullable',
            'terms_id' => 'nullable',
            'description' => 'required',
            'due_date' => 'required|date',
            'recurring' => 'required|numeric',
            'rate'=> 'required|numeric',
            'bank_id' => 'nullable|numeric',
            'cancel_overdue_reminders' => 'required|numeric',
            'cycles' => 'nullable|numeric',
            // 'recurring_from'=> 'nullable',
            // 'recurring_to'=> 'nullable',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, $this->validateInputs());
    }
    public function updatedCurrencyId()
    {
        if ($this->currency_id) {
            $latestRate = FmsCurrencyUpdate::where('currency_id', $this->currency_id)->latest()->first();

            if ($latestRate) {
                $this->rate = $latestRate->exchange_rate;
            }else{
                $rate = FmsCurrency::where('id', $this->currency_id)->first();
                $this->rate = $rate?->exchange_rate??0;
            }
        }
    }

    function updatedCustomerId() {
      $this->currency_id =  $customer = FmsCustomer::where('id', $this->customer_id)->first()->currency_id;
    }

    public function storeInvoice()
    {
        $this->validate($this->validateInputs());
        $requestable = null;
        $billtable = null;
        $invoice_type = 'Internal';
        if ($this->entry_type == 'Project') {
            $this->validate([
                'project_id' => 'required|integer',
            ]);
            $requestable  = Project::find($this->project_id);
            $this->department_id = null;
            $invoice_type = 'Internal';
        } elseif ($this->entry_type == 'Department') {
            $this->validate([
                'department_id' => 'required|integer',
            ]);
            $this->project_id = null;
            $invoice_type = 'Internal';
            $requestable  = Department::find($this->department_id);
        }elseif ($this->entry_type == 'Supplier') {
        $this->validate([
            'supplier_id' => 'required|integer',
        ]);
        $this->project_id = null;
        $this->department_id = null;
        $invoice_type = 'Incoming';
        $requestable  = Provider::find($this->supplier_id);
    }

        if ($this->invoice_to == 'Customer') {
            $this->validate([
            'bank_id' => 'required|numeric',
            'customer_id' => 'required|integer',
            ]);
            
            $invoice_type = 'Outgoing';
            $this->billed_department = null;
            $this->billed_project = null;
            $billtable  = FmsCustomer::find($this->customer_id);
        }elseif ($this->invoice_to == 'Project') {
                $this->validate([
                    'billed_project' => 'required|integer',
                ]);                
                $this->billed_department = null;                
                $this->customer_id = null;                
                $billtable  = Project::find($this->billed_project);
                if ($this->project_id == $this->billed_project) {
                    $this->dispatchBrowserEvent('swal:modal', [
                        'type' => 'warning',
                        'message' => 'Oops! be serious!',
                        'text' => 'The billing project can not be the same as the paying project!',
                    ]);
                    return false;
                }
        } elseif ($this->invoice_to == 'Department') {
                $this->validate([
                    'billed_department' => 'required|integer',
                ]);
                $this->billed_project = null;              
                $this->customer_id = null;  
                $billtable  = Department::find($this->billed_department);
                if ($this->department_id == $this->billed_department) {
                    $this->dispatchBrowserEvent('swal:modal', [
                        'type' => 'warning',
                        'message' => 'Oops! be serious!',
                        'text' => 'The billing department can not be the same as the paying department!',
                    ]);
                    return false;
                } 
            }

        $invoice = new FmsInvoice();
        $invoice->invoice_type = $invoice_type;
        $invoice->invoice_no = GeneratorService::getInvNumber();
        $invoice->invoice_date = $this->invoice_date;
        $invoice->billed_to = $this->invoice_to;
        $invoice->billed_by = $this->entry_type;
        $invoice->billed_department = $this->billed_department??null;
        $invoice->billed_project = $this->billed_project??null;
        $invoice->department_id = $this->department_id;
        $invoice->project_id = $this->project_id;
        $invoice->customer_id = $this->customer_id;
        $invoice->rate = $this->rate;
        $invoice->bank_id = $this->bank_id;
        $invoice->currency_id = $this->currency_id;
        $invoice->tax_id = $this->tax_id;
        $invoice->terms_id = $this->terms_id;
        $invoice->description = $this->description;
        $invoice->due_date = $this->due_date;
        $invoice->recurring = $this->recurring;
        // $invoice->custom_recurring = $this->custom_recurring;
        // $invoice->recurring_type = $this->recurring_type;
        $invoice->cycles = $this->cycles;
        $invoice->cancel_overdue_reminders = $this->cancel_overdue_reminders;        
        $invoice->requestable()->associate($requestable);
        $invoice->billtable()->associate($billtable);
        $invoice->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice created successfully!']);

        return redirect()->SignedRoute('finance-invoice_items', $invoice->invoice_no);
    }

    public function editData(FmsInvoice $invoice)
    {
        $this->edit_id = $invoice->id;
        $this->invoice_date = $invoice->invoice_date;
        $this->total_amount = $invoice->total_amount;
        $this->total_paid = $invoice->total_paid;
        $this->invoice_from = $invoice->invoice_from;
        $this->department_id = $invoice->department_id;
        $this->invoice_no = $invoice->invoice_no;
        $this->rate = $invoice->rate;
        $this->bank_id = $invoice->bank_id;
        $this->project_id = $invoice->project_id;
        $this->customer_id = $invoice->customer_id;
        $this->currency_id = $invoice->currency_id;
        $this->tax_id = $invoice->tax_id;
        $this->terms_id = $invoice->terms_id;
        $this->description = $invoice->description;
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
        $invoice->rate = $this->rate;
        $invoice->bank_id = $this->bank_id;
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
        $invoices = FmsInvoice::search($this->search)
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
        $data['invoices'] = $this->filterInvoices()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['invoice_counts'] = $this->filterInvoices()->get();
        $data['customers'] = FmsCustomer::where('is_active', 1)->get();
        $data['currencies'] = FmsCurrency::where('is_active', 1)->get();
        $data['banks'] = FmsBank::where('is_active', 1)->get();
        $data['suppliers'] = Provider::where('is_active', true)->get();
        $data['departments'] = Department::where('is_active', 1)->get();
        $data['projects'] = Project::all();
        return view('livewire.finance.invoice.fms-invoice-lists-component', $data);
    }
}
