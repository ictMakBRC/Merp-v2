<div class="mb-3 col col-12 col-md-4  col-sm-3">
    <label for="entry_type" class="form-label required">Entry Unit Type</label>
    <select class="form-control form-select" id="entry_type" wire:model='entry_type'>
        <option selected value="">Select</option>
        <option value="Department">Department</option>
        <option value="Project">Project</option>
    </select>
    @error('entry_type')
        <div class="text-danger text-small">{{ $message }}</div>
    @enderror
</div>
@if ($entry_type == 'Project')
<div class="mb-3 col col-12 col-md-4  col-sm-3">
        <label for="project_id" class="form-label required">Project</label>
        <select class="select2 form-select" id="project_id" wire:model='project_id'>
            <option value="">Select</option>
            @foreach ($projects as $project)
                <option value='{{ $project->id }}'>{{ $project->name }}</option>
            @endforeach
        </select>
        @error('project_id')
            <div class="text-danger text-small">{{ $message }}</div>
        @enderror
    </div>
@elseif($entry_type =='Department')
<div class="mb-3 col col-12 col-md-4  col-sm-3">
        <label for="department_id" class="form-label required">Department</label>
        <select class="select2 form-select" id="department_id" wire:model='department_id'>
            <option selected value="">Select</option>
            @foreach ($departments as $department)
                <option value='{{ $department->id }}'>{{ $department->name }}</option>
            @endforeach
        </select>
        @error('department_id')
            <div class="text-danger text-small">{{ $message }}</div>
        @enderror
    </div>
@endif
@push('scripts')
    
    <script>        
        $('#project_id').on('select2:select', function(e) {
            var data = e.params.data;
            @this.set('project_id', data.id);
        });

        $('#department_id').on('select2:select', function(e) {
            var data = e.params.data;
            @this.set('department_id', data.id);
        }); 
    </script>
@endpush
