 <div class="attachments">

    <div class="header">
        <h6>Attachment Summary and References <span class="text-end float-end text-warning">Total =
                {{ $attachments->count() }}</span></h6>
    </div>

    <form wire:submit.prevent="saveAttachment({{ $request_data->id }})">
        <div class="row">
            <div class="col-md-3">
                <label for="name">Attachment Type/Name:</label>
                <input type="text" class="form-control" id="expenditure" wire:model="name">
                @error('name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="v">Reference Number:</label>
                <input type="text" id="reference" required class="form-control"
                    wire:model="reference">
                @error('reference')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-3">
                <label for="file">File</label>
                <input type="file" step='any' id="file_{{ $iteration }}" required class="form-control" wire:model="file">
                @error('file')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-2 pt-3 text-end">
                <button class="btn btn-primary" type="submit">Add</button>
            </div>
        </div>
    </form>
    <br>

    <table style="border-collapse:collapse;" width="100%" cellspacing="0">
        <thead>
            <tr class="b-top-row" style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:15.75pt">
                <td class="btop t-bold" width="149" rowspan="2" valign="top">
                    Attachment Type/Name
                </td>
                <td class="btop t-bold" width="189" rowspan="2" valign="top">
                    Reference Number (IfAny)
                </td>
                <td class="btop t-bold" width="66" rowspan="2" valign="top">
                    Action
                </td>
            </tr>
        </thead>
            <tbody>
            @forelse ($attachments as $attachment)
                <tr>
                    <td class="btop" width="149">
                        {{ $attachment->name ?? 'N/A' }}
                    </td>
                    <td class="btop" width="189" valign="top">
                        {{ $attachment->reference ?? 'N/A' }}
                    </td>
                    <td class="btop" width="66" valign="top">
                        @if ($attachment->file == null && $request_data->invoice_id)
                            <a target="_blank" href="{{URL::signedRoute('finance-invoice_view', $attachment->reference)}}" class="action-ico  mx-1"><i class="fa fa-eye"></i></a>

                        @else
                        <a href="javascriprt:void()" wire:click='downloadAttachment({{ $attachment->id }})'> <i class="fa fa-download"></i></a>
                        <a href="javascriprt:void()" wire:click='deleteFile({{ $attachment->id }})'> <i class="fa fa-trash"></i></a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="text-center text-danger">
                    <td colspan="3">No Attachments found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
