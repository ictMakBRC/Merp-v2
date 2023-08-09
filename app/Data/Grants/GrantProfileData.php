<?php

namespace App\Data\Grants;

use Spatie\LaravelData\Data;

class GrantProfileData extends Data
{
  public ?string $grant_code;
  public ?string $grant_name;
  public ?string $grant_type;
  public ?string $funding_source;
  public ?float $funding_amount;
  public ?string $currency;
  public ?string $start_date;
  public ?string $end_date;
  public ?string $proposal_submission_date;
  public ?int $pi;
  public ?string $proposal_summary;
  public ?string $award_status;

  //GRANT PROFILE DOCUMENTS
  public ?int $grant_profile_id;
  public ?string $document_category;
  public ?bool $expires;
  public ?string $document_name;
  public ?string $document_path;
  public ?string $expiry_date;
  public ?string $description;

  // Validation rules for the properties
  public function rules(): array
  {
    return [
      'grant_code' => 'required|string|unique:grant_profiles',
      'grant_name' => 'required|string|unique:grant_profiles',
      'grant_type' => 'required|string',
      'funding_source' => 'nullable|string',
      'funding_amount' => 'nullable|numeric',
      'currency' => 'nullable|string',
      'start_date' => 'nullable|date',
      'end_date' => 'nullable|date|after:start_date',
      'proposal_submission_date' => 'required|date',
      'pi' => 'required|integer',
      'proposal_summary' => 'required|string|max:255',
      'award_status' => 'required|string',
    ];
  }

  // Validation rules for the properties
  public function grantProfileDocumentRules(): array
  {
    return [
      'grant_profile_id' => 'required|integer',
      'document_name' => 'required|integer',
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
  public function resetGrantDocumentInputs(): array
  {
    $allKeys = array_keys($this->grantProfileDocumentRules());
    return array_values(array_diff($allKeys,['grant_profile_id']));
  }
}
