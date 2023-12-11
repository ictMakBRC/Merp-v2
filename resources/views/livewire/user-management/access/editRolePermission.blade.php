<x-app-layout>

    <div class="row">
        @include('layouts.messages')
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    {{ __('public.edit') }} {{ Str::ucfirst($type) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ $model ? route('user-'.$type.'s.update', $model->id) :
                        route('user-'.$type.'s.store') }}">
                        @csrf
                        @if ($model)
                        @method('PUT')
                        @endif

                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="name" class="form-label">{{ __('user-mgt.name') }}</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ $model->name }}"
                                    placeholder="this-will-be-the-code-name" required readonly>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="display_name" class="form-label">{{ __('user-mgt.display_name') }}</label>
                                <input type="text" id="display_name" class="form-control" name="display_name"
                                    value="{{ $model->display_name }}" placeholder="Edit user profile" required>
                            </div>

                            <div class="col-md-4">
                                <label for="user_group" class="form-label required">{{ __('user-mgt.user_group')
                                    }}</label>
                                <select name="user_group" id="user_group" class="form-select">
                                    <option value="{{ $model->user_group }}" selected>{{ $model->user_group }}</option>
                                    <option value="System Administration">System Administration</option>
                                    <option value="Sample Referral">Sample Referral</option>
                                    <option value="Logistics">Logistics</option>
                                    <option value="Training Management">Training Management</option>
                                    <option value="External Quality Assurance">External Quality Assurance</option>
                                    <option value="Helpdesk">Helpdesk</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">{{ __('public.description') }}</label>
                                <textarea type="email" id="description" class="form-control" name="description"
                                    placeholder="Some description for the {{ $type }}">{{ $model->description ?? old('description') }}</textarea>
                            </div>
                        </div>
                        @if ($type == 'role')
                        <h5>{{ __('user-mgt.permissions') }}</h5>
                        <hr>
                        <div class="accordion" id="accordionPermissions">
                            @forelse ($permissions as $module => $permission_operations)
                            <div class="accordion-item">
                                <h6 class="accordion-header"
                                    id="heading{{str_replace('/', '',str_replace(' ', '', $module)) }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{str_replace('/', '',str_replace(' ', '', $module)) }}"
                                        aria-expanded="true"
                                        aria-controls="collapse{{str_replace('/', '',str_replace(' ', '', $module)) }}">
                                        {{ $module }}

                                    </button>
                                </h6>
                                <div id="collapse{{str_replace('/', '',str_replace(' ', '', $module)) }}"
                                    class="accordion-collapse collapse @if ($loop->first) show @endif"
                                    aria-labelledby="heading{{str_replace('/', '',str_replace(' ', '', $module)) }}"
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