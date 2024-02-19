<div class="tab-content">
    @include('livewire.user-management.user.filter')

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('public.name') }}</th>
                    <th>{{ __('user-mgt.user_category') }}</th>
                    <th>{{ __('public.email_address') }}</th>
                    <th>{{ __('public.contact') }}</th>
                    <th>{{ __('public.status') }}</th>
                    <th>{{ __('user-mgt.created_at') }}</th>
                    <th>{{ __('public.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->category ?? 'N/A' }}</td>
                    <td>{{ $user->email ?? 'N/A' }}</td>
                    <td>{{ $user->contact ?? 'N/A' }}</td>
                    @if ($user->is_active == 0)
                    <td><span class="badge bg-danger">Suspended</span></td>
                    @else
                    <td><span class="badge bg-primary">Active</span></td>
                    @endif
                    <td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
                    <td>
                        <button class="btn btn btn-sm btn-outline-primary" wire:click="editData({{ $user->id }})"
                            data-bs-toggle="tooltip" data-bs-placement="right" title="{{__('public.edit')}}"
                            data-bs-trigger="hover">
                            <i class="ti ti-edit fs-18"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- end preview-->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="btn-group float-end">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->