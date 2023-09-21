<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title">Attachments</h4>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end card-header-->
    <div class="card-body">
        <div style="min-height: 100px;" data-simplebar="init">
            <div class="" style="margin: 0px;">

                <div class="" style="padding: 0px;">
                    <div class="activity">
                        <div class="activity-info">
                            <div class="activity-info-text">
                                @forelse ($grievance->media as $media)
                                <div class="file-box-content mt-4">
                                    <div class="file-box">
                                        <a href="#" wire:click="download" class="download-icon-link">
                                            <i class="las la-download file-download-icon"></i>
                                        </a>
                                        <div class="text-center">
                                            <i class="lar la-file-alt text-primary"></i>
                                            <h6 class="text-truncate">
                                                {{$media->file_name}}</h6>
                                            <small class="text-muted">@formatDate($media->created_at) /
                                                {{number_format(($media->size)/2048,
                                                3)}}MB</small>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="icon-info-activity">
                                        <i class="las la-exclamation bg-soft-primary p-2"></i>
                                    </div>
                                    <p class="text-muted mb-0 font-13 w-75">
                                        No Attachments ...
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <!--end activity-->
                </div>
            </div>
        </div>
        <!--end analytics-dash-activity-->
    </div>
    <!--end card-body-->
</div>