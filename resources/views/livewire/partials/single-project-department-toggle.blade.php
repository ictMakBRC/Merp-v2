<div class="mb-3 col col-12 col-md-4  col-sm-3">
    <label for="entry_type" class="form-label required">Entry Unit Type</label>
    <select disabled readonly class="form-control form-select" id="entry_type">
        <option value="Department">Department</option>
        <option value="Project">Project</option>
    </select>
    @error('entry_type')
        <div class="text-danger text-small">{{ $message }}</div>
    @enderror
</div>
<div class="col-3">
    <label for="unit" class="form-label required">Unit</label>
    <input type="text" class="form-control" id="unit" readonly
        value="{{ $requestable->name ?? 'NA' }}" id="">

    @error('department_id')
        <div class="text-danger text-small">{{ $message }}</div>
    @enderror
    @error('project_id')
        <div class="text-danger text-small">{{ $message }}</div>
    @enderror
</div>
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
