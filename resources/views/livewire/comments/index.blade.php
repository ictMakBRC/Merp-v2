<div class="col-lg-12 pt-1">
    <div class="card">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col">
                    <p class="text-dark fw-semibold mb-0">Comments ({{$comments->count()}})</p>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end card-body-->
        <div class="card-body border-bottom-dashed">
            <ul class="list-unstyled mb-0" wire:poll.keep-alive>
                @forelse($comments as $comment)
                @livewire('comments.show', ['comment' => $comment], key($comment->id))
                @empty
                <li>
                    No Comments ...
                </li>
                @endif
            </ul>
        </div>
        <!--end card-body-->
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <p class="text-dark fw-semibold mb-0">Leave a comment</p>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end card-body-->
        <div class="card-body pt-0">
            <div>
                <form wire:submit.prevent="store" class="form-group mb-3">
                    <textarea class="form-control" wire:model.defer="additional_comment" rows="5" id="leave_comment"
                        placeholder="Message"></textarea>
                    @error('additional_comment')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
            </div>
            <div class="row">
                <div class="col-sm-12 text-end">
                    <button type="submit" class="btn btn-de-primary px-4">Send
                        Messages</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        window.addEventListener('refresh-page', event => {
            window.location.reload(true);
        });
        window.addEventListener('close-modal', event => {
            $('#delete_reply_modal').modal('hide');
        });
        window.addEventListener('delete-modal', event => {
            $('#delete_reply_modal').modal('show');
        });
    </script>
    @endpush
</div>
