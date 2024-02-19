<?php

namespace App\Http\Livewire\Procurement\Settings\Inc;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Procurement\Settings\Provider;
use App\Data\Procurement\Settings\ProviderData;
use App\Services\Procurement\Settings\ProviderService;

class ProviderFormComponent extends Component
{
    public $name;
    public $provider_type;
    public $phone_number;
    public $alt_phone_number;
    public $email;
    public $alt_email;
    public $full_address;
    public $contact_person;
    public $contact_person_phone;
    public $contact_person_email;
    public $website;
    public $country;
    public $payment_terms;
    public $payment_method;
    public $bank_name;
    public $branch;
    public $account_name;
    public $bank_account;
    public $tin;
    public $tax_withholding_rate;
    public $preferred_currency;
    // public ?float $delivery_performance;
    // public ?float $quality_ratings;
    public $notes;
    public $is_active;

    public $provider;
    public $provider_id;
    public $editMode=false;

    protected $listeners = [
        'loadProvider',
    ];

    public function storeProvider()
    {
        $providerDTO = new ProviderData();
       
        $this->validate($providerDTO->rules());
        DB::transaction(function (){

            $providerDTO = ProviderData::from([
                'name' =>  $this->name,
                'provider_type' =>  $this->provider_type,
                'phone_number' =>  $this->phone_number,
                'alt_phone_number' =>  $this->alt_phone_number,
                'email' =>  $this->email,
                'alt_email' =>  $this->alt_email,
                'full_address' =>  $this->full_address,
                'contact_person' =>  $this->contact_person,
                'contact_person_phone' =>  $this->contact_person_phone,
                'contact_person_email' =>  $this->contact_person_email,
                'website' =>  $this->website,
                'country' =>  $this->country,
                'payment_terms' =>  $this->payment_terms,
                'payment_method' =>  $this->payment_method,
                'bank_name' =>  $this->bank_name,
                'branch' =>  $this->branch,
                'account_name' =>  $this->account_name,
                'bank_account' =>  $this->bank_account,
                'tin' =>  $this->tin, 
                'tax_withholding_rate' =>  $this->tax_withholding_rate,
                'preferred_currency' =>  $this->preferred_currency,
                'notes' =>  $this->notes,
                'is_active' =>  $this->is_active,
                ]
            );

            $providerService = new ProviderService();
            $provider = $providerService->createProvider($providerDTO);

            $this->emit('providerCreated', [
                'providerId' => $provider->id,
            ]);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Provider details created successfully']);
            $this->reset($providerDTO->resetInputs());

        });
    }

    public function loadProvider($details)
    {
        $this->provider_id = $details['providerId'];
        $provider = Provider::findOrFail($this->provider_id);
        $this->provider = $provider;

        $this->name =  $this->provider->name;
        $this->provider_type =  $this->provider->provider_type;
        $this->phone_number =  $this->provider->phone_number;
        $this->alt_phone_number =  $this->provider->alt_phone_number;
        $this->email =  $this->provider->email;
        $this->alt_email =  $this->provider->alt_email;
        $this->full_address =  $this->provider->full_address;
        $this->contact_person =  $this->provider->contact_person;
        $this->contact_person_phone =  $this->provider->contact_person_phone;
        $this->contact_person_email =  $this->provider->contact_person_email;
        $this->website =  $this->provider->website;
        $this->country =  $this->provider->country;
        $this->payment_terms =  $this->provider->payment_terms;
        $this->payment_method =  $this->provider->payment_method;
        $this->bank_name =  $this->provider->bank_name;
        $this->branch =  $this->provider->branch;
        $this->account_name =  $this->provider->account_name;
        $this->bank_account =  $this->provider->bank_account;
        $this->tin =  $this->provider->tin; 
        $this->tax_withholding_rate =  $this->provider->tax_withholding_rate;
        $this->preferred_currency =  $this->provider->preferred_currency;
        $this->notes =  $this->provider->notes;
        $this->is_active =  $this->provider->is_active;

        $this->editMode=true;
    }

    public function updateProvider()
    {
        $providerDTO = new ProviderData();
        $this->validate($providerDTO->rules());

        DB::transaction(function (){

            $providerDTO = ProviderData::from([
                'name' =>  $this->name,
                'provider_type' =>  $this->provider_type,
                'phone_number' =>  $this->phone_number,
                'alt_phone_number' =>  $this->alt_phone_number,
                'email' =>  $this->email,
                'alt_email' =>  $this->alt_email,
                'full_address' =>  $this->full_address,
                'contact_person' =>  $this->contact_person,
                'contact_person_phone' =>  $this->contact_person_phone,
                'contact_person_email' =>  $this->contact_person_email,
                'website' =>  $this->website,
                'country' =>  $this->country,
                'payment_terms' =>  $this->payment_terms,
                'payment_method' =>  $this->payment_method,
                'bank_name' =>  $this->bank_name,
                'branch' =>  $this->branch,
                'account_name' =>  $this->account_name,
                'bank_account' =>  $this->bank_account,
                'tin' =>  $this->tin, 
                'tax_withholding_rate' =>  $this->tax_withholding_rate,
                'preferred_currency' =>  $this->preferred_currency,
                'notes' =>  $this->notes,
                'is_active' =>  $this->is_active,
                ]
            );
  
            $providerService = new ProviderService();

            $provider = $providerService->updateProvider($this->provider,$providerDTO);
   
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Provider details updated successfully']);

            $this->reset($providerDTO->resetInputs());

        });
    }

    public function render()
    {
        return view('livewire.procurement.settings.inc.provider-form-component');
    }
}
