<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    {{ __('API Integration for External Applications') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content">

                        <div class="table-responsive">
                            <table class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>{{ __('public.name') }}</th>
                                        <th>{{ __('public.email_address') }}</th>
                                        <th>{{ __('Token') }}</th>
                                        <th>{{ __('public.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->fullName }}</td>
                                            <td>{{ $user->email ?? 'N/A' }}</td>
                                            <td>
                                                @if ($user->id == $user_id && $token != '')
                                                    <div class="input-group mb-3">
                                                        <input type="text" id="token" class="form-control"
                                                            wire:model.defer="token" readonly>
                                                        <button class="btn btn-outline-success" type="button"
                                                            onclick="copyText()" wire:click='resetValues()'
                                                            title="Copy Token"><i class="bx bx-clipboard"></i></button>
                                                    </div>
                                                @else
                                                    @if ($user->tokens->isEmpty())
                                                        <span class="badge bg-danger"> Revoked</span>
                                                    @else
                                                        <span class="badge bg-success"> Issued</span>
                                                    @endif
                                                @endif
                                            </td>

                                            <td>
                                                <div class="d-flex table-actions">
                                                    @if ($user->tokens->isEmpty())
                                                    <button class="text-success"  title="{{__('user-mgt.generate_token')}}">
                                                        <i class="bx bx-transfer"
                                                            wire:click="generateToken({{ $user->id }})"></i></button>
                                                    @else
                                                        <button class="text-danger" title="{{__('user-mgt.revoke_token')}}">
                                                            <i class="bx bx-x"
                                                                wire:click="revokeToken({{ $user->id }})"></i></button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $users->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    @push('scripts')
        <script>
            function copyText() {
                /* Get the text field */
                var copyText = document.getElementById("token");

                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /* For mobile devices */

                /* Copy the text inside the text field */
                document.execCommand("copy");

                /* Alert the copied text */
                alert("Copied: " + copyText.value);
            }
        </script>
    @endpush
</div>
