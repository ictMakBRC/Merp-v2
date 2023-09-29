<div id="inventoryManagement" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="apps-tab">
  <div class="title-box">
    <h6 class="menu-title">Inventory</h6>
  </div>

  <div class="collapse navbar-collapse" id="sidebarCollapse">

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('inventory-dashboard') }}">{{ __('public.dashboard') }}</a>
      </li>
      @include('livewire.layouts.partials.inc.inventory.inc.inv-manage-sidebar')
      @if(\Auth::user()->category == "Deparment-staff")
      @include('livewire.layouts.partials.inc.inventory.inc.inv-storage-sidebar')
      @endif

      @include('livewire.layouts.partials.inc.inventory.inc.inv-requisitions-sidebar')
      @include('livewire.layouts.partials.inc.inventory.inc.inv-stock-mgt-sidebar')
      @include('livewire.layouts.partials.inc.inventory.inc.inv-reports-sidebar')
    </ul>
  </div>
</div>
