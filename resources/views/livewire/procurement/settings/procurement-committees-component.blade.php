<div>
    <div class="row" x-data="{ create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                        {{ __('Procurement Committee Members') }}
                                    @else
                                        {{ __('Edit Committee Member') }}
                                    @endif

                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div x-cloak x-show="create_new">
                        <form
                            @if (!$toggleForm) wire:submit.prevent="storeCommitteeMember"
                        @else
                        wire:submit.prevent="updateCommitteeMember" @endif>
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label for="committee" class="form-label required">{{ __('Committee') }}</label>
                                    <select class="form-select" id="committee" wire:model.lazy="committee">
                                        <option selected value="">Select</option>
                                        <option value="Contracts">Contracts Committee</option>
                                        <option value="Evaluation">Evaluation Committee</option>
                                        <option value="Negotiation">Negotiation Committee</option>
                                    </select>
                                    @error('committee')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-5">
                                    <label for="name" class="form-label required">{{ __('Memeber Name') }}</label>
                                    <input type="text" id="name" class="form-control" wire:model.defer="name">
                                    @error('name')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label for="email" class="form-label required">{{ __('Memeber Email') }}</label>
                                    <input type="email" id="email" class="form-control" wire:model.defer="email">
                                    @error('email')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label for="contact" class="form-label required">{{ __('Member Contact') }}</label>
                                    <input type="text" id="contact" class="form-control"
                                        wire:model.defer="contact">
                                    @error('contact')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-2">
                                    <label for="is_active" class="form-label required">{{ __('Status') }}</label>
                                    <select class="form-select" id="is_active" wire:model.lazy="is_active">
                                        <option selected value="">Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
                            </div>
                        </form>
                        <hr>
                    </div>

                    <div class="tab-content">

                        <div class="table-responsive">
                            <table class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Contact') }}</th>
                                        <th>{{ __('Committee') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('public.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($procurementCommittees as $key => $committeMember)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $committeMember->name }}</td>

                                            <td>{{ $committeMember->email }}</td>
                                            <td>{{ $committeMember->contact }}</td>
                                            <td>{{ $committeMember->committee }}</td>
                                            @if ($committeMember->is_active == 0)
                                                <td><span class="badge bg-danger">Suspended</span></td>
                                            @else
                                                <td><span class="badge bg-success">Active</span></td>
                                            @endif
                                            <td>
                                                <button class="btn btn btn-sm btn-outline-success"
                                                    wire:click="editData({{ $committeMember->id }})"
                                                    title="{{ __('public.edit') }}">
                                                    <i class="ti ti-edit fs-18"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>
