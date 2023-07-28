<div class="row mb-0" x-show="filter_data">
    <h6>{{ __('user-mgt.filter_login_records') }}</h6>

    <div class="mb-3 col-md-3">
        <label for="description" class="form-label">{{ __('public.action') }}</label>
        <select class="form-select select2" id="description" wire:model="description">
            <option selected value="0">All</option>
            @forelse ($descriptions_list as $action)
                <option value='{{ $action }}'>{{ $action }}</option>
            @empty
            @endforelse
        </select>
        <div class="text-info" wire:loading wire:target='description'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-3">
        <label for="platform" class="form-label">{{ __('user-mgt.platform') }}</label>
        <select class="form-select select2" id="platform" wire:model="platform">
            <option selected value="0">All</option>
            @forelse ($platforms_list as $platform)
                <option value='{{ $platform }}'>{{ $platform }}</option>
            @empty
            @endforelse
        </select>
        <div class="text-info" wire:loading wire:target='platform'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-2">
        <label for="browser" class="form-label">{{ __('user-mgt.browser') }}</label>
        <select class="form-select select2" id="browser" wire:model="browser">
            <option selected value="0">All</option>
            @forelse ($browsers_list as $browser)
                <option value='{{ $browser }}'>{{ $browser }}
                </option>
            @empty
            @endforelse
        </select>
        <div class="text-info" wire:loading wire:target='browser'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>
</div>

<div class="row mb-0">
    <div class="mt-4 col-md-1">
        <a type="button" class="btn btn-outline-success me-2" wire:click="export()"><i class="bx bx-export"
                title="{{ __('public.export') }}"></i></a>
    </div>
    
    <div class="mb-3 col-md-2">
        <label for="from_date" class="form-label">{{ __('public.from_date') }}</label>
        <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
        <div class="text-info" wire:loading wire:target='from_date'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-2">
        <label for="to_date" class="form-label">{{ __('public.to_date') }}</label>
        <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
        <div class="text-info" wire:loading wire:target='to_date'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-1">
        <label for="perPage" class="form-label">{{ __('public.per_page') }}</label>
        <select wire:model="perPage" class="form-select" id="perPage">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <div class="text-info" wire:loading wire:target='perPage'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-2">
        <label for="orderBy" class="form-label">{{ __('public.order_by') }}</label>
        <select wire:model="orderBy" class="form-select">
            <option value="email">Email</option>
            <option value="platform">Platform</option>
            <option value="browser">Browser</option>
            <option value="id">Latest</option>
        </select>
        <div class="text-info" wire:loading wire:target='orderBy'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-1">
        <label for="orderAsc" class="form-label">{{ __('public.order') }}</label>
        <select wire:model="orderAsc" class="form-select" id="orderAsc">
            <option value="1">Asc</option>
            <option value="0">Desc</option>
        </select>
        <div class="text-info" wire:loading wire:target='oderAsc'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-3">
        <label for="search" class="form-label">{{ __('public.search') }}</label>
        <input id="search" type="text" class="form-control" wire:model.debounce.300ms="search"
            placeholder="search">
        <div class="text-info" wire:loading wire:target='search'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>
    <hr>
</div>
