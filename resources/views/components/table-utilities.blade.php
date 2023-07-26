@props(['display' => ''])
<div class="row mb-0">

  <div class="mb-1 col-md-1">
    <label for="perPage" class="form-label">{{ __('public.per_page') }}</label>
    <select wire:model="perPage" class="form-select" id="perPage">
      <option value="10">10</option>
      <option value="20">20</option>
      <option value="30">30</option>
      <option value="50">50</option>
      <option value="100">100</option>
      <option value="200">200</option>
      <option value="500">500</option>
      <option value="1000">1000</option>
    </select>
  </div>

  {{ $slot }}

    <div class="mb-1 col-md-1">
        <label for="orderAsc" class="form-label">{{ __('public.order') }}</label>
        <select wire:model="orderAsc" class="form-select" id="orderAsc">
            <option value="1">Asc</option>
            <option value="0">Desc</option>
        </select>
    </div>

  <div class="mb-1 col-md-3">
    <label for="search" class="form-label">{{ __('public.search') }}</label>
    <input id="search" type="text" class="form-control float-end" wire:model.debounce.300ms="search"
    placeholder="search">
  </div>

  <div class="mt-4 col-md-2">
    <a type="button" class="font-16 btn btn-outline-success float-end me-2 {{ $display }}" wire:click="export()"><i
      class="bx bx-export" title="{{ __('public.export') }}"></i>Export</a>
    </div>

    <hr>
  </div>
