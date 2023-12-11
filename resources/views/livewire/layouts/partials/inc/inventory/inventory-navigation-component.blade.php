<div id="inventoryManagement" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="apps-tab">
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
      <li class="nav-item">
        <a class="nav-link" href="#inv-requests" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="inv-requests">
            Request
        </a>
        <div class="collapse " id="inv-requests">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{route('inventory-requests')}}" class="nav-link ">My Requests</a>
                </li> 
                <!--end nav-item-->
                <li class="nav-item">
                    <a href="{{ route('inventory-requests-in') }}" class="nav-link ">In-coming</a>
                </li>
                <!--end nav-item-->
                
            </ul>
            <!--end nav-->
        </div>
        <!--end sidebarAnalytics-->
    </li>
      <li class="nav-item">
          <a class="nav-link" href="#inv-settings" data-bs-toggle="collapse" role="button"
              aria-expanded="false" aria-controls="inv-settings">
              Settings
          </a>
          <div class="collapse " id="inv-settings">
              <ul class="nav flex-column">
                  <li class="nav-item">
                      <a href="{{route('inventory-stores')}}" class="nav-link ">Stores</a>
                  </li> 
                  <!--end nav-item-->
                  <li class="nav-item">
                      <a href="{{ route('inventory-sections') }}" class="nav-link ">Storage Sections</a>
                  </li>
                  <!--end nav-item-->
                  <li class="nav-item">
                      <a href="{{ route('inventory-storage_bins') }}" class="nav-link ">Storage Bins</a>
                  </li>
                  <!--end nav-item-->
                  <li class="nav-item">
                      <a href="{{ route('inventory-categories') }}" class="nav-link ">Categories</a>
                  </li>
                  <!--end nav-item-->
                  <li class="nav-item">
                      <a href="{{ route('inventory-unit_of_measures') }}" class="nav-link ">Unit of Measures</a>
                  </li>
              </ul>
              <!--end nav-->
          </div>
          <!--end sidebarAnalytics-->
      </li>
    <!--end nav-item-->
    </ul>
  </div>
</div>
