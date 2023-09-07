
<li class="nav-item">
  <a class="nav-link" href="#invRequisitions" data-bs-toggle="collapse" role="button"
  aria-expanded="false" aria-controls="invRequisitions">
  Requisitions
</a>
<div class="collapse " id="invRequisitions">
  <ul class="nav flex-column">

    <!-- @if(\Auth::user()->category == 'Department-staff') -->
    <li class="nav-item">
      <a href="#" class="nav-link ">Incoming Requests</a>
    </li>
    <!-- @endif -->

    <!-- @if(\Auth::user()->hasPermission(['manage-inventory'])) -->
    <li class="nav-item">
      <a href="#" class="nav-link ">Incoming Requests</a>
    </li>
    <!-- @endif -->

    <li class="nav-item">
      <a href="#" class="nav-link ">Requests Fullfilled</a>
    </li>

  </ul>
</div>
</li>
