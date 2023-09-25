<li>
    <div class="row mt-3">
        <div class="col-auto">
            <img src="{{asset('assets/images/users/user-vector.png')}}" alt="profile-user"
                class="rounded-circle me-2 thumb-sm">
        </div>
        <!--end col-->
        <div class="col">
            <div class="comment-body ms-n2 bg-light-alt p-3">
                <div class="row">
                    <div class="col">
                        <p class="text-dark fw-semibold mb-2">{{$comment->owner?->full_name}}</p>
                    </div>
                    <!--end col-->
                    <div class="col-auto">
                        <span class="text-muted"><i
                                class="far fa-clock me-1"></i>{{$comment->created_at->diffForHumans()}}</span>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
                <p>
                    {{$comment->content}}
                </p>
                <btn wire:click="selectComment" class="text-primary me-2"><i class="fas fa-pen me-1"></i>Edit</btn>
                <btn class="text-danger me-2" data-bs-toggle="modal" data-bs-target="#delete_comment_modal"><i
                        class="fas fa-trash me-1"></i>Delete</btn>
                <a wire:click.defer="toggleReplyButton({{$comment->id}})" class="text-primary"><i
                        class="fas fa-reply me-1"></i>Reply</a>
            </div>
        </div>
        <!--end col-->
    </div>

    <!--end row-->
    <ul class="list-unstyled ms-5">
        <li>
            @foreach ($comment->replies as $reply)
            <div class="row mt-3">
                <div class="col-auto">
                    <img src="{{asset('assets/images/users/user-vector.png')}}" alt="profile-user"
                        class="rounded-circle me-2 thumb-sm">
                </div>
                <!--end col-->
                <div class="col">
                    <div class="comment-body ms-n2 bg-light-alt p-3">
                        <div class="row">
                            <div class="col">
                                <p class="text-dark fw-semibold mb-2">{{$comment->owner->full_name?? 'Anonymous'}}
                                </p>
                            </div>
                            <!--end col-->
                            <div class="col-auto">
                                <span class="text-muted"><i
                                        class="far fa-clock me-1"></i>{{$comment->created_at->diffForHumans()}}</span>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                        <p>{{$reply->content}}
                        </p>
                        <btn wire:click="editReply({{$reply->id}})" class="text-primary me-2"><i
                                class="fas fa-pen me-1"></i>Edit</btn>
                        <btn class="text-danger" data-bs-toggle="modal" wire:click="selectReply({{$reply->id}})"
                            data-bs-target="#delete_reply_modal"><i class="fas fa-trash me-1"></i>Delete</btn>
                    </div>
                </div>
                <!--end col-->
            </div>
            @endforeach
            @if($shouldShowReply == true)
            <div class="row">
                <div class="col-12">
                    <div class="card-body mt-1">
                        <form wire:submit.prevent="submitReply({{$comment->id}})">
                            <div class="form-group mb-3">
                                <textarea class="form-control" wire:model.defer="reply" rows="5" id="leave_comment"
                                    placeholder="Reply"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-end">
                                    <button type="submit" class="btn btn-de-primary px-4">Send
                                        Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <!--end row-->
        </li>
    </ul>

    {{-- delete reply modal --}}
    <div wire:ignore.self class="modal fade" id="delete_reply_modal" tabindex="-1" role="dialog"
        aria-labelledby="replyModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title m-0" id="replyModalTitle">
                        Confirm Deletion
                    </h6>
                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                        aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body">
                    <div class="row">
                        Are you sure you want to delete this reply?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal" wire:click="close()">{{
                        __('public.close') }}</button>

                    <x-button type="click" wire:click="deleteReply" class="btn-danger btn-sm">Confirm
                    </x-button>

                </div>
                <!--end modal-footer-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>

    {{-- delete comment odal --}}
    <div wire:ignore.self class="modal fade" id="delete_comment_modal" tabindex="-1" role="dialog"
        aria-labelledby="modalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title m-0" id="modalTitle">
                        Confirm Deletion
                    </h6>
                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()"
                        aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body">
                    <div class="row">
                        Are you sure you want to delete this reply?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal" wire:click="close()">{{
                        __('public.close') }}</button>

                    <x-button type="click" wire:click="deleteComment" class="btn-danger btn-sm">Confirm
                    </x-button>

                </div>
                <!--end modal-footer-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
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
</li>
