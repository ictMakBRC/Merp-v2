<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">ERP</a>
                        </li>
                        <!--end nav-item-->
                        <li class="breadcrumb-item"><a href="#">HumanResource</a>
                        </li>
                        <!--end nav-item-->
                        <li class="breadcrumb-item active">Employee</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Employee Profile</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div x-cloak x-show="create_new">
                <livewire:human-resource.employee-data.inc.general-information-component :employee="$employee" />
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
</div><!-- container -->