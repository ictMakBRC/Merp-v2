<div class="bg-light">
    <div class="row row-cols-2 d-flex justify-content-md-between p-2">
        <div class="col-md-6 d-print-flex">
            <div>
                <strong class="text-inverse">{{ __('Parent Department') }}:
                </strong>{{ $department->parent->name ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Type') }}:
                </strong>{{ $department->type ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Prefix') }}:
                </strong>{{ $department->prefix ?? 'N/A' }}<br>
            </div>
        </div><!--end col-->
        <div class="col-md-6 d-print-flex">
            <div>
                <strong class="text-inverse">{{ __('Supervisor') }}:
                </strong>{{ $department->dept_supervisor->fullName }}<br>
                <strong class="text-inverse">{{ __('Assistant Supervisor') }}:
                </strong>{{ $department->ast_supervisor->fullName }} <br>
            </div>
        </div><!--end col-->
    </div><!--end row-->
    
    @if ($department->description != null)
        <table class="table">
            <tr>
                <td>
                    <p>
                        {{ $department->description ?? 'N/A' }}
                    </p>
                </td>
            </tr>
        </table>
    @endif

</div>
