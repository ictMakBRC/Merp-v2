<div id="inventoryManagement" class="main-icon-menu-pane tab-pane {{ request()->segment(1) == 'inventory' ? 'active menuitem-active' : '' }}" role="tabpanel" aria-labelledby="apps-tab">
  <div class="title-box">
    <h6 class="menu-title">Inventory</h6>
  </div>

  <div class="collapse navbar-collapse" id="sidebarCollapse">

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('inventory-dashboard') }}">{{ __('public.dashboard') }}</a>
      </li>
      @if(\Auth::user()->hasPermission(['manage_inventory']))
      @include('livewire.layouts.partials.inc.inventory.inc.inv-manage-sidebar')
      @include('livewire.layouts.partials.inc.inventory.inc.inv-storage-sidebar')
      @endif

      @include('livewire.layouts.partials.inc.inventory.inc.inv-requisitions-sidebar')

      @if(\Auth::user()->hasPermission(['manage_inventory']))
      @include('livewire.layouts.partials.inc.inventory.inc.inv-stock-mgt-sidebar')
      @endif

      @include('livewire.layouts.partials.inc.inventory.inc.inv-reports-sidebar')
    </ul>
  </div>
</div>
