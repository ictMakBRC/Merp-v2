<?php

namespace App\Data\Procurement\Settings;

use Spatie\LaravelData\Data;

class ProcurementSubcategoryData extends Data
{
  public ?string $category;
  public ?int $name;
  public ?string $is_active;

  // Validation rules for the properties
  public function rules(): array
  {
      return [
        'category' => 'required|string',
        'name' => 'required|integer',
        'is_active' => 'required|boolean',
      ];
  }

  // Validation rules for the properties
  public function resetInputs(): array
  {
    $allKeys = array_keys($this->rules());
    return array_values($allKeys);
  }

}
