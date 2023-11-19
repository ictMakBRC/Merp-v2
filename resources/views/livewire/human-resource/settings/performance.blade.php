<div class="row">
    <div class="col-3">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        {{-- <h4 class="card-title">Appraisal template</h4> --}}
                        <h4 class="card-title">Upload Appraisal letter template</h4>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div style="min-height: 100px;" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: 0px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: -20px; bottom: 0px;">
                                <div class="simplebar-content-wrapper"
                                    style="height: auto; padding-right: 20px; padding-bottom: 0px; overflow: hidden scroll;">
                                    <div class="simplebar-content" style="padding: 0px;">
                                        <div class="" style="margin: 0px;">

                                            <div class="" style="padding: 0px;">
                                                <div class="activity">
                                                    <div class="">
                                                        <div class="">
                                                            @if($appraisal_letter_config == null || $showUpload ==
                                                            false)
                                                            <div class="file-box-content mt-4">
                                                                <div class="file-box-content mt-4">
                                                                    <div class="file-box">
                                                                        <a href="#" wire:click="download"
                                                                            class="download-icon-link">
                                                                            <i
                                                                                class="las la-download file-download-icon"></i>
                                                                        </a>
                                                                        <div class="text-center">
                                                                            <i class="lar la-file-alt text-primary"></i>
                                                                            <h6 class="text-truncate">
                                                                                {{$appraisal_letter_config->getFirstMedia()->file_name}}
                                                                            </h6>
                                                                            <small
                                                                                class="text-muted">@formatDate($appraisal_letter_config->created_at)
                                                                                /
                                                                                {{number_format(($appraisal_letter_config->getFirstMedia()->size)/2048,
                                                                                3)}}MB</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <a href="#" class="text-decoration-underline"
                                                                        wire:click="$set('showUpload', true)}}">Upload
                                                                        New Template</a>
                                                                </div>
                                                            </div>
                                                            @else
                                                            <input type="file" class="form-control mb-2"
                                                                wire:model="appraisal_letter_file" />

                                                            @error('appraisal_letter_file')
                                                            <div class="text-danger text-small">{{ $message }}</div>
                                                            @enderror

                                                            <button wire:click="uploadAppraisalTemplate"
                                                                class="btn btn-sm btn-primary">Submit</button>
                                                            <button class="btn btn-sm btn-danger"
                                                                wire:click="$set('showUpload', false)}}">Cancel</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end activity-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: auto; height: 218px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                        <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;">
                        </div>
                    </div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                        <div class="simplebar-scrollbar"
                            style="height: 240px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                    </div>
                </div>
                <!--end analytics-dash-activity-->
            </div>
            <!--end card-body-->
        </div>
    </div>
</div>