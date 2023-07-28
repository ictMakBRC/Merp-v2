<x-app-layout>
    @push('css')
        <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush
    @include('layouts.messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    {{ __('user-mgt.role_assignment') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="roleAssignment" class="table table-striped mb-0 w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="th">{{ __('public.name') }}</th>
                                    <th class="th">{{ __('public.email') }}</th>
                                    <th class="th">{{ __('user-mgt.roles') }}</th>
                                    <th class="th">{{ __('user-mgt.non_default_permissions') }}</th>
                                    <th>{{ __('public.action') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $user->fullName ?? 'The model doesn\'t have a `name` attribute' }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ $user->roles_count }}
                                        </td>
                                        @if (config('laratrust.panel.assign_permissions_to_user'))
                                            <td>
                                                {{ $user->permissions_count }}
                                            </td>
                                        @endif
                                        <td>
                                            <div class="d-flex table-actions">
                                                <a href="{{ route('user-roles-assignment.edit', $user->id) }}" title="{{__('user-mgt.role_assignment')}}"
                                                    class="text-primary"> <i
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
    @push('scripts')
        <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table = $('#roleAssignment').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'print']
                });

                table.buttons().container()
                    .appendTo('#roleAssignment_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
</x-app-layout>
