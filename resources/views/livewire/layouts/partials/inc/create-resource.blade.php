<div class="ms-auto">
    <a type="button" class="btn btn-outline-success me-2" wire:click="refresh()"><i class="ti ti-refresh"></i></a>
    <a type="button" class="btn me-2
    @if (!$createNew) btn-success
    @else
    btn-outline-danger @endif"
        wire:click="$set('createNew',{{ !$createNew }})">
        @if (!$createNew)
            <i class="ti ti-plus"></i>New
        @else
            <i class="ti ti-caret-up"></i>
        @endif
    </a>
</div>
