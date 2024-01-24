<div class="bg-light">
    <div class="row row-cols-2 d-flex justify-content-md-between p-2">
        <div class="col-md-6 d-print-flex">
            <div>
                <strong class="text-inverse">{{ __('Code') }}:
                </strong>{{ $project->project_code ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Type') }}:
                </strong>{{ $project->project_type ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Category') }}:
                </strong>{{ $project->project_category ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Funding source') }}:
                </strong>{{ $project->funding_source ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Funding amount') }}:
                </strong>{{ $project->funding_amount ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Currency') }}:
                </strong>{{ $project->currency->code ?? 'N/A' }}<br>

            </div>
        </div><!--end col-->
        <div class="col-md-6 d-print-flex">
            <div>
                <strong class="text-inverse">{{ __('Start date') }}: </strong>
                @formatDate($project->start_date)<br>
                <strong class="text-inverse">{{ __('End date') }}: </strong>
                @formatDate($project->end_date)<br>
                <strong class="text-inverse">{{ __('Principal Investigator') }}:
                </strong>{{ $project->principalInvestigator?->fullName ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Co-Ordinator') }}:
                </strong>{{ $project->coordinator?->fullName??'N/A' }} <br>
            </div>
        </div><!--end col-->
    </div><!--end row-->
    
    @if ($project->project_summary != null)
        <table class="table">
            <tr>
                <td>
                    <p>
                        {{ $project->project_summary ?? 'N/A' }}
                    </p>
                </td>
            </tr>
        </table>
    @endif

</div>
