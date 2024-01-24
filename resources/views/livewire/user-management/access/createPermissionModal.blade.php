 <!-- ADD NEW Role Modal -->

 <div class="modal fade" id="addPermission" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">{{ __('user-mgt.create_new_permission') }}</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
             </div> <!-- end modal header -->
             <div class="modal-body">
                 <form method="POST" action="{{ route('user-permissions.store') }}">
                     @csrf

                     <div class="row">
                         <div class="mb-3 col-md-6">
                             <label for="name" class="form-label required">{{ __('user-mgt.name') }}</label>
                             <input type="text" id="name" class="form-control" name="name"
                                 placeholder="this-will-be-the-code-name" required>
                         </div>
                         <div class="mb-3 col-md-6">
                             <label for="display_name" class="form-label required">{{ __('user-mgt.display_name') }}</label>
                             <input type="text" id="display_name" class="form-control" name="display_name"
                                 placeholder="Edit user profile" required>
                         </div>
                         <div class="col-md-6">
                            <label for="target_module" class="form-label required">{{ __('user-mgt.target_module') }}</label>
                            <select name="target_module" id="target_module" class="form-select">
                                <option value="">Select</option>
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
                         <div class="mb-3 col-md-6">
                             <label for="description" class="form-label">{{ __('public.description') }}</label>
                             <textarea type="email" id="description" class="form-control" name="description"
                                 placeholder="Some description for the permission"></textarea>
                         </div>
                     </div>
                     <!-- end row-->
                     <div class="modal-footer">
                         <x-button class="btn-success">{{ __('public.save') }}</x-button>
                         <x-button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('public.close') }}
                         </x-button>
                     </div>
                 </form>
             </div>
         </div> <!-- end modal content-->
     </div> <!-- end modal dialog-->
 </div> <!-- end modal-->
