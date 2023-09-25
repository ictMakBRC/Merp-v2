<li>
    <div class="row">
        <div class="col-auto">
            <img src="{{asset('assets/images/users/user-vector.png')}}" alt="profile-user"
                class="rounded-circle me-2 thumb-sm">
        </div>
        <!--end col-->
        <div class="col">
            <div class="comment-body ms-n2 bg-light-alt p-3">
                <div class="row">
                    <div class="col">
                        <p class="text-dark fw-semibold mb-2">Martin Luther</p>
                    </div>
                    <!--end col-->
                    <div class="col-auto">
                        <span class="text-muted"><i class="far fa-clock me-1"></i>30 min ago</span>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
                <p>
                    {{$comment->content}}
                </p>
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
                                <p class="text-dark fw-semibold mb-2">{{auth()->user()->full_name}}</p>
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
                    </div>
                </div>
                <!--end col-->
            </div>
            @endforeach
            @if($shouldShowReply == true)
            <div class="row">
                <div class="col-12">
                    <div class="card-body pt-0">
                        <form wire:submit.prevent="addReply({{$comment->id}})">
                            <div class="form-group mb-3">
                                <textarea class="form-control" wire:model="reply" rows="5" id="leave_comment"
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
</li>