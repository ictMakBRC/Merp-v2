@forelse ($appraisal->media as $media)
<a href="#" wire:click="download" class="download-icon-link">
    <i class="las la-download file-download-icon"></i>
    <span>Download the attached appraisal document</span>
</a>
@empty
<div class="d-flex justify-content-center align-items-center">
    <div class="icon-info-activity">
        <i class="las la-exclamation bg-soft-primary p-2"></i>
    </div>
    <p class="text-muted mb-0 font-13 w-75">
        No Attachments ...
</div>
@endforelse