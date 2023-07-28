<x-app-layout>
    @push('css')
        <link href="{{ asset('assets/libs/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    <!-- end row-->
    <div class="row">
        <div class="col-12">
            @include('layouts.messages')
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    {{ __('user-mgt.permissions') }}
                                </h5>
                                <div class="ms-auto">
                                    <a type="button" href="#" class="btn btn-success mb-2 me-1"
                                        data-bs-toggle="modal" data-bs-target="#addPermission"><i
                                            class="ti ti-plus"></i>New</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped mb-0 w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="th">{{ __('user-mgt.name') }}</th>
                                    <th class="th">{{ __('user-mgt.display_name') }}</th>
                                    <th class="th">{{ __('public.description') }}</th>
                                    <th class="th">{{ __('user-mgt.target_module') }}</th>
                                    <th>{{ __('public.action') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $key => $permission)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $permission->name }}
                                        </td>
                                        <td>
                                            {{ $permission->display_name }}
                                        </td>
                                        <td>
                                            {{ $permission->description }}
                                        </td>
                                        <td>
                                            {{ $permission->target_module }}
                                        </td>
                                        <td>
                                            <div class="d-flex table-actions">
                                                <a href="{{ route('user-permissions.edit', $permission->id) }}"
                                                    class="text-primary" title="{{__('public.edit')}}"> <i
                                                        class="bx bx-edit-alt"></i></a>
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
    @include('livewire.user-management.access.createPermissionModal')
    @push('scripts')
        <script src="{{ asset('assets/libs/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table = $('#datatable').DataTable({
                    lengthChange: false,
                    buttons: ['excel']
                });

                table.buttons().container()
                    .appendTo('#datatable_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
</x-app-layout>
