<?php

namespace App\Data\Procurement\Settings;

use Spatie\LaravelData\Data;

class ProcurementProviderData extends Data
{
  public ?string $name;
  public ?string $provider_type;
  public ?string $phone_number;
  public ?string $alt_phone_number;
  public ?string $email;
  public ?string $alt_email;
  public ?string $full_address;
  public ?string $contact_person;
  public ?string $contact_person_phone;
  public ?string $contact_person_email;
  public ?string $website;
  public ?string $country;
  public ?string $payment_terms;
  public ?string $payment_method;
  public ?string $bank_account;
  public ?string $alt_bank_account;
  public ?string $tin;
  public ?float $tax_withholding_rate;
  public ?string $preferred_currency;
  public ?float $delivery_performance;
  public ?float $quality_ratings;
  public ?string $notes;
  public ?bool $is_active;
  

  //PROVIDER DOCUMENTS
  public ?int $provider_id;
  public ?string $document_name;
  public ?string $document_path;
  public ?string $description;

  // Validation rules for the properties
  public function rules(): array
  {
      return [
        'name' => 'required|string',
        'provider_type' => 'required|string',
        'phone_number' => 'required|string|unique:providers',
        'alt_phone_number' => 'nullable|string',
        'email' => 'required|email:filter|max:255|unique:providers',
        'alt_email' => 'nullable|email',
        'full_address' => 'required|string',
        'contact_person' => 'required|string',
        'contact_person_phone' => 'required|string',
        'contact_person_email' => 'required|email:filter|max:255|unique:providers',
        'website' => 'nullable|url',
        'country' => 'nullable|string',
        'payment_terms' => 'nullable|string',
        'payment_method' => 'required|string',
        'bank_account' => 'required|string',
        'alt_bank_account' => 'nullable|string',
        'tin' => 'required|string',
        'tax_withholding_rate' => 'nullable|numeric|min:0|max:100',
        'preferred_currency' => 'required|string',
        'delivery_performance' => 'nullable|numeric|min:0|max:5',
        'quality_ratings' => 'nullable|numeric|min:0|max:5',
        'notes' => 'nullable|string',
        'is_active' => 'boolean',
      ];
  }

  // Validation rules for the properties
  public function providerDocumentRules(): array
  {
      return [
        'provider_id' => 'required|integer',
        'document_name' => 'required|string',
        'document' => 'required|string',
        'description' => 'required|string',
      ];
  }

  // Validation rules for the properties
  public function resetInputs(): array
  {
    $allKeys = array_keys($this->rules());
    return array_values($allKeys);
  }

  // Validation rules for the properties
  public function resetProviderDocumentInputs(): array
  {
    $allKeys = array_keys($this->providerDocumentRules());
    return array_values(array_diff($allKeys,['provider_id']));
  }
}
