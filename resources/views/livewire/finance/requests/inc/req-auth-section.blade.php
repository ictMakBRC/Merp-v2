 <div class="authorization">
    <h4>Authorization: </h4>
    <form wire:submit.prevent='addSignatory({{ $request_data->id }})'>
        <div class=" add-input">
            <div class="row">
                <div class="col-2 mb-1">
                    <div class="form-group">
                        <label for="title" class="form-label">Level</label>
                        <input readonly type="number"class="form-control" id="signatory_level" wire:model.lazy="signatory_level" placeholder="Enter level ">
                        @error('signatory_level') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4 mb-1">
                    <div class="form-group">
                        <label for="title" class="form-label">Position/Office
                        @if ($position_exists)<small class="text-danger"> This position already exists on this document</small>@endif</label>
                        <select name="position" class="form-control form-select" id="position" wire:model.lazy="position">
                            <option value="">Select...</option>
                            @forelse ($positions as $uposition)
                                <option value="{{$uposition->id}}">{{$uposition->name}}</option>
                            @empty
                                <option value="">No info</option>
                            @endforelse
                        </select>
                        @error('position') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4 mb-1">
                    <div class="form-group">
                        <label for="title" class="form-label">Signatory</label>
                        <select name="approver_id" class="form-control form-select" id="approver_id" wire:model.lazy="approver_id">
                            <option value="">Select...</option>
                            @forelse ($signatories as $user)
                                <option value="{{$user->id}}">{{$user->employee->fullName??$user->name}}</option>
                            @empty
                                <option value="">No user</option>
                            @endforelse
                        </select>
                        @error('approver_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-2 mt-2">
                    <button type="submit"  class="btn text-white btn-info float-end">Add</button>
                </div>
            </div>
        </div>
    </form>
    <small><em>
        For Control Purposes, Request Description has to be retyped here
    </em></small>

    <table style="border-collapse:collapse;" width="100%" cellspacing="0">
        <thead>
            <tr class="b-top-row btop">
                <td class="btop" width="158" valign="top" >
                    Request Description
                </td>
                <td class="btop" width="480" colspan="3" valign="top" >
                    {{ $request_data->request_description ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="btop" width="158" valign="top" >
                    Position/Office
                </td>
                <td class="btop" width="198" valign="top" >
                    Name
                </td>
                <td class="btop" width="151" valign="top" >
                    Signature
                </td>
                <td class="btop" width="130" valign="top" >
                    Date
                </td>
                <td class="btop" width="10" valign="top" >
                    Action
                </td>
            </tr>
        </thead>
        <tbody>
            @forelse ($authorizations as $authorizer)
            <tr>
                <td class="btop" width="158" valign="top">
                    {{ $authorizer->authPosition->name ?? 'N/A' }}
                </td>
                <td class="btop" width="198" valign="top">
                    {{ $authorizer->approver->employee->fullName ?? $authorizer->approver->name??'N/A' }}
                </td>
                <td class="btop" width="151" valign="top">

                </td>
                <td class="btop" width="130" valign="top">

                </td>
                <td class="btop" width="66" valign="top">
                    {{-- <a href="javascriprt:void()" wire:click='deleteFile({{ $attachment->id }})'> <i class="fa fa-trash"></i></a> --}}
                </td>

            </tr>
        @empty
            <tr class="text-center text-danger">
                <td colspan="3">No data found</td>
            </tr>
        @endforelse

        </tbody>
    </table>

    <i><span lang="EN-US" style="font-size:8.0pt;">
    All persons in the approval chain must satisfy that the content in the request form is complete, accurate &amp; serves value for money </span>
    </i>
        <br>
</div>
