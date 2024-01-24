
<li class="nav-item">
  <a class="nav-link" href="#invRequisitions" data-bs-toggle="collapse" role="button"
  aria-expanded="false" aria-controls="invRequisitions">
  Requisitions
</a>
<div class="collapse " id="invRequisitions">
  <ul class="nav flex-column">

  @if(\Auth::user()->hasPermission(['manage_inventory']))

    <li class="nav-item">
      <a href="{{ route('incoming-requests') }}" class="nav-link ">Incoming Requests</a>
    </li>
    @endif

      @if(\Auth::user()->hasPermission(['access_department_request']))
      
      <li class="nav-item">
        <a class="nav-link" href="{{ route('general-requests') }}">Dpt Request</a>
    </li>
    
    <li class="nav-item">
        <a href="#officialContactsSubMenu" class="nav-link" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="officialContactsSubMenu">
            @if(\Auth::user()->hasRole(['Regular Department User']) || \Auth::user()->hasRole(['Department Head']))
            My Requests
            @elseif(\Auth::user()->hasRole(['Store Admin']))
            Incoming Department Requests
            @endif
        </a>
        <div class="collapse" id="officialContactsSubMenu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('forecast') }}">Forecasts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('consumption-based') }}">Consumption Based Request</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('consumption-based') }}">Incoming Requests</a>
                </li>
                <!--end nav-item-->
                <!--end nav-item-->
            </ul>
            <!--end nav-->
        </div>
    </li>
    @endif

  </ul>
</div>
</li>
