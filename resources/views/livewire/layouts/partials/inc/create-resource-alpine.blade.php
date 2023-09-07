<div class="ms-auto">
    <a type="button" class="btn btn-sm btn-outline-primary me-2" wire:click="refresh()" data-bs-toggle="tooltip"
        data-bs-placement="right" title="{{ __('public.refresh') }}" data-bs-trigger="hover"><i
            class="ti ti-refresh"></i></a>
    <a type="button" class="btn btn-sm me-2
    @if (!$createNew) btn-primary
    @else
    btn-outline-danger @endif" @click='create_new = ! create_new' data-bs-toggle="tooltip" data-bs-placement="right"
        title="{{ __('public.create_new') }}" data-bs-trigger="hover">
        @if (!$createNew)
        <i class="ti ti-plus"></i>{{ __('public.new') }}
        @else
        <i class="ti ti-caret-up"></i>
        @endif
    </a>
</div>