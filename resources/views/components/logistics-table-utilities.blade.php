@props(['display' => ''])
<div class="row mb-0">

  <div class="mb-1 col-md-1">
    <label for="perPage" class="form-label">{{ __('Per Page') }}</label>
    <select wire:model="perPage" class="form-control">
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

  <div class="mt-4 col-md-2">
    <a type="button" class="btn btn-outline-success me-2 {{ $display }}" wire:click="export()"><i
      class="bx bx-export" title="{{ __('public.export') }}"></i>{{__('Export')}}</a>
    </div>
  </div>

  <hr>
