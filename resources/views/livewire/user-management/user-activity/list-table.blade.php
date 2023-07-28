<div class="tab-content">
    @if ($loading)
        <div class="text-info">
            <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                <span class='sr-only'></span>
            </div>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('user-mgt.causer') }}</th>
                    <th>{{ __('user-mgt.event') }}</th>
                    <th>{{ __('user-mgt.target') }}</th>
                    <th>{{ __('user-mgt.old_props') }}</th>
                    <th>{{ __('user-mgt.new_props') }}</th>
                    <th>{{ __('public.date_created') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $key => $log)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $log->causer?->avatar ? asset('storage/' . $log->causer?->avatar) : asset('assets/images/users/user-vector.png') }} }}"
                                    class="rounded-circle" width="44" height="44" alt="">
                                <div class="">
                                    <p class="mb-0">
                                        {{ $log->causer != null ? $log->causer->name : '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($log->event == 'created')
                                <span class="badge bg-success">{{ $log->event }}</span>
                            @elseif($log->event == 'updated')
                                <span class="badge bg-primary">{{ $log->event }}</span>
                            @elseif($log->event == 'deleted')
                                <span class="badge bg-danger">{{ $log->event }}</span>
                            @else
                                <span class="badge bg-primary">{{ $log->event }}</span>
                            @endif
                        </td>
                        <td>{{ $log->log_name . '[' . $log->subject_id . ']' }}</td>
                        <td style="white-space: normal">
                            @forelse ($log->properties as $attr => $property)
                                @if ($attr == 'old')
                                    @foreach ($property as $key => $value)
                                        <strong>{{ Str::ucfirst($key) }}: </strong>
                                        @json($value)<br>
                                    @endforeach
                                @endif
                            @empty
                                N/A
                            @endforelse
                        </td>
                        <td style="white-space: normal">
                            @if ($log->event == 'Assigned Role' || $log->event == 'Assigned Permission')
                                @json($log->properties)
                            @else
                                @forelse ($log->properties as $attr2 => $property)
                                    @if ($attr2 == 'attributes')
                                        @foreach ($property as $key => $value)
                                            <strong>{{ Str::ucfirst($key) }}: </strong>
                                            @json($value)
                                            <br>
                                        @endforeach
                                    @endif
                                @empty
                                    N/A
                                @endforelse
                            @endif

                        </td>
                        <td style="white-space: normal">
                            @formatDateTime($log->created_at)
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div> <!-- end preview-->
</div> <!-- end tab-content-->
