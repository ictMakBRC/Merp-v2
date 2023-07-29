<x-app-layout>
    @push('css')
    <link href="{{ asset('assets/libs/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    <div class="row">
        <div class="col-12">
            @include('layouts.messages')
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    {{ __('user-mgt.roles') }}
                                </h5>
                                <div class="ms-auto">
                                    <a type="button" href="#" class="btn btn-success mb-2 me-1"
                                        data-bs-toggle="modal" data-bs-target="#addRole"><i
                                            class="ti ti-plus"></i>{{ __('public.new') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rolesTable" class="table table-striped mb-0 w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="th">{{ __('user-mgt.display_name') }}</th>
                                    <th class="th">{{ __('user-mgt.name') }}</th>
                                    <th class="th">{{ __('user-mgt.user_group') }}</th>
                                    <th class="th"># {{ __('user-mgt.permissions') }}</th>
                                    <th>{{ __('public.action') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $role->display_name }}</td>
                                        <td> {{ $role->name }}</td>
                                        <td> {{ $role->user_group }}</td>
                                        <td>{{ $role->permissions_count }}</td>
                                        <td>
                                            <div class="d-flex table-actions">
                                                @if (\Laratrust\Helper::roleIsEditable($role))
                                                <a href="{{ route('user-roles.edit', $role->id) }}" title="{{__('public.edit')}}"
                                                    class="text-primary">
                                                    <i class="bx bx-edit-alt"></i></a>
                                            @else
                                                <a href="{{ route('user-roles.show', $role->id) }}" title="{{__('public.view')}}"
                                                    class="text-success">
                                                    <i class="bx bx-eye"></i></a>
                                            @endif

                                            <form action="{{ route('user-roles.destroy', $role->id) }}" method="POST" title="{{__('public.delete')}}">
                                                @method('DELETE')
                                                @csrf
                                                @if (\Laratrust\Helper::roleIsDeletable($role))
                                                    <a href="#"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        <i class="bx bx-trash text-danger"></i></a>
                                                @else
                                                    {{-- <i class="uil-padlock"></i> --}}
                                                @endif
                                            </form>
                                            </div>
                                           
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end preview-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    @include('livewire.user-management.access.createRoleModal')
    @push('scripts')
    <script src="{{ asset('assets/libs/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table = $('#rolesTable').DataTable({
                    lengthChange: false,
                    buttons: ['excel']
                });

                table.buttons().container()
                    .appendTo('#rolesTable_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
</x-app-layout>
