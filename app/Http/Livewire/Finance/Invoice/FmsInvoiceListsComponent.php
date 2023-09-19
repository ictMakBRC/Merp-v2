<?php

namespace App\Http\Livewire\Finance\Invoice;

use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCustomer;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Services\GeneratorService;
use Livewire\Component;

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
    public $invoice_type = 'External';
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
    public $status;
    public $entry_type='Department';
    public $reminder_sent_at;

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
            'invoice_date' => 'required',
            'entry_type' => 'required',
            'department_id' => 'nullable',
            'project_id' => 'nullable',
            'customer_id' => 'nullable',
            'currency_id' => 'required',
            'tax_id' => 'nullable',
            'terms_id' => 'nullable',
            'description' => 'required',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, $this->validateInputs());
    }

    public function storeInvoice()
    {
        $this->validate($this->validateInputs());

        if ($this->entry_type == 'Project'){
            $this->validate([               
                'project_id' => 'required|integer',    
            ]);
            $this->department_id = null;
        }elseif($this->entry_type == 'Department'){
            $this->validate([               
                'department_id' => 'required|integer',    
            ]);
            $this->project_id = null;
        }

        if ($this->invoice_type =='External'){
            $this->validate([               
                'billed_project' => 'nullable|integer',    
                'customer_id' => 'required|integer',    
            ]);
            $this->billed_department = null;            
            if($this->project_id == $this->billed_project && $this->billed_project !=null){
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'warning',
                    'message' => 'Oops! invalid data!',
                    'text' => 'The billing project can not be the same as the paying department!',
                ]);
                return false;
            }
        }elseif($this->invoice_type =='Internal'){
            $this->validate([               
                'billed_department' => 'required|integer',    
            ]);
            $this->billed_project = null;
            $this->customer_id = null;
            if($this->department_id == $this->billed_department){
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'warning',
                    'message' => 'Oops! invalid data!',
                    'text' => 'The billing department can not be the same as the paying department!',
                ]);
                return false;
            }
        }

       
        $invoice = new FmsInvoice();
        $invoice->invoice_no = GeneratorService::getInvNumber();
        $invoice->invoice_date = $this->invoice_date;
        $invoice->billed_department = $this->billed_department;
        $invoice->billed_project = $this->billed_project;
        $invoice->department_id = $this->department_id;
        $invoice->project_id = $this->project_id;
        $invoice->customer_id = $this->customer_id;
        $invoice->currency_id = $this->currency_id;
        $invoice->tax_id = $this->tax_id;
        $invoice->terms_id = $this->terms_id;
        $invoice->description = $this->description;
        $invoice->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'customer created successfully!']);
      
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
            'edit_id']);
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
        $data['customers']=FmsCustomer::where('is_active',1)->get();
        $data['currencies']=FmsCurrency::where('is_active',1)->get();
        $data['departments']=Department::where('is_active',1)->get();
        $data['projects']=Project::all();
        return view('livewire.finance.invoice.fms-invoice-lists-component', $data);
    }
}
