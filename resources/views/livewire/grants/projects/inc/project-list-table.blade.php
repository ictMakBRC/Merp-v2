<div class="tab-content">
    @include('livewire.grants.projects.inc.filter')

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Start Date') }}</th>
                    <th>{{ __('End Date') }}</th>
                    <th>{{ __('Principal Investigator') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('public.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $key=>$project)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$project->project_code}}</td>
                        <td>{{$project->project_category}}</td>
                        <td>{{$project->project_type}}</td>
                        <td>@formatDate($project->start_date)</td>
                        <td>@formatDate($project->end_date)</td>
                        <td>{{$project->principalInvestigator->fullName}}</td>
                        <td>{{ ucfirst($project->progress_status)}}</td>
                        @if ($project->is_active == 0)
                        <td><span class="badge bg-danger">Suspended</span></td>
                        @else
                            <td><span class="badge bg-success">Active</span></td>
                        @endif
                        
                        <td>
                            <div class="d-flex justify-content-between">
                                    <button class="btn btn-sm btn-outline-success m-1"
                                        wire:click="loadProject({{ $project->id }})"
                                        title="{{ __('public.edit') }}">
                                        <i class="ti ti-edit fs-18"></i></button>
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
                {{-- {{ $projects->links('vendor.pagination.bootstrap-5') }} --}}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->
