<li class="nav-item">
  <a class="nav-link" href="#invStockMgt" data-bs-toggle="collapse" role="button"
  aria-expanded="false" aria-controls="invStockMgt">
  Stock Management
</a>

<div class="collapse " id="invStockMgt">
  <ul class="nav flex-column">

    <li class="nav-item">
      <a href="{{ route('stockcards') }}" class="nav-link"> Stockcards</a>
    </li>

    <!-- @if(\Auth::user()->category != "Department-staff") -->

    <!-- @endif -->

  </ul>
</div>
</li>
