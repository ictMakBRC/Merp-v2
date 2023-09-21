<x-app-layout>
    <!-- end row-->
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    {{ __('user-mgt.edit_role_assignment') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user-roles-assignment.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">{{ __('public.name') }}</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ $user->name }}"
                                    required readonly>
                            </div>
                        </div>
                        @if (!$roles->isEmpty())
                        <div class="row mb-3">
                            <h5 class="text-success">{{ __('user-mgt.roles') }}</h5>
                            <div class="accordion" id="accordionRoles">
                                @forelse ($roles->groupBy('user_group') as $user_group => $roles)
                                <div class="accordion-item">
                                    <h6 class="accordion-header" id="heading{{ str_replace(' ', '', $user_group) }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ str_replace(' ', '', $user_group) }}"
                                            aria-expanded="true"
                                            aria-controls="collapse{{ str_replace(' ', '', $user_group) }}">
                                            {{ $user_group }}

                                        </button>
                                    </h6>
                                    <div id="collapse{{ str_replace(' ', '', $user_group) }}"
                                        class="accordion-collapse collapse @if ($loop->first) show @endif"
                                        aria-labelledby="heading{{ str_replace(' ', '', $user_group) }}"
                                        data-bs-parent="#accordionRoles">
                                        <div class="accordion-body">

                                            <div class="row">
                                                @foreach (collect($roles) as $role)
                                                <div class="mb-3 col-md-2">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="role{{ $role->id }}" name="roles[]"
                                                            value="{{ $role->id }}" {!! $role->assigned ? 'checked' : ''
                                                        !!} {!! $role->assigned && !$role->isRemovable ?
                                                        'onclick="return false;"' : '' !!}>
                                                        <label class="form-check-label" for="role{{ $role->id }}">{{
                                                            $role->display_name ?? $role->name }}</label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                        @endif
                        @if (!$permissions->isEmpty())
                        <h5 class="text-success">{{ __('user-mgt.permissions') }}</h5>
                        <hr>
                        <div class="accordion" id="accordionPermissions">
                            @forelse ($permissions as $module => $permission_operations)
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="heading{{ str_replace(' ', '', $module) }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ str_replace(' ', '', $module) }}"
                                        aria-expanded="true"
                                        aria-controls="collapse{{ str_replace(' ', '', $module) }}">
                                        {{ $module }}

                                    </button>
                                </h6>
                                <div id="collapse{{ str_replace(' ', '', $module) }}"
                                    class="accordion-collapse collapse @if ($loop->first) show @endif"
                                    aria-labelledby="heading{{ str_replace(' ', '', $module) }}"
                                    data-bs-parent="#accordionPermissions">
                                    <div class="accordion-body">
                                        <div class="row row-cols-1 row-cols-md-4 row-cols-xl-4">
                                            @foreach (collect($permission_operations) as $operation =>
                                            $user_permissions)
                                            <div class="col d-flex">
                                                <div class="car">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            @php
                                                            $alternative_operation_names = ['Create' => 'Add New',
                                                            'Read' => 'View', 'Update' => 'Modify', 'Delete' =>
                                                            'Remove','Restore' => 'Restore'];
                                                            @endphp
                                                            <h6 class="mb-1 font-weight-bold">
                                                                {{ $operation }}/<strong class="text-success">{{
                                                                    $alternative_operation_names[$operation] }}</strong>
                                                            </h6>
                                                            <hr />
                                                        </div>

                                                        <ul
                                                            class="list-group list-group-flush scrollabe-content scrollable">
                                                            @foreach (collect($user_permissions) as $permission)
                                                            <li class="list-group-item"
                                                                title="{{ $permission['description'] }}">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="permission{{ $permission['id'] }}"
                                                                        name="permissions[]"
                                                                        value="{{ $permission['id'] }}" {!!
                                                                        $permission['assigned'] ? 'checked' : '' !!}>
                                                                    <label class="form-check-label"
                                                                        for="permission{{ $permission['id'] }}">{{
                                                                        $permission['display_name'] ??
                                                                        $permission['name'] }}</label>
                                                                </div>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            @endforelse
                        </div>
                        @endif
                        <!-- end row-->
                        <div class="modal-footer">
                            <x-button class="btn-success">{{ __('public.save') }}</x-button>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
</x-app-layout>