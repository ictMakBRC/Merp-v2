<?php

namespace App\Services\Procurement\Settings;

use App\Models\Procurement\Settings\Provider;
use App\Models\Procurement\Settings\ProviderDocument;
use App\Data\Procurement\Settings\ProcurementProviderData;

class ProcurementProviderService
{
    public function createProvider(ProcurementProviderData $procurementProviderDTO):Provider
    {
        $procurementProvider = new Provider();
        $this->fillProviderFromDTO($procurementProvider, $procurementProviderDTO);
        $procurementProvider->save();

        return $procurementProvider;
    }

    public function updateProvider(Provider $procurementProvider, ProcurementProviderData $procurementProviderDTO):Provider
    {
        $this->fillProviderFromDTO($procurementProvider, $procurementProviderDTO);
        $procurementProvider->save();

        return $procurementProvider;
    }

    private function fillProviderFromDTO(Provider $procurementProvider, ProcurementProviderData $procurementProviderDTO)
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
        // $procurementProvider->delivery_performance = $procurementProviderDTO->delivery_performance;
        // $procurementProvider->quality_ratings = $procurementProviderDTO->quality_ratings;
        $procurementProvider->notes = $procurementProviderDTO->notes;
        $procurementProvider->is_active = $procurementProviderDTO->is_active;    
    }

   //PROVIDER DOCUMENTS
   public function createProviderDocument(ProcurementProviderData $providerDocumentDTO):ProviderDocument
   {
       $providerDocument = new ProviderDocument();
       $this->fillProviderDocumentFromDTO($providerDocument, $providerDocumentDTO);
       $providerDocument->save();

       return $providerDocument;
   }

   public function updateProviderDocument(ProviderDocument $providerDocument, ProcurementProviderData $providerDocumentDTO):ProviderDocument
   {
       $this->fillProviderDocumentFromDTO($providerDocument, $providerDocumentDTO);
       $providerDocument->save();

       return $providerDocument;
   }

   private function fillProviderDocumentFromDTO(ProviderDocument $providerDocument, ProcurementProviderData $providerDocumentDTO)
   {
        $providerDocument->grant_profile_id = $providerDocumentDTO->provider_id;
        $providerDocument->document_category = $providerDocumentDTO->document_category;
        $providerDocument->expires = $providerDocumentDTO->expires;
        $providerDocument->expiry_date = $providerDocumentDTO->expiry_date;
        $providerDocument->document_name = $providerDocumentDTO->document_name;
        $providerDocument->document_path = $providerDocumentDTO->document_path;
        $providerDocument->description = $providerDocumentDTO->description;
   }
}
