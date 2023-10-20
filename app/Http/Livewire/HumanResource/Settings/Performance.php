<?php

namespace App\Http\Livewire\HumanResource\Settings;

use App\Models\HumanResource\Settings\Configuration;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Performance extends Component
{
    use WithFileUploads;

    public $appraisal_letter_file;

    public $appraisal_letter_config = null;

    public $showUpload = false;

    public function mount()
    {
        $appraisal = Configuration::where('key', 'appraisal_letter')->first();
        if ($appraisal == null) {
            $this->showUpload = true;
        } else {
            $this->appraisal_letter_config = $appraisal;
        }
    }

    public function uploadAppraisalTemplate()
    {
        $this->validate([
            'appraisal_letter_file' => 'required',
        ]);

        return DB::transaction(function () {
            $configuration = Configuration::firstOrCreate(['key' => 'appraisal_letter'], [
                'value' => 1,
            ]);

            if ($this->appraisal_letter_file) {
                $configuration->getFirstMedia()?->delete();
                $configuration->addMedia($this->appraisal_letter_file)->toMediaCollection();
            }
            $this->appraisal_letter_config = $configuration;

            $this->showUpload = true;

            return redirect()->to(route('human-resource.settings.performances'));
        });
    }

    public function download()
    {
        $mediaItem = $this->appraisal_letter_config->getFirstMedia();

        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }

    public function render()
    {
        return view('livewire.human-resource.settings.performance');
    }
}
