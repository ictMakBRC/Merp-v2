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
                                        {{ __('Procurement Methods') }}
                                    @else
                                        {{ __('Edit Procurement Method') }}
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
                            @if (!$toggleForm) wire:submit.prevent="storeProcurementMethod"
                        @else
                        wire:submit.prevent="updateProcurementMethod" @endif>
                            <div class="row">


                                <div class="mb-3 col-md-6">
                                    <label for="method"
                                        class="form-label required">{{ __('Procurement Method') }}</label>
                                    <input type="text" id="method" class="form-control" wire:model.defer="method">
                                    @error('method')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea type="text" id="description" class="form-control" wire:model.defer="description"></textarea>
                                    @error('description')
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
                                        <th>{{ __('Method') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('public.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($procurementMethods as $key => $method)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $method->method }}</td>
                                            <td>{{ $method->description ?? 'N/A' }}</td>
                                            <td>
                                                <button class="btn btn btn-sm btn-outline-success"
                                                    wire:click="editData({{ $method->id }})"
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
