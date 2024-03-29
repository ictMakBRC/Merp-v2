 <!-- ADD NEW Role Modal -->

 <div class="modal fade" id="addRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">{{ __('user-mgt.create_new_role') }}</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
             </div> <!-- end modal header -->
             <div class="modal-body">
                 <form method="POST" action="{{ route('user-roles.store') }}">
                     @csrf

                     <div class="row">
                         <div class="mb-3 col-md-4">
                             <label for="name" class="form-label required">{{ __('user-mgt.name') }}</label>
                             <input type="text" id="name" class="form-control" name="name"
                                 placeholder="this-will-be-the-code-name" required>
                         </div>

                         <div class="mb-3 col-md-4">
                             <label for="display_name"
                                 class="form-label required">{{ __('user-mgt.display_name') }}</label>
                             <input type="text" id="display_name" class="form-control" name="display_name"
                                 placeholder="Edit user profile" required>
                         </div>

                         <div class="col-md-4">
                            <label for="user_group" class="form-label required">{{ __('user-mgt.user_group') }}</label>
                            <select name="user_group" id="user_group" class="form-select">
                                <option value="" selected>Select</option>
                                <option value="System Administration">System Administration</option>
                                <option value="Human Resource">Human Resource</option>
                                <option value="Finance">Finance</option>
                                <option value="Procurement">Procurement</option>
                                <option value="Inventory Management">Inventory Management</option>
                                <option value="Assets Management">Assets Management</option>
                                <option value="Grants and Projects">Grants and Projects</option>
                                <option value="Documents Management">Documents Management</option>
                                <option value="Helpdesk">Helpdesk</option>
                            </select>
                         </div>

                         <div class="mb-3 col-md-12">
                             <label for="description" class="form-label">{{ __('public.description') }}</label>
                             <textarea type="text" id="description" class="form-control" name="description"
                                 placeholder="Some description for the role"></textarea>
                         </div>

                     </div>

                     <h5>{{ __('user-mgt.permissions') }}</h5>
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
                                             @foreach (collect($permission_operations) as $operation => $user_permissions)
                                                 <div class="col d-flex">
                                                     <div class="car">
                                                         <div class="card-body">
                                                             <div class="d-flex align-items-center">
                                                                @php
                                                                    $alternative_operation_names=['Create'=>'Add New','Read'=>'View','Update'=>'Modify','Delete'=>'Remove']; 
                                                                @endphp
                                                                <h6 class="mb-1 font-weight-bold">
                                                                    
                                                                    {{ $operation }}/<strong class="text-success">{{$alternative_operation_names[$operation]}}</strong>
                                                                    
                                                                </h6>
                                                                <hr />
                                                             </div>

                                                             <ul
                                                                 class="list-group list-group-flush scrollabe-content scrollable">
                                                                 @foreach (collect($user_permissions) as $permission)
                                                                     <li class="list-group-item" title="{{$permission['description']}}">
                                                                         <div class="form-check form-check-inline">
                                                                             <input class="form-check-input"
                                                                                 type="checkbox"
                                                                                 id="permission{{ $permission['id'] }}"
                                                                                 name="permissions[]"
                                                                                 value="{{ $permission['id'] }}">
                                                                             <label class="form-check-label"
                                                                                 for="permission{{ $permission['id'] }}">{{ $permission['display_name'] ?? $permission['name'] }}</label>
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
                     <!-- end row-->
                     <div class="modal-footer">
                         <x-button class="btn-success">{{ __('public.save') }}</x-button>
                         <x-button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                             {{ __('public.close') }}
                         </x-button>
                     </div>
                 </form>
             </div>
         </div> <!-- end modal content-->
     </div> <!-- end modal dialog-->
 </div> <!-- end modal-->
