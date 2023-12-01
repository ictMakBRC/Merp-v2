        <div class="col-xl-6 col-md-7 col-sm-12 text-md-right">
            <div class="d-flex align-items-center justify-content-md-end mt-4 mt-md-0 flex-wrap vivify pullUp delay-550">
                <div class="border-right pr-4 mr-4 mb-3 mb-xl-0 hidden-xs">
                </div>
                <div class="border-right pr-4 mr-4 mb-3 mb-xl-0">
                    <a type="button" class="btn mr-2 btn-sm btn-outline-success me-2" wire:click="refresh()"><i class="mdi mdi-refresh"></i></a>
                </div>
                <div class="pr-4 mb-3 mb-xl-0">
                    <a class="btn btn-sm @if (!$createNew) btn-success @else btn-outline-danger @endif "
                        wire:click="$set('createNew',{{ !$createNew }})"
                        data-toggle="modal" data-target="#addUpdateRecord" ><i class="fa fa-plus"></i> {{__('New')}} </a></li>
                </div>
            </div>
        </div>
