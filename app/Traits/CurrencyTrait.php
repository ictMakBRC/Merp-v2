<?php
namespace App\Traits;

use App\Models\Finance\Settings\FmsCurrency;

trait CurrencyTrait
{
    public function currency()
    {
        return $this->belongsTo(FmsCurrency::class, 'currency_id');
    }
}