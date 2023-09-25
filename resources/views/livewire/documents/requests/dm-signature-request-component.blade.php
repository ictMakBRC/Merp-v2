<div>
    <div class="container-fluid"  x-data="{ filter_data: @entangle('filter'),create_new: @entangle('createNew') }">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Documents</a></li>
                            <li class="breadcrumb-item active">Requests</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @if ($createNew)
        @include('livewire.documents.requests.inc.new-request-form')
            {{-- @if ($active_document && count($active_document->signatories) > 0)
                <button class="btn btn-success"wire:click="submutRequest">Submit Request</button>
                @endif --}}
        @else
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                        My requests (<span class="text-danger fw-bold">{{ $myRequests->total() }}</span>)
                                        @include('livewire.layouts.partials.inc.filter-toggle')
                                    @else
                                        Edit Request
                                    @endif

                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6>Recently uploaded</h6>
                    <div class="text-sm-end mt-1 ms-auto position-relative">
                        <a type="button" href="javascript:void()" class="btn @if (!$createNew) btn-success
                        @else
                        btn-outline-danger @endif"
                            wire:click="addnewEntry()">
                            @if (!$createNew)
                                <i class="mdi mdi-plus"></i>New
                            @else
                                <i class="mdi mdi-caret-up"></i>Close
                            @endif
                        
                        </a>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-hover table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Name <i class='mdi mdi-up-arrow-alt ms-2'></i></th>
                                    <th>Category</th>
                                    <th>Created by</th>
                                    <th>Created On</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($myRequests as $requests)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div><i class='mdi mdis-file me-2 font-24 text-primary'></i>
                                                </div>
                                                <div class="font-weight-bold text-primary">{{ $requests->title }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $requests->category->name ?? 'N/A' }}</td>
                                        <td>{{ $requests->user->name ?? 'N/A' }}</td>

                                        <th>{{ $requests->created_at ?? 'N/A' }}</th>
                                        <th>{{ $requests->status ?? 'N/A' }}</th>
                                        <td>
                                          
                                            @if ($requests->status == 'Pending')
                                                <a href="javascript:void()"
                                                    wire:click="attachDocument({{ $requests->id }})"
                                                    class="text-info"><i class='mdi mdi-pencil font-16'></i></a>
                                                    @else

                                                    <a href="{{ route('documents-request.sign', $requests->request_code) }}"
                                                        class="text-success"><i class='mdi mdi-eye font-20'></i></a>

                                            @endif

                                        </td>
                                    </tr>
                                @empty

                                    <tr>

                                        <td colspan="6" class="text-center text-danger">You have no resources
                                            uploaded in the following folder</td>

                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif




    </div>

    @push('scripts')
        <script>
            window.addEventListener('close-modal', event => {
                $('#addNewSuportDoc').modal('hide');
                $('#addNewSignatories').modal('hide');
            });
            window.addEventListener('comment-modal', event => {
                $('#comment-modal').modal('show');
            });
            window.addEventListener('lab-preview', event => {
                $('#lab-preview').modal('show');
            });
        </script>
    @endpush
</div>
