<div class="col-lg-12 pt-1">
    <div class="card">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col">
                    <p class="text-dark fw-semibold mb-0">Comments ({{$appraisal->comments->count()}})</p>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end card-body-->
        <div class="card-body border-bottom-dashed">
            <ul class="list-unstyled mb-0">
                @forelse($appraisal->comments as $comment)
                @livewire('human-resource.performance.appraisals.comment', ['comment' => $comment])
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
            <form wire:submit.prevent="store">
                <div class="form-group mb-3">
                    <textarea class="form-control" wire:model="additional_comment" rows="5" id="leave_comment"
                        placeholder="Message"></textarea>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-end">
                        <button type="submit" class="btn btn-de-primary px-4">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
        <!--end card-body-->
    </div>
</div>