<div wire:ignore.self class="modal fade" id="updateCreateModal" aria-labelledby="updateCreateModalTitle"
    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($mode == 'edit')
                    <h5 class="modal-title" id="staticBackdropLabel">Updated Chart Of Accounts</h5>
                @else
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Chart Of Accounts</h5>
                @endif
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                    aria-label="Close"></button>
            </div>
            <!-- end modal header -->
            <div class="modal-body">
                @if ($mode == 'edit')
                    <form wire:submit.prevent="updateData">
                    @else
                        <form wire:submit.prevent="storeData">
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="countryName" class="form-label required">Account Type</label>
                                <select name="" id="account_type" class="form-control" wire:model="account_type">
                                    <option value="">select...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('account_type')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="sub_account_type" class="form-label required">Account sub Type</label>
                                <select name="sub_types" id="account_type" class="form-control"
                                    wire:model="sub_account_type">
                                    <option value="">select...</option>
                                    @foreach ($sub_types as $subtype)
                                        <option value="{{ $subtype->id }}">{{ $subtype->name }}</option>
                                    @endforeach
                                </select>
                                @error('sub_account_type')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-12 mt-1">
                                <div class="input-group">
                                    <label class="switch">
                                        <input type="checkbox"
                                            wire:click="$set('is_sub',{{ $is_sub ? 'false' : 'true' }})"
                                            @if ($is_sub) checked @endif class="light-btn">
                                        <span class="slider round"></span>
                                    </label>
                                    Is Sub-account
                                    <select @if (!$is_sub && $parent_account == null) disabled @endif name="parent_account"
                                        id="parent_account" class="form-control" wire:model="parent_account">
                                        <option value="">select parent account</option>
                                        @foreach ($sub_accounts as $account)
                                            <option value="{{ $account->id }}">
                                                {{ $account->name . ' (' . $account->type->name . ')' ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_account')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" class="form-control" name="name" required
                                    wire:model.lazy="name">
                                @error('name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" wire:model='description' id="description" class="form-control"></textarea>
                                @error('description')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="is_budget" class="form-label required">Bugdetable ?</label>
                                <select name="sub_types" id="is_budget" class="form-control"
                                    wire:model="is_budget">
                                    <option value="">select...</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('is_budget')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-md-6">
                                <label for="is_active" class="form-label required">Active ?</label>
                                <select name="sub_types" id="is_active" class="form-control"
                                    wire:model="is_active">
                                    <option value="">select...</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="col-md-6 mt-1">
                                <div class="form-group">
                                    <label for="primary_balance" class="form-label">Balance</label>
                                    <input type="number" step="any" id="primary_balance" class="form-control"
                                        name="primary_balance" required wire:model.lazy="primary_balance">
                                    @error('primary_balance')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mt-1">
                                <div class="form-group">
                                    <label for="as_of" class="form-label">As of</label>
                                    <input type="date"  max="{{date('Y-m-d')}}" id="as_of" class="form-control"
                                        name="as_of" required wire:model.lazy="as_of">
                                    @error('as_of')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                        </div>

                    </div>
                </div>
                <!-- end row-->
                <div class="modal-footer">
                    <x-button class="btn-success">{{ __('Save') }}</x-button>
                    <x-button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        wire:click="close()">{{ __('Close') }}</x-button>
                </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
