<?php

namespace App\Models\Inventory\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectionReason extends Model
{
    use HasFactory;

    public static function search($search)
    {
      return empty($search) ? static::query()
      : static::query()
      ->where('name', 'like', '%'.$search.'%');
    }
}
