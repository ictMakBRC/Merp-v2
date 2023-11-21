 <hr>
            <h3 class="text-center">{{ $request_data->request_type ?? 'REQUEST' }} Request: ({{ $request_data->status }})</h3>
            <table style="border-collapse:collapse;" width="100%" cellspacing="0">
                <tbody>
                    <tr class="b-top-row">
                        <td class="btop t-bold twidth">
                            Unit/Project/Acronym
                        </td>
                        <td class="btop" valign="top">
                            @if ($request_data->requestable)
                                {{ $request_data->requestable->name ?? 'N/A' }}
                            @endif
                        </td>
                    </tr>
                    @if($request_data->request_type == 'Internal Transfer')
                        <tr class="b-top-row">
                            <td class="btop t-bold twidth">
                            To  Unit/Project/Acronym
                            </td>
                            <td class="btop" valign="top">
                                @if ($request_data->to_department_id)
                                    {{ $request_data->toDepartment->name ?? 'N/A' }}
                                @elseif ($request_data->to_project_id)
                                    {{ $request_data->toProject->name ?? 'N/A' }}
                                @endif
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td class="btop t-bold twidth">
                            Request Description
                        </td>
                        <td class="btop" valign="top">
                            {{ $request_data->request_description ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="btop t-bold twidth">
                            Budget Line to charge
                        </td>
                        <td class="btop" valign="top">
                            {{ $request_data->budgetLine->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="btop t-bold twidth">
                            Total Amount Requested in Figures ({{ $request_data->currency->code ?? 'N/A' }})
                        </td>
                        <td class="btop" valign="top">
                            @moneyFormat($request_data->total_amount ?? '0')
                        </td>
                    </tr>
                    <tr class="b-bottom-row">
                        <td class="btop t-bold twidth">
                            Total Amount Requested in Words
                        </td>
                        <td class="btop" valign="top">
                            {{ $request_data->amount_in_words ?? 'N/A' }}
                        </td>
                    </tr>
                </tbody>
            </table>