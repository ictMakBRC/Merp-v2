<?php

namespace App\Services\Procurement\Settings;

use App\Models\Procurement\Settings\Provider;
use App\Data\Procurement\Settings\ProviderData;

class ProviderService
{
    public function createProvider(ProviderData $procurementProviderDTO):Provider
    {
        $procurementProvider = new Provider();
        $this->fillProviderFromDTO($procurementProvider, $procurementProviderDTO);
        $procurementProvider->save();

        return $procurementProvider;
    }

    public function updateProvider(Provider $procurementProvider, ProviderData $procurementProviderDTO):Provider
    {
        $this->fillProviderFromDTO($procurementProvider, $procurementProviderDTO);
        $procurementProvider->save();

        return $procurementProvider;
    }

    private function fillProviderFromDTO(Provider $procurementProvider, ProviderData $procurementProviderDTO)
    {
        $procurementProvider->name = $procurementProviderDTO-> name;
        $procurementProvider->provider_type = $procurementProviderDTO->provider_type;
        $procurementProvider->phone_number = $procurementProviderDTO->phone_number;
        $procurementProvider->alt_phone_number = $procurementProviderDTO->alt_phone_number;
        $procurementProvider->email = $procurementProviderDTO->email;
        $procurementProvider->alt_email = $procurementProviderDTO->alt_email;
        $procurementProvider->full_address = $procurementProviderDTO->full_address;
        $procurementProvider->contact_person = $procurementProviderDTO->contact_person;
        $procurementProvider->contact_person_phone = $procurementProviderDTO->contact_person_phone;
        $procurementProvider->contact_person_email = $procurementProviderDTO->contact_person_email;
        $procurementProvider->website = $procurementProviderDTO->website;
        $procurementProvider->country = $procurementProviderDTO->country;
        $procurementProvider->payment_terms = $procurementProviderDTO->payment_terms;
        $procurementProvider->payment_method = $procurementProviderDTO->payment_method;
        $procurementProvider->bank_name = $procurementProviderDTO->bank_name;
        $procurementProvider->branch = $procurementProviderDTO->branch;
        $procurementProvider->account_name = $procurementProviderDTO->account_name;
        $procurementProvider->bank_account = $procurementProviderDTO->bank_account;
        $procurementProvider->tin = $procurementProviderDTO->tin;
        $procurementProvider->tax_withholding_rate = $procurementProviderDTO->tax_withholding_rate;
        $procurementProvider->preferred_currency = $procurementProviderDTO->preferred_currency;
        $procurementProvider->notes = $procurementProviderDTO->notes;
        $procurementProvider->is_active = $procurementProviderDTO->is_active;    
    }


}
