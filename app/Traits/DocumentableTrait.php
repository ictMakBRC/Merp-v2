<?php
namespace App\Traits;

use App\Models\Documents\FormalDocument;

trait DocumentableTrait
{
    public function documents()
    {
        return $this->morphMany(FormalDocument::class, 'documentable');
    }
}