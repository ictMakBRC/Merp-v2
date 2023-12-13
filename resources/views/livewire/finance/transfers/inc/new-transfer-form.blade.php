<div x-cloak x-show="create_new">
    <form  @if ($toggleForm) wire:submit.prevent="updateBudget" @else wire:submit.prevent="storeBudget" @endif >             

        <div class="row">          
            
            <div class="mb-3 col-2">
                <label for="fiscal_year" class="form-label required">Fiscal year</label>
                <select id="fiscal_year" class="form-control" name="fiscal_year" required wire:model="fiscal_year">
                    <option value="">Select</option>
                    @foreach ($years as $fy)
                        <option value="{{$fy->id}}">{{$fy->name}}</option>
                    @endforeach
                </select>
                @error('fiscal_year')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div> 
            <div class="mb-3 col-2">
                <label for="fiscal_year" class="form-label required">Fiscal year</label>
                <select id="fiscal_year" class="form-control" name="fiscal_year" required wire:model="fiscal_year">
                    <option value="">Select</option>
                    @foreach ($years as $fy)
                        <option value="{{$fy->id}}">{{$fy->name}}</option>
                    @endforeach
                </select>
                @error('fiscal_year')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div> 
            <div class="mb-3 col-2">
                <label for="currency_id" class="form-label required">Currency</label>
                <select id="currency_id" class="form-control" name="currency_id" required wire:model="currency_id">
                    <option value="">Select</option>
                    @foreach ($currencies as $currency)
                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                    @endforeach
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div> 
            <div class="mb-3 col">
                <label for="name" class="form-label required">Name</label>
                <input type="text" id="name" onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="name" required
                    wire:model="name">
                @error('name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>            
            
            <div class="mb-3 col-md-4">
                <label for="description" class="form-label">Description</label>
                <textarea  id="description" class="form-control"
                name="description" wire:model.defer="description"></textarea>
                @error('description')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
        <hr>
    </form>
    <hr>
</div>
