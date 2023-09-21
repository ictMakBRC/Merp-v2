<?php

namespace App\Data\Document;

use Spatie\LaravelData\Data;

class FormalDocumentData extends Data
{

  // DOCUMENTS
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
        'document_category' => 'required|string',
        'expires' => 'required|boolean',
        'document_name' => 'required|string',
        'document' => 'required|mimes:pdf|max:10000',
        'expiry_date' => 'nullable|required_if:expires,true|date|after:today',
        'description' => 'nullable|string',
    ];
  }

  // Validation rules for the properties
  public function resetInputs(): array
  {
    $allKeys = array_keys($this->rules());
    return array_values($allKeys);
  }

}