<button class="btn btn-outline-primary  btn-sm me-2" wire:click="$set('filter',{{ !$filter }})"><i
        class="fas fa-filter @if ($filter)  @endif"></i></button>