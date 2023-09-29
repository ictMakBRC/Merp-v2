<div class="tab-content">
    @include('livewire.grants.inc.filter')

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('Grant Code') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Start Date') }}</th>
                    <th>{{ __('End Date') }}</th>
                    <th>{{ __('Principal Investigator') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('public.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($grants as $key=>$grant)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$grant->grant_code}}</td>
                        <td>{{$grant->grant_name}}</td>
                        <td>{{$grant->grant_type}}</td>
                        <td>@formatDate($grant->start_date)</td>
                        <td>@formatDate($grant->end_date)</td>
                        <td>{{$grant->principalInvestigator->fullName}}</td>
                        <td>{{ ucfirst($grant->award_status)}}</td>
                        <td></td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div> <!-- end preview-->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="btn-group float-end">
                {{-- {{ $grants->links('vendor.pagination.bootstrap-5') }} --}}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->
