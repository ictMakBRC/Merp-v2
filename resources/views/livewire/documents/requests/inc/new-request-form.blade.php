
            <div class="card">
                <div class="card-body">

                    @if ($viewForm)
                        <form
                            @if (!$toggleForm) wire:submit.prevent="storeRequest"
                                        @else
                                        wire:submit.prevent="updateRequest" @endif>
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-select" id="priority" wire:model.defer="priority">
                                        <option selected value="">Select</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Urgent">Urgent</option>
                                    </select>
                                    @error('priority')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id"
                                        wire:model.defer="category_id">
                                        <option selected value="">Select</option>
                                        @foreach ($categories as $category)
                                            <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-7">
                                    <label for="title" class="form-label">Request Title</label>
                                    <input type="text" id="title" class="form-control" wire:model.defer="title">
                                    @error('title')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="title" class="form-label">Request Description</label>
                                    <textarea name="details" id="details" class="form-control" wire:model.defer='details'></textarea>
                                </div>
                            </div>
                            <div class="modal-footer m-2">
                                @if (!$toggleForm)
                                    <x-button class="btn-sm btn-success">{{ __('Save') }}</x-button>
                                @else
                                    <x-button class="btn-sm btn-success">{{ __('Update') }}</x-button>
                                @endif
                                <a type="button" href="javascript:void()" class="btn btn-sm btn-outline-danger float-end ml-1"
                                wire:click="$set('createNew',{{ !$createNew }})"><i class="mdi mdi-caret-up"></i>Close </a>
                            </div>
                        </form>
                    @else
                        @if ($myRequest)
                            <div class="col-12">
                                <h4><b>Title:</b>{{ $myRequest->title }}</h4>
                                <p><b>Requester:</b>{{ $myRequest->user->name }}</p>
                                <p><b>Priority:</b>{{ $myRequest->priority }}</p>
                                <p><b>Description:</b>{{ $myRequest->description }}</p>

                            </div>

                        @if (count($myRequest->documents) > 0)
                            @php
                                $display = '';
                            @endphp
                            @foreach ($myRequest->documents as $document)
                                <div class="card">
                                    <div class="card-header">
                                        <a href="javacript:void()"
                                            wire:click="downloadDocument({{ $document->id }})">{{ $document->title }}{{ $active_document_id }}</a>
                                        <a class="text-danger" wire:click='deleteDocument({{ $document->id }})'
                                            href="javascript:void(0)">Delete</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 p-3">
                                                <div class="row">
                                                    <h5>Document Signatories</h5>
                                                    <div class="row">
                                                        <a wire:click="$set('my_document_id',{{ $document->id }})"
                                                            href="javascript: void(0);"
                                                            class=" btn btn-primary btn-sm  float-end"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#addNewSignatories">New Document
                                                            Signatories</a>
                                                        @if (count($myRequest->documents) > 0 && count($document->signatories) > 0)
                                                            <div class="mt-2 col-12">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Title</th>
                                                                            <th>Level</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($document->signatories as $signatory)
                                                                            <tr>
                                                                                <td>{{ $signatory->user->name }}</td>
                                                                                <td>{{ $signatory->title }}</td>
                                                                                <td>{{ $signatory->signatory_level }}
                                                                                </td>
                                                                                <td>
                                                                                    <a href="javascript: void(0);"
                                                                                        wire:click="deleteSignatory({{ $signatory->id }})"
                                                                                        class="action-ico text-danger  mx-1">
                                                                                        <i
                                                                                            class="mdi mdi-delete"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            @php
                                                                $display = 'd-none';
                                                            @endphp
                                                            <h6 class="text-center text-success mt-4"> No Signatory
                                                                attached</h6>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-6 p-3">
                                                <div class="row">
                                                    <h5>Support documents {{ $active_document_id }}</h5>
                                                    <a wire:click="$set('my_document_id',{{ $document->id }})"
                                                        href="javascript: void(0);"
                                                        class=" btn btn-primary btn-sm ms-auto float-end"
                                                        data-bs-toggle="modal" data-bs-target="#addNewSuportDoc">New
                                                        Support document</a>
                                                    @if (count($myRequest->documents) > 0 && count($document->supportDocuments) > 0)
                                                        <div class="mt-2 col-12">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Document Name</th>
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($document->supportDocuments as $document)
                                                                        <tr>
                                                                            <td>{{ $document->title }}</td>
                                                                            <td>
                                                                                <a href="javascript: void(0);"
                                                                                    wire:click="deleteSupportDocument({{ $document->id }})"
                                                                                    class="action-ico text-danger  mx-1">
                                                                                    <i class="mdi mdi-delete"></i></a>
                                                                                <a href="javascript: void(0);"
                                                                                    wire:click="downloadSupportDocument({{ $document->id }})"
                                                                                    class="action-ico text-success  mx-1">
                                                                                    <i class="mdi mdi-download"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <h6 class="text-center text-success mt-4"> No Support documents
                                                            attached</h6>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @include('livewire.documents.requests.inc.support_modal')
                            @include('livewire.documents.requests.inc.signaroty_modal')
                            <button wire:click='submitRequest' class="btn btn-success {{ $display }}">Submit
                                Documents</button>
                        @else
                            <h6 class="text-center text-success mt-2"> No support documents attached</h6>
                        @endif
                    @endif
                    @if ($addDocuments)
                    <div class="row">
                        <form wire:submit.prevent='addDocument'>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="title" class="form-label">Document Title</label>
                                    <input type="text" id="document_title" class="form-control"
                                        wire:model.defer="document_title">
                                    @error('document_title')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="file" class="form-label">Upload File</label>
                                    <input type="file" id="file{{ $iteration }}" class="form-control"
                                        wire:model.lazy="file">
                                    @error('file')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                    <div class="text-success text-small" wire:loading wire:target="file">Uploading
                                        file...</div>
                                </div>
                                <div class="col-md-2">
                                    <x-button class="btn-success mt-3">{{ __('Save') }}</x-button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
                @if ($myRequest)
                    <a type="button" href="javascript:void()" class="btn btn-sm btn-outline-danger float-end mt-2"
                    wire:click="$set('createNew',{{ !$createNew }})"><i class="mdi mdi-caret-up"></i>Close </a>
                @endif

                    @endif


                </div>
            </div>