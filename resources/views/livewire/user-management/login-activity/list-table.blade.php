<div class="tab-content">
    @include('livewire.user-management.login-activity.filter')

    <div class="table-responsive">
        <table id="logsTable" class="table table-striped mb-0 w-100 nowrap">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('public.email_address') }}</th>
                    <th>{{ __('public.description') }}</th>
                    <th>{{ __('user-mgt.platform') }}</th>
                    <th>{{ __('user-mgt.browser') }}</th>
                    <th>{{ __('user-mgt.client_ip') }}</th>
                    <th>{{ __('user-mgt.period') }}</th>
                    <th>{{ __('user-mgt.activity_date_time') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $key => $log)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $log->email }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->platform }}</td>
                        <td>{{ $log->browser }}</td>
                        <td>{{ $log->client_ip }}</td>
                        <td>{{ $log->created_at->diffForHumans() }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- end preview-->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="btn-group float-end">
                {{ $logs->links('vendor.livewire.bootstrap') }}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->
