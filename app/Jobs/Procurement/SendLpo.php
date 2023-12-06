<?php

namespace App\Jobs\Procurement;

use Dompdf\Dompdf;
use Illuminate\Bus\Queueable;
use App\Mail\Procurement\LpoEmail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\Procurement\Request\ProcurementRequest;

class SendLpo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $procurementRequest;
    protected $provider;

     public function __construct(ProcurementRequest $procurementRequest)
     {
        $this->procurementRequest = $procurementRequest->load(['items','approvals','approvals.approver','bestBidders']);
        $this->provider = $this->procurementRequest->bestBidders->first();
     }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // foreach($this->procurementRequest->providers as $provider){

                // Create a new Dompdf instance
            $dompdf = new Dompdf();

            $html = view('emails.procurement.lpo-email',['request'=>$this->procurementRequest,'organizationInfo'=>organizationInfo()])->render();
            $dompdf->loadHtml($html);
            $dompdf->render();
    
            // Save the PDF to a file
            $pdfOutput = $dompdf->output();
            $filename=$this->provider->provider_code.'.pdf';
            // Create the directory if it doesn't exist

            // Save the PDF to the storage disk
            Storage::disk('local')->put('lpo/' . $filename, $pdfOutput);
            // Get the path to the saved PDF file
            $pdfPath = Storage::disk('local')->path('lpo/' . $filename);
    
            $details = [
                'provider_name' => $this->provider->name,
                'lpo_no' => $this->procurementRequest->lpo_no,
                'lpo_path'=>$pdfPath
            ];

            $this->provider->notify(new LpoEmail($details));
 
            // Clean up the generated PDF file
            unlink($pdfPath);
        // }
        
    }
}
