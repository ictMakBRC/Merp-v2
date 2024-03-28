<div>

    <div class="card">
        <div class="card-header bg-light">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">Dashboard</h4>
                </div><!--end col-->
                <div class="col-auto">
                    <div class="dropdown">
                        <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Select<i class="las la-angle-down ms-1"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{route('human-resource-dashboard','Admin')}}">Admin</a>
                            <a class="dropdown-item" href="{{route('human-resource-dashboard','Supervisor')}}">Supervisor</a>
                            <a class="dropdown-item" href="{{route('human-resource-dashboard','Normal')}}">Normal</a>
                        </div>
                        <div class="text-info" wire:loading wire:target='activeDashboard'>
                            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                                <span class='sr-only'></span>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
            </div> <!--end row-->
        </div><!--end card-header-->
        <div class="card-body">
            @if ($activeDashboard == 'Admin')
                <livewire:human-resource.dashboard.hr-admin-dashboard />
            @elseif ($activeDashboard == 'Supervisor')
                <livewire:human-resource.dashboard.hr-supervisor-dashboard />
            @elseif ($activeDashboard == 'Normal')
                <livewire:human-resource.dashboard.hr-normal-dashboard />
            @else
                <livewire:human-resource.dashboard.hr-normal-dashboard />
            @endif

        </div>
    </div>


</div>
