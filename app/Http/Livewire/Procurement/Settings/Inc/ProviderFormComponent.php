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

    protected $listeners = [
        'switchProvider' => 'setProviderId',
    ];

    public function setProviderId($details)
    {
        $this->provider_id = $details['providerId'];

        $provider = Provider::findOrFail($this->provider_id);
        $this->provider = $provider;
        
    }

    public function storeProvider()
    {
        $providerDTO = new ProviderData();
       
        $this->validate($providerDTO->rules());
        // dd('YES');
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
