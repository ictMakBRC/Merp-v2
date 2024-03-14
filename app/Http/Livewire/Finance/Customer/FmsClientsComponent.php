<?php

namespace App\Http\Livewire\Finance\Customer;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Finace\FmsClientsImport;
use App\Models\Finance\Invoice\FmsInvoice;
use App\Models\Finance\Settings\FmsCurrency;
use App\Models\Finance\Settings\FmsCustomer;
use App\Models\Finance\Settings\FmsFinancialYear;

class FmsClientsComponent extends Component
{
    use WithPagination, WithFileUploads;

    //Filters
    public $from_date;

    public $to_date;

    public $customerIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'name';

    public $orderAsc = 0;

    public $delete_id;

    public $edit_id;
    public $type;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;
    public $account_number;
    public $title;
    public $name;
    public $first_name;
    public $other_name;
    public $gender;
    public $nationality;
    public $address;
    public $city;
    public $email;
    public $alt_email;
    public $contact;
    public $fax;
    public $alt_contact;
    public $website;
    public $company_name;
    public $payment_terms;
    public $payment_methods;
    public $opening_balance;
    public $sales_tax_registration;
    public $as_of;
    public $is_active = 1;
    public $created_by;
    public $parent_id;
    public $code;
    public $currency_id;
    public $iteration;
    public $import_file;
    public $active_year;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function mount()
    {
        $this->as_of = date('Y-m-d');
        $this->active_year = $fiscal_year = FmsFinancialYear::where('is_budget_year', 1)->first();
        $this->fiscal_year = $fiscal_year->id;
        $this->max_date =$this->active_year->end_date;
        $this->min_date = $this->active_year->start_date;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function validateCustomer()
    {
        return [
            'account_number' => 'nullable|string',
            'title' => 'nullable|string',
            'currency_id' => 'required|integer',
            'name' => 'required|string',
            'code' => 'nullable|string|max:10',
            'type' => 'required|string',
            'gender' => 'nullable|string',
            'parent_id' => 'nullable|integer',
            'nationality' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'email' => 'nullable|email',
            'alt_email' => 'nullable|string',
            'contact' => 'nullable|string',
            'fax' => 'nullable|string',
            'alt_contact' => 'nullable|string',
            'website' => 'nullable|string',
            'company_name' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'payment_methods' => 'nullable|string',
            'opening_balance' => 'nullable|numeric',
            'sales_tax_registration' => 'nullable',
            'as_of' => 'required|date',
            'is_active' => 'required|integer',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, $this->validateCustomer());
    }

    public function updatedName()
    {
        $this->code = GeneratorService::generateInitials($this->name);
    }

    public function storeCustomer()
    {
        $this->validate($this->validateCustomer());

        $customer = new FmsCustomer();
        $customer->name = $this->name;
        $customer->parent_id = $this->parent_id;
        $customer->currency_id = $this->currency_id;
        $customer->code = $this->code?? GeneratorService::generateInitials($this->name);
        $customer->type = $this->type ?? 'Customer';
        $customer->nationality = $this->nationality;
        $customer->address = $this->address;
        $customer->city = $this->city;
        $customer->email = $this->email;
        $customer->alt_email = $this->alt_email;
        $customer->contact = $this->contact;
        $customer->fax = $this->fax;
        $customer->alt_contact = $this->alt_contact;
        $customer->website = $this->website;
        $customer->company_name = $this->company_name;
        $customer->payment_terms = $this->payment_terms;
        $customer->payment_methods = $this->payment_methods;
        $customer->sales_tax_registration = $this->sales_tax_registration;
        $customer->as_of = $this->as_of;
        $customer->is_active = $this->is_active;
        $customer->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'customer created successfully!']);
    }

    public function editData(FmsCustomer $customer)
    {
        $this->edit_id = $customer->id;
        $this->currency_id = $customer->currency_id;
        $this->name = $customer->name;
        $this->parent_id = $customer->parent_id;
        $this->code = $customer->code;
        $this->type = $customer->type;
        $this->nationality = $customer->nationality;
        $this->address = $customer->address;
        $this->city = $customer->city;
        $this->email = $customer->email;
        $this->alt_email = $customer->alt_email;
        $this->contact = $customer->contact;
        $this->fax = $customer->fax;
        $this->alt_contact = $customer->alt_contact;
        $this->website = $customer->website;
        $this->company_name = $customer->company_name;
        $this->payment_terms = $customer->payment_terms;
        $this->payment_methods = $customer->payment_methods;
        $this->sales_tax_registration = $customer->sales_tax_registration;
        $this->as_of = $customer->as_of;
        $this->is_active = $customer->is_active;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function importData()
    {

        $data = Excel::toArray(new FmsClientsImport(), $this->import_file);

        // Pass the data to the view for preview
        // dd($dagta);
        // log($data);
        $this->validate([
            'import_file' => 'required|mimes:xlsx|max:10240|file|min:2',
        ]);
        try {
            DB::statement('SET foreign_key_checks=1');
            Excel::import(new FmsClientsImport, $this->import_file);
            DB::statement('SET foreign_key_checks=1');
            $this->iteration = rand();
            $this->dispatchBrowserEvent('close-modal');
            session()->forget(['import_batch', 'entry_type', 'pathogen']);

            // Check if there was any import error
            if (session()->has('error')) {
                $errorMessage = session('error');
                $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => 'Import completed with duplicates. Summary of duplicate clients: ' . $errorMessage]);
            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Clients Data imported successfully!']);
            }
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            foreach ($failure->errors() as $err) {
            }
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Something went wrong!',
                'text' => 'Failed to import data.' . $err,
            ]);
        }
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
            'account_number',
            // 'currency_id',
            'title',
            'name',
            'code',
            'parent_id',
            'gender',
            'nationality',
            'address',
            'city',
            'email',
            'alt_email',
            'contact',
            'fax',
            'alt_contact',
            'website',
            'company_name',
            'payment_terms',
            'payment_methods',
            'opening_balance',
            'sales_tax_registration',
            'as_of',
            // 'rate',
            'is_active',
            'created_by',
            'edit_id']);
    }

    public function updateCustomer()
    {
        $this->validate($this->validateCustomer());

        $customer = FmsCustomer::find($this->edit_id);
        $customer->name = $this->name;
        $customer->parent_id = $this->parent_id;
        $customer->code = $this->code;
        $customer->type = $this->type;
        $customer->nationality = $this->nationality;
        $customer->address = $this->address;
        $customer->city = $this->city;
        $customer->currency_id = $this->currency_id;
        $customer->email = $this->email;
        $customer->alt_email = $this->alt_email;
        $customer->contact = $this->contact;
        $customer->fax = $this->fax;
        $customer->alt_contact = $this->alt_contact;
        $customer->website = $this->website;
        $customer->company_name = $this->company_name;
        $customer->payment_terms = $this->payment_terms;
        $customer->payment_methods = $this->payment_methods;
        $customer->sales_tax_registration = $this->sales_tax_registration;
        $customer->as_of = $this->as_of;
        $customer->is_active = $this->is_active;
        $customer->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'customer updated successfully!']);
    }

    public $billed_project;
    public $billed_department;
    public $invoice_date;
    public $total_amount;
    public $total_paid;
    public $invoice_from;
    public $department_id;
    public $project_id;
    public $customer_id;
    public $tax_id;
    public $terms_id;
    public $description = 'Opening Balance';
    public $adjustment = 0;
    public $discount_type = 'Percent';
    public $discount = 0;
    public $discount_total = 0;
    public $discount_percent = 0;
    public $due_date;
    public $recurring = 0;
    public $custom_recurring;
    public $recurring_type;
    public $cycles = 0;
    public $total_cycles;
    public $recurring_from;
    public $recurring_to;
    public $cancel_overdue_reminders = 0;
    public $status;
    public $entry_type = 'Institution';
    public $invoice_to = 'Customer';

    public $billed_by;
    public $fiscal_year;
    public $billed_to;
    public $rate;
    public $bank_id;
    public $billtable;
    public $max_date;
    public $min_date;
    public function updatedFiscalYear()
    {
        $this->active_year = FmsFinancialYear::where('id', $this->fiscal_year)->first();
        $this->max_date =$this->active_year->end_date;
        $this->min_date = $this->active_year->start_date;
    }
    public function selectCustomer($id)
    {
        $this->billtable = FmsCustomer::where('id', $id)->first();
    }

    public function addBalance()
    {
        if ($this->billtable) {
            $this->validate([
                'invoice_date'=>'required|date',
                'opening_balance'=>'required',
                'rate'=>'required',
                'currency_id'=>'required',                
                'fiscal_year'=>'required|numeric',
            ]);
            DB::transaction(function () {
                $this->customer_id = $this->billtable->id;
                $amount = (float) str_replace(',', '', $this->opening_balance);
                $rate = (float) str_replace(',', '', $this->rate);
                $opening_balance = $amount * $rate;
                

                $record = FmsInvoice::where(['invoice_type'=>'Opening Balance','customer_id'=>$this->customer_id])->first();
                if($record){
                    if($record->status == 'Acknowledged'){
                    $record->currency_id = $this->currency_id;
                    $record->fiscal_year = $this->fiscal_year;
                    $record->rate = $rate;
                    $record->description = $this->description;
                    $record->due_date = $this->due_date ?? $this->invoice_date;
                    $record->recurring = $this->recurring??0;
                    $record->total_amount = $amount;
                    $record->amount_local = $opening_balance;
                    $record->update();                    
                    $this->billtable->opening_balance = $opening_balance;
                    $this->billtable->update();
                    $this->dispatchBrowserEvent('close-modal');
                    $this->resetInputs();
                    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice updated successfully!']);
                    }else{
                        $this->dispatchBrowserEvent('swal:modal', [
                            'type' => 'warning',
                            'message' => 'Oops! Not Allowed!',
                            'text' => 'Ypu are not allowed to make changes on this record!',
                        ]);
                    }
                }else{
                $this->due_date = Carbon::parse($this->invoice_date)->addDays(30);
                $invoice = new FmsInvoice();
                $invoice->invoice_type = 'Opening Balance';
                $invoice->invoice_no = GeneratorService::getInvNumber() . rand(10, 99);
                $invoice->invoice_date = $this->invoice_date;
                $invoice->billed_to = 'Customer';
                $invoice->billed_by = $this->entry_type;
                $invoice->billed_department = $this->billed_department ?? null;
                $invoice->billed_project = $this->billed_project ?? null;
                $invoice->department_id = $this->department_id;
                $invoice->project_id = $this->project_id;
                $invoice->customer_id = $this->customer_id;
                $invoice->currency_id = $this->currency_id;
                $invoice->fiscal_year = $this->fiscal_year;
                $invoice->rate = $rate;
                $invoice->description = $this->description;
                $invoice->due_date = $this->due_date ?? $this->invoice_date;
                $invoice->recurring = $this->recurring??0;
                $invoice->total_amount = $amount;
                $invoice->amount_local = $opening_balance;
                $invoice->discount_type = $this->discount_type;
                $invoice->discount_total = $this->discount_total;
                $invoice->discount = $this->discount;
                $invoice->status = 'Acknowledged';
                $invoice->cycles = $this->cycles;
                $invoice->cancel_overdue_reminders = $this->cancel_overdue_reminders;
                $invoice->requestable()->associate($this->billtable);
                $invoice->billtable()->associate($this->billtable);
                $invoice->save();                
                $this->billtable->opening_balance = $opening_balance;
                $this->billtable->update();
                $this->dispatchBrowserEvent('close-modal');
                $this->resetInputs();
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Invoice created successfully!']);
                }
               
            });
        }

    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->customerIds) > 0) {
            // return (new customersExport($this->customerIds))->download('customers_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No customers selected for export!',
            ]);
        }
    }

    public function filterCustomers()
    {
        $customers = FmsCustomer::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->customerIds = $customers->pluck('id')->toArray();

        return $customers;
    }
    public function render()
    {
        $data['customers'] = $this->filterCustomers()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['years'] = FmsFinancialYear::all();
        $data['funders'] = $this->filterCustomers()->where('type', 'Funder')->get();
        $data['currencies'] = FmsCurrency::where('is_active', 1)->get();
        return view('livewire.finance.customer.fms-clients-component', $data);
    }
}
