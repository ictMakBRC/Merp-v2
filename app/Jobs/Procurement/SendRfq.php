<?php

namespace App\Jobs\Procurement;

use Dompdf\Dompdf;
use Illuminate\Bus\Queueable;
use App\Mail\Procurement\RfqEmail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\Procurement\Request\ProcurementRequest;

class SendRfq implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
   
     protected $procurementRequest;

     public function __construct(ProcurementRequest $procurementRequest)
     {
        $this->procurementRequest = $procurementRequest->load(['items','approvals','approvals.approver','providers']);
     }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $organizationInfo=organizationInfo();
        foreach($this->procurementRequest->providers as $provider){

                // Create a new Dompdf instance
            $dompdf = new Dompdf();

            $html = view('emails.procurement.rfq-email',['provider'=>$provider,'request'=>$this->procurementRequest,'organizationInfo'=>$organizationInfo])->render();
            $dompdf->loadHtml($html);
            $dompdf->render();
    
            // Save the PDF to a file
            $pdfOutput = $dompdf->output();
            $filename=$provider->provider_code.'.pdf';
            // Create the directory if it doesn't exist

            // Save the PDF to the storage disk
            Storage::disk('local')->put('rfqs/' . $filename, $pdfOutput);
            // Get the path to the saved PDF file
            $pdfPath = Storage::disk('local')->path('rfqs/' . $filename);

            $details = [
                'provider_name' => $provider->name,
                'return_deadline' => $this->procurementRequest->bid_return_deadline,
                'rfq_path'=>$pdfPath
            ];

            $provider->notify(new RfqEmail($details));
 
            // Clean up the generated PDF file
            unlink($pdfPath);
        }
        
    }
}
