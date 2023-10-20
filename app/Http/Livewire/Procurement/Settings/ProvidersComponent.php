<?php

namespace App\Http\Livewire\Procurement\Settings;

use Livewire\Component;

class ProvidersComponent extends Component
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

    public $bank_account;

    public $alt_bank_account;

    public $tin;

    public $tax_withholding_rate;

    public $preferred_currency;

    // public $delivery_performance;
    // public $quality_ratings;
    public $notes;

    public $is_active;

    public function storeProvider()
    {

    }

    public function render()
    {
        return view('livewire.procurement.settings.providers-component');
    }
}
