
<li class="nav-item">
  <a class="nav-link" href="#invManage" data-bs-toggle="collapse" role="button"
  aria-expanded="false" aria-controls="invManage">
  Manage
</a>
<div class="collapse " id="invManage">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="{{route('inventory-commodities')}}" class="nav-link ">Commodities</a>
    </li>

    <li class="nav-item">
      <a href="{{ route('inventory-categories') }}" class="nav-link ">Categories</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('inventory-unit_of_measures') }}" class="nav-link ">Unit Of Measure</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('department-items') }}" class="nav-link ">Department Items</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('rejection-reasons') }}" class="nav-link ">Rejection Reasons</a>
    </li>
  </ul>
</div>
</li>
