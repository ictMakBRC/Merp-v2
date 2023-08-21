<div class="tab-content">
    @include('livewire.grants.projects.inc.filter')

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('public.name') }}</th>
                    <th>{{ __('user-mgt.user_category') }}</th>
                    <th>{{ __('public.email_address') }}</th>
                    <th>{{ __('public.status') }}</th>
                    <th>{{ __('user-mgt.created_at') }}</th>
                    <th>{{ __('public.action') }}</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div> <!-- end preview-->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="btn-group float-end">
                {{-- {{ $projects->links('vendor.pagination.bootstrap-5') }} --}}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->
