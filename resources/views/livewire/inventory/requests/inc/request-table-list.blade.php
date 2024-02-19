<div class="table-responsive">
    <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>Invice No.</th>
                <th>Unit</th>
                <th>Created By</th>
                <th>Submitted On</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $key => $request)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $request->request_code }}</td>
                    <td>{{ $request->unitable->name ?? 'N/A' }}</td>
                    <td>{{ $request->createdBy->name ?? 'N/A' }}</td>
                    <td>{{ $request->date_added }}</td>
                    <td><x-status-badge :status="$request->status" /></td>
                    <td class="table-action">
                        @if ($request->status == 'Pending')
                            <a href="{{ URL::signedRoute('inventory-request_items', $request->request_code??'N/A') }}"
                                class="action-ico btn-sm btn btn-outline-success mx-1"><i class="fa fa-edit"></i></a>
                        @else
                            <a href="{{ URL::signedRoute('inventory-request_view', $request->request_code??'N/A') }}"
                                class="action-ico btn-sm btn btn-outline-success mx-1"><i class="fa fa-eye"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> <!-- end preview-->