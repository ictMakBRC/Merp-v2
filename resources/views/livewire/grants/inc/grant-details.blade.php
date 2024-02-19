<div class="bg-light">
    <div class="row row-cols-2 d-flex justify-content-md-between p-2">
        <div class="col-md-6 d-print-flex">
            <div>
                <strong class="text-inverse">{{ __('Code') }}:
                </strong>{{ $grant->grant_code ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Type') }}:
                </strong>{{ $grant->grant_type ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Funding source') }}:
                </strong>{{ $grant->funding_source ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Funding amount') }}:
                </strong>{{ $grant->funding_amount ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Currency') }}:
                </strong>{{ $grant->currency->code ?? 'N/A' }}<br>

            </div>
        </div><!--end col-->
        <div class="col-md-6 d-print-flex">
            <div>
                <strong class="text-inverse">{{ __('Proposal Submission Date') }}:
                </strong>@formatDate($grant->proposal_submission_date)<br>
                <strong class="text-inverse">{{ __('Start date') }}: </strong>
                @formatDate($grant->start_date)<br>
                <strong class="text-inverse">{{ __('End date') }}: </strong>
                @formatDate($grant->end_date)<br>
                <strong class="text-inverse">{{ __('Principal Investigator') }}:
                </strong>{{ $grant->principalInvestigator->fullName ?? 'N/A' }}<br>
            </div>
        </div><!--end col-->
    </div><!--end row-->
    
    @if ($grant->proposal_summary != null)
        <table class="table">
            <tr>
                <td>
                    <p>
                        {{ $grant->proposal_summary ?? 'N/A' }}
                    </p>
                </td>
            </tr>
        </table>
    @endif

</div>
