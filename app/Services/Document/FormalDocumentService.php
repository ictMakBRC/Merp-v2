<?php

namespace App\Services\Document;

use Illuminate\Database\Eloquent\Model;
use App\Models\Documents\FormalDocument;
use App\Data\Document\FormalDocumentData;


class FormalDocumentService
{

    //DOCUMENTS
    public function createFormalDocument(Model $model,FormalDocumentData $formalDocumentDTO):FormalDocument
    {
        $document = $model->documents()->create([
            ...$this->fillFormalDocumentFromDTO($formalDocumentDTO)
        ]);
        return $document;
    }

    public function updateFormalDocument(FormalDocument $formalDocument, FormalDocumentData $formalDocumentDTO):FormalDocument
    {
        $formalDocument->update([
            ...$this->fillFormalDocumentFromDTO($formalDocumentDTO)
        ]);

        return $formalDocument;
    }

    private function fillFormalDocumentFromDTO(FormalDocumentData $formalDocumentDTO)
    {
        return [
            'document_category' => $formalDocumentDTO->document_category,
            'expires' => $formalDocumentDTO->expires,
            'expiry_date' => $formalDocumentDTO->expiry_date,
            'document_name' => $formalDocumentDTO->document_name,
            'document_path' => $formalDocumentDTO->document_path,
            'description' => $formalDocumentDTO->description,
        ];
        
    }
  
}
