<div class="tab-content">
    @include('livewire.grants.inc.filter')

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('Code') }}</th>
                    <th>{{ __('Name') }}</th>
                    {{-- <th>{{ __('Category') }}</th>
                    <th>{{ __('Type') }}</th> --}}
                    <th>{{ __('Start Date') }}</th>
                    <th>{{ __('End Date') }}</th>
                    {{-- <th>{{ __('Principal Investigator') }}</th> --}}
                    <th>{{ __('Progress Status') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('public.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $key=>$project)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $project->project_code }}</td>
                        <td>{{ $project->name }}</td>
                        {{-- <td>{{ $project->project_type }}</td> --}}
                        <td>@formatDate($project->start_date)</td>
                        <td>@formatDate($project->end_date)</td>
                        {{-- <td>{{ $project->principalInvestigator?->fullName??'N/A' }}</td> --}}
                        <td><span class="badge bg-info">{{ ucfirst($project->progress_status) }}</span></td>
                        @if ($project->start_date > today())
                        <td><span class="badge bg-info">Coming soon...</span>
                            
                        </td>
                        @elseif ($project->end_date >= today())
                            <td><span class="badge bg-success">Running</span>
                                @if ($project->days_to_expire >= 0)
                                    + ({{ $project->days_to_expire }}) days
                                @else
                                @endif
                            </td>
                        @else
                            <td><span class="badge bg-danger">Ended</span></td>
                        @endif

                        <td>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('project-profile', $project->id) }}"
                                    class="btn btn-sm btn-outline-primary m-1"> <i class="ti ti-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div> <!-- end preview-->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="btn-group float-end">
                {{ $projects->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->
