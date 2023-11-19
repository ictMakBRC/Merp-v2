<div>
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
                            <td>
                                <a href="{{ route('finance-unit_lines',[$project->id, 'project']) }}" class="action-ico btn-sm btn btn-outline-success mx-1" title="budget-lines"><i class="fas fa-briefcase"></i></a>
                                <a href="{{ route('finance-dashboard_unit',[$project->id, 'project']) }}" class="action-ico btn-sm btn btn-outline-success mx-1" title="dashboard"><i class="fa fa-home"></i></a>
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
    
</div>

