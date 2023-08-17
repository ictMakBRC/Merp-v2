<?php

namespace App\Http\Livewire\Finance\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Finance\Settings\FmsCustomer;

class CustomersComponent extends Component
{  
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $customerIds;

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
    public $account_number;
    public $title;
    public $surname;
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
    public $is_active;
    public $created_by;    

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function validateCustomer()
    {
        return  [
            'account_number'=>'nullable|string',
            'title'=>'nullable|string',
            'surname'=>'required|string',
            'first_name'=>'required|string',
            'other_name'=>'nullable|string', 
            'gender'=>'nullable|string', 
            'nationality'=>'nullable|string',            
            'address'=>'nullable|string', 
            'city'=>'nullable|string', 
            'email'=>'nullable|email', 
            'alt_email'=>'nullable|string',
            'contact'=>'nullable|string', 
            'fax'=>'nullable|string', 
            'alt_contact'=>'nullable|string', 
            'website'=>'nullable|string', 
            'company_name'=>'nullable|string', 
            'payment_terms'=>'nullable|string', 
            'payment_methods'=>'nullable|string', 
            'opening_balance'=>'nullable|numeric',
            'sales_tax_registration'=>'nullable', 
            'as_of'=>'required|date', 
            'is_active'=>'required|integer',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, $this->validateCustomer());
    }

    public function storeCustomer()
    {
        $this->validate($this->validateCustomer());

        $customer = new FmsCustomer();
            $customer->account_number = $this->account_number;
            $customer->title = $this->title;
            $customer->surname = $this->surname;
            $customer->first_name = $this->first_name;
            $customer->other_name  = $this->other_name; 
            $customer->gender  = $this->gender; 
            $customer->nationality             = $this->nationality;            
            $customer->address  = $this->address; 
            $customer->city  = $this->city; 
            $customer->email  = $this->email; 
            $customer->alt_email = $this->alt_email;
            $customer->contact  = $this->contact; 
            $customer->fax  = $this->fax; 
            $customer->alt_contact  = $this->alt_contact; 
            $customer->website  = $this->website; 
            $customer->company_name  = $this->company_name; 
            $customer->payment_terms  = $this->payment_terms; 
            $customer->payment_methods  = $this->payment_methods; 
            $customer->opening_balance = $this->opening_balance;
            $customer->sales_tax_registration  = $this->sales_tax_registration; 
            $customer->as_of  = $this->as_of; 
            $customer->is_active = $this->is_active;
        $customer->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'customer created successfully!']);
    }

    public function editData(FmsCustomer $customer)
    {
        $this->edit_id = $customer->id;
                $this->title  =$customer->title;
                $this->surname  =$customer->surname;
                $this->first_name  =$customer->first_name;
                $this->other_name =$customer->other_name; 
                $this->gender =$customer->gender; 
                $this->nationality  =$customer->nationality;            
                $this->address =$customer->address; 
                $this->city =$customer->city; 
                $this->email =$customer->email; 
                $this->alt_email = $customer->alt_email;              
                $this->contact =$customer->contact; 
                $this->fax =$customer->fax; 
                $this->alt_contact =$customer->alt_contact; 
                $this->website =$customer->website; 
                $this->company_name =$customer->company_name; 
                $this->payment_terms =$customer->payment_terms; 
                $this->payment_methods =$customer->payment_methods; 
                $this->opening_balance = $customer->opening_balance;
                $this->sales_tax_registration =$customer->sales_tax_registration; 
                $this->as_of =$customer->as_of; 
                $customer->is_active  =$customer->is_active;
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
            'account_number',
            'title',
            'surname',
            'first_name',
            'other_name', 
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
            'is_active',
            'created_by',
            'edit_id']);
    }

    public function updateCustomer()
    {
        $this->validate($this->validateCustomer());

        $customer = FmsCustomer::find($this->edit_id);
        $customer->account_number = $this->account_number;
        $customer->title = $this->title;
        $customer->surname = $this->surname;
        $customer->first_name = $this->first_name;
        $customer->other_name  = $this->other_name; 
        $customer->gender  = $this->gender; 
        $customer->nationality             = $this->nationality;            
        $customer->address  = $this->address; 
        $customer->city  = $this->city; 
        $customer->email  = $this->email; 
        $customer->alt_email = $this->alt_email;
        $customer->contact  = $this->contact; 
        $customer->fax  = $this->fax; 
        $customer->alt_contact  = $this->alt_contact; 
        $customer->website  = $this->website; 
        $customer->company_name  = $this->company_name; 
        $customer->payment_terms  = $this->payment_terms; 
        $customer->payment_methods  = $this->payment_methods; 
        $customer->opening_balance = $this->opening_balance;
        $customer->sales_tax_registration  = $this->sales_tax_registration; 
        $customer->as_of  = $this->as_of; 
        $customer->is_active = $this->is_active;
        $customer->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'customer updated successfully!']);
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
        
        return view('livewire.finance.settings.customers-component',$data);
    }
}
