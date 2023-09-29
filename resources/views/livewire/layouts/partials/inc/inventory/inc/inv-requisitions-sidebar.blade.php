
<li class="nav-item">
  <a class="nav-link" href="#invRequisitions" data-bs-toggle="collapse" role="button"
  aria-expanded="false" aria-controls="invRequisitions">
  Requisitions
</a>
<div class="collapse " id="invRequisitions">
  <ul class="nav flex-column">

  @if(\Auth::user()->category != "Department-staff")
    <li class="nav-item">
      <a href="{{ route('incoming-requests') }}" class="nav-link ">Incoming Requests</a>
    </li>

    <li class="nav-item">
      <a href="#" class="nav-link ">Requests Fullfilled</a>
    </li>
    @endif

      @if(\Auth::user()->category == "Department-staff")
    <li class="nav-item">
        <a href="#officialContactsSubMenu" class="nav-link" data-bs-toggle="collapse" role="button"
            aria-expanded="false" aria-controls="officialContactsSubMenu">
            My Requests
        </a>
        <div class="collapse" id="officialContactsSubMenu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('forecast') }}">Forecasts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('general-requests') }}">General Request</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('consumption-based') }}">Consumption Based Request</a>
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
