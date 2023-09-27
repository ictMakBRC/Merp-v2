<?php

namespace App\Http\Controllers\Documents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Documents\Requests\DmSignatureRequestDocSignatory;

class GeneralDocumentsController extends Controller
{
    function previewSignedDoc($id){
        $document = DmSignatureRequestDocSignatory::where('id', $id)->first();
        $disk = 'Documents';
        
        // return $document;
        // $document->increment('downloads',1);
        $file = $document->signed_file;
        if (!Storage::disk($disk)->exists($file)) {
            abort(404);
        }
        $mimeType = Storage::mimeType($file);

        // Return the file using the 'file' function
        return response()->file(Storage::disk($disk)->path($file), [
            'Content-Type' => $mimeType,
        ]);

        if (file_exists($file)) {
            return Storage::disk($disk)->download($document->signed_file, $document->title . ' downloaded');
            return Storage::download($document->file, $document->title.' downloaded');
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'File not found!']);
        }
    }
}
