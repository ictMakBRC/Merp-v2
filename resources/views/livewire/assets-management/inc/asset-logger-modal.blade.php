<div wire:ignore.self class="modal fade" id="assetLoggerModal" tabindex="-1" role="dialog"
    aria-labelledby="assetLoggerModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centere modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6 class="modal-title m-0" id="assetLoggerModalTitle">
                    Asset Logger
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal"
                    aria-label="Close"><i class="ti ti-x"></i></button>
            </div>

            <div class="modal-body">
                <livewire:assets-management.asset-log-component />
            </div>

        </div>
        <!--end modal-content-->
    </div>
    <!--end modal-dialog-->
</div>
<!--end modal-->
