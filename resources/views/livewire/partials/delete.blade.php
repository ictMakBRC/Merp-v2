
@if ($confirmingDelete)
<div class="modal-backdrop fade show"></div>
<div class="modal d-block">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to delete this budget item?
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" wire:click="$set('confirmingDelete', false)">Cancel</button>
                <button class="btn btn-warning" wire:click="deleteBudget">Delete</button>
            </div>
        </div>
    </div>
</div>
@endif