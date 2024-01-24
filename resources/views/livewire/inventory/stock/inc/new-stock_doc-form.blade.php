<div x-cloak x-show="create_new">
    <form wire:submit.prevent="storeData" >             
        @include('layouts.messages')
            <div class="row">          
                <div class="mb-3 col-md-3  col-sm-3">
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
                  <div class="mb-3 col-md-4">
                    <label for="unit_id" class="form-label" required>Unit</label>
                    <select class="form-select" wire:model.defer="unit_id" required>
        
                      <option value="">Select...</option>
                      @foreach ($units as $key => $value)
                      <option value="{{$value->id}}">{{$value->name}}</option>
                      @endforeach
                    </select>
                    @error('unit_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                  </div>
                <div class="mb-3 col-3">
                    <label for="date_added" class="form-label required">Date Added</label>
                    <input type="date" id="date_added" max="{{ $todayDate }}"  class="form-control" name="date_added" required
                        wire:model="date_added">
                    @error('date_added')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div> 

                <div class="mb-3 mt-4 col-2 ms-auto">
                    <x-button class="btn btn-success">Proceed</x-button>
                </div>
            </div>
            </form>
        </form>
    <hr>
</div>
