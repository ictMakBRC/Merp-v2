<li class="nav-item">
    <a class="nav-link" href="#invStockMgt" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="invStockMgt">
        Stock Management
    </a>

    <div class="collapse " id="invStockMgt">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="#" class="nav-link"> Stock Card</a>
            </li>
            @if (Auth::user()->hasPermission(['access_stock_management']))
            <li class="nav-item">
                <a href="{{ route('inventory-stock_status', 'all') }}" class="nav-link ">All Status</a>
            </li>
            @endif
            @if (Auth::user()->hasPermission(['make_inventory_request']))
            <li class="nav-item">
                <a href="{{ route('inventory-stock_status', 'unit') }}" class="nav-link ">Unit Status</a>
            </li>
            @endif
            @if (Auth::user()->hasPermission(['access_stock_management']))
            <li class="nav-item">
                <a href="{{ route('inventory-stock_doc', 'all') }}" class="nav-link ">All Documents</a>
            </li>
            @endif
            @if (Auth::user()->hasPermission(['make_inventory_request']))
            <li class="nav-item">
                <a href="{{ route('inventory-stock_doc', 'unit') }}" class="nav-link ">Unit Documents</a>
            </li>
            @endif
            <!-- @if (\Auth::user()->category != 'Department-staff')
            -->

                        <!--
            @endif -->

        </ul>
    </div>
</li>
