<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Purchase Order (LPO)</title>
    <style>
        /* General styles */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        h5,
        h4 {
            font-weight: bold;
        }

        p {
            margin: 0;
        }

        strong {
            color: #dc3545;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            word-wrap: break-word;
        }

        th {
            background-color: #eee;
            word-wrap: break-word;
        }

        /* Specific styles */
        .text-start {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .border-bottom {
            border-bottom: 2px solid #ccc;
        }

        .mt-2 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .card-header {
            background-color: #f8f9fa;
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }


        .card-header .row {
            align-items: center;
        }

        .card-title {
            margin-bottom: 0;
        }

        .table-striped>tbody>tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .text-inverse {
            color: #100c0c;
            /* background-color: #fff; */
            padding: 5px 10px;
        }

        .headerTable {
            border-collapse: collapse;
            border-spacing: 0;
            margin-left: 5.5566pt;
            width: 100%;

            td,
            th {
                border: none;
                word-wrap: break-word;
            }
        }
    </style>
</head>

<body>
    <div class="container">
       

        {{-- <div class="row">
            <div class="col-md-12">
                --}}

                <div class="tab-content">
                    <div class="table-responsive">
                        <table class="headerTable table table-striped mb-0 w-100">
                            <tbody>
                                <tr>
                                    <td style="width: 10%">
                                        <img src="http://merp.brc.online/images/logos/brc.png" alt="mak logo" type="image/svg+xml"
                                            width="120px" alt="SVG Image">
                                    </td>
                
                                    <td class="text-center">
                                        <div style="width: 100%">
                                            <h4 style="text-indent: 0pt;text-align: center;" class="t-bold text-upper"><a
                                                    name="bookmark0">
                                                    {{ $organizationInfo->facility_name }}</a></h4>
                                            <p style="text-align: center;">{{ $organizationInfo->address2 ?? 'N/A' }}
                                                <span> || {{ $organizationInfo->physical_address }}</span> <br>
                                                <span><strong>Tel:</strong> {{ $organizationInfo->contact ?? 'N/A' }}
                                                </span>
                                                ||
                                                <span><strong>Email:</strong> {{ $organizationInfo->email ?? 'N/A' }}</span>
                                                ||
                                                <span><strong>Web:</strong> {{ $organizationInfo->website ?? 'N/A' }}</span>
                                            </p>
                                        </div>
                                    </td>
                                    <td style="width: 10%">
                                        <img src="http://merp.brc.online/images/logos/mak.png" alt="BRC logo" type="image/svg+xml"
                                            width="120px" alt="SVG Image">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="headerTable table table-striped mb-0 w-100">
                            <thead>
                                <tr>
                                    <th>To: {{ $provider->name }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-start">
                                        <strong class="text-inverse">{{ __('Address') }}:
                                        </strong>{{ $provider->full_address ?? 'N/A' }}<br>
                                        <strong class="text-inverse">{{ __('Email') }}:
                                        </strong>{{$provider->email}}<br>
                                        <strong class="text-inverse">{{ __('Contact') }}:
                                        </strong>{{ $provider->phone_number }}<br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="headerTable table table-striped mb-0 w-100">
                            <thead>
                                <tr>
                                    <th>
                                        <h4 class="card-title">{{ __('REQUEST FOR QUOTATION (RFQ)') }}</h4>
                                    </th>
                                    <th>
                                        <h4 class="card-title">Serial No. <strong
                                                class="text-danger">{{ $request->lpo_no }}</strong>
                                        </h4>
                                    </th>
                                    <th>
                                        <h4 class="card-title">Reference #<strong
                                                class="text-danger">{{ $request->reference_no }}</strong></h4>
                                    </th>
                                </tr>
                            </thead>
                        </table>

                        <table class="table table-striped mb-0 w-100 table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>{{ __('Item name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Unit') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Estimated Cost') }}</th>
                                    <th>{{ __('Total Cost') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($request->items as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->item_name ?? 'N/A' }}</td>
                                        <td>{!! nl2br(e($item->description)) !!}</td>
                                        <td>{{ $item->unit_of_measure }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>@moneyFormat($item->estimated_unit_cost)</td>
                                        <td>@moneyFormat($item->total_cost)</td>

                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2"><strong class="text-dange">Submit Response to:
                                        </strong>{{ $request->approvals->where('step', 'Procurement')->first()->approver->employee->email }}
                                    </td>
                                    <td colspan="1" class="text-start">Closing date: (<strong
                                            class="text-danger">@formatDate($request->bid_return_deadline)</strong>)</td>
                                    <td colspan="3" class="text-end">Total: ({{ $request->currency->code }})</td>
                                    <td><strong class="text-danger">@moneyFormat($request->items->sum('total_cost'))</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-start">
                                        <strong class="text-inverse">{{ __('Member of user Department') }}:
                                        </strong><br>
                                        <strong class="text-inverse">{{ __('Signature') }}:
                                        </strong>{{ $request->approvals->where('step', 'Department')->first()->approver->employee->signature ?? 'N/A' }}<br>
                                        <strong class="text-inverse">{{ __('Date') }}:
                                        </strong>@formatDate($request->updated_at)<br>
                                        <strong class="text-inverse">{{ __('Name') }}:
                                        </strong>{{ $request->approvals->where('step', 'Department')->first()->approver->employee->fullName }}<br>
                                        <strong class="text-inverse">{{ __('Designation') }}:
                                        </strong>{{ $request->approvals->where('step', 'Department')->first()->approver->employee->designation->name }}<br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            {{-- </div>
        </div> --}}
    </div>
</body>

</html>
