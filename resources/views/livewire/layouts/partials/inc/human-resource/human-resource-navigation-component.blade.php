<div id="humanResourceManagement"
    class="main-icon-menu-pane tab-pane {{isLinkActive(['appraisals.show'], 'show')}}" role="tabpanel"
    aria-labelledby="apps-tab">
    <div class="title-box">
        <h6 class="menu-title">Human Resource</h6>
    </div>

    <div class="collapse navbar-collapse" id="sidebarCollapse">
        <!-- Navigation -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('human-resource-dashboard')}}">{{ __('public.dashboard') }}</a>
            </li>
            <!--end nav-item-->

            @include('livewire.layouts.partials.inc.human-resource.inc.employees-nav')
            @include('livewire.layouts.partials.inc.human-resource.inc.performance-nav')
            @include('livewire.layouts.partials.inc.human-resource.inc.leaves-nav')
            @include('livewire.layouts.partials.inc.human-resource.inc.grievances-nav')
            {{-- @include('livewire.layouts.partials.inc.human-resource.inc.reports-nav') --}}
            @include('livewire.layouts.partials.inc.human-resource.inc.settings-nav')
            <!--end nav-item-->
        </ul>
        <!--end navbar-nav--->
    </div>
    <!--end sidebarCollapse-->
</div><!-- end finance -->
