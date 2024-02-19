<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')

    <form
        @if (!$toggleForm) wire:submit.prevent="storeContactInformation"
    @else
    wire:submit.prevent="updateContactInformation" @endif>
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="contact_relationship" class="form-label required">Relationship To Contact</label>
                <select class="form-select select2" id="contact_relationship" wire:model.lazy="contact_relationship"
                    required>
                    <option selected value="">Select</option>
                    @include('layouts.relationships')
                </select>
                @error('contact_relationship')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_name" class="form-label required">Contact Name</label>
                <input type="text" id="contact_name" class="form-control" wire:model.defer='contact_name' required>
                @error('contact_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_email" class="form-label">Email</label>
                <input wire:model.defer='contact_email' type="email" id="contact_email" class="form-control">
                @error('contact_email')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_phone" class="form-label required">Phone Number</label>
                <input wire:model.defer='contact_phone' type="text" id="contact_phone" class="form-control" required>
                @error('contact_phone')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact_address" class="form-label required">Address</label>
                <input wire:model.defer='contact_address' type="text" id="contact_address" class="form-control"
                    required>
                @error('contact_address')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <x-button class="btn btn-success">
                @if (!$toggleForm)
                    {{ __('public.save') }}
                @else
                    {{ __('public.update') }}
                @endif
            </x-button>
        </div>
    </form>

    <!--EMERGENCY CONTACT INFORMATION-->
    @if (!$emergencyInformation->isEmpty())
        <div class="row">
            
            <div class="col-lg-12">
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped w-100 text-center">
                        <thead>
                            <tr>

                                <th>Name</th>
                                <th>Relationship</th>
                                <th>Address</th>
                                <th>Contract</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($emergencyInformation as $emergencycontact)
                            <tr>
                                <td>
                                    {{ $emergencycontact->contact_name }}

                                </td>
                                <td>
                                    {{ $emergencycontact->contact_relationship }}
                                </td>
                                <td>
                                    {{ $emergencycontact->contact_address }}

                                </td>
                                <td>
                                    {{ $emergencycontact->contact_phone }}
                                </td>
                                <td>
                                    {{ $emergencycontact->contact_email }}
                                </td>
                                <td>
                                    <button class="btn btn btn-sm btn-outline-success"
                                        wire:click="editData({{ $emergencycontact->id }})"
                                        title="{{ __('public.edit') }}">
                                        <i class="ti ti-edit fs-18"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div> <!-- end preview-->
            </div>
        </div>
        <!-- end EMERGENCY CONTACT INFORMATION-->
    @endif

</div>
