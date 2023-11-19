<div class="row mb-0" x-show="filter_data">
    <h6>{{ __('user-mgt.filter_users') }}</h6>

    <div class="mb-3 col-md-3">
        <label for="user_category" class="form-label">{{ __('user-mgt.user_category') }}</label>
        <select class="form-select select2" id="user_category" wire:model='user_category'>
            <option selected value="">All</option>
            <option value='Normal-User'>Normal User</option>
            <option value='System-Admin'>System Admin</option>
            <option value='External-Application'>External Application</option>
        </select>
        <div class="text-info" wire:loading wire:target='user_category'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>
    <div class="mb-3 col-md-3">
        <label for="user_status" class="form-label">{{ __('public.status') }}</label>
        <select wire:model="user_status" class="form-select select2" id="user_status">
            <option value="">Select</option>
            <option value="1">Active</option>
            <option value="0">Suspended</option>
        </select>
        <div class="text-info" wire:loading wire:target='user_status'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

</div>
<div class="row mb-0">
    <div class="mt-4 col-md-1">
        <x-export-button></x-export-button>
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
            {{-- <option value="name">Name</option>
            <option value="email">Email</option> --}}
            <option value="id">Latest</option>
            {{-- <option value="is_active">Status</option> --}}
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
        <div class="text-info" wire:loading wire:target='orderAsc'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-3">
        <label for="search" class="form-label">{{ __('public.search') }}</label>
        <input id="search" type="text" class="form-control" wire:model.lazy="search"
            placeholder="search">
        <div class="text-info" wire:loading wire:target='search'>
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    </div>
    <hr>
</div>
