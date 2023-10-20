<?php

namespace App\Http\Livewire\Comments;

use App\Models\Comment as GComment;
use Livewire\Component;

class Show extends Component
{
    public $comment;

    public $additional_comment;

    public $reply;

    public $currentReply = null;

    public $shouldShowReply = false;

    public $shouldShowComment = false;

    public $shouldUpdate = false;

    public $rules = [
        'additional_comment' => 'nullable',
    ];

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function toggleReplyButton($currentReply)
    {
        $this->shouldShowReply = ! $this->shouldShowReply;

        return $this->shouldShowReply;
    }

    public function editReply(GComment $reply)
    {
        $this->shouldShowReply = ! $this->shouldShowReply;
        $this->shouldUpdate = true;
        $this->reply = $reply->content;
        $this->currentReply = $reply;
    }

    public function selectComment()
    {
        $this->emitUp('commentSelected', $this->comment->id);
    }

    public function selectReply(GComment $reply)
    {
        $this->currentReply = $reply;
    }

    public function deleteReply()
    {
        $this->currentReply->delete();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Reply  deleted!']);
        $this->comment->refresh();

    }

    public function close()
    {
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteComment()
    {
        $this->comment->delete();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Reply  deleted!']);
        $this->dispatchBrowserEvent('refresh-page');
    }

    public function submitReply($commentId)
    {
        $this->validate(['reply' => 'required']);

        $comment = GComment::find($commentId);

        if ($this->shouldUpdate == true) {
            $this->currentReply->update([
                'content' => $this->reply,
            ]);
            $this->shouldUpdate = false;
            $this->reply = '';
            $this->currentReply = null;
            $this->comment = $comment;
            $this->shouldShowReply = false;
        } else {
            $comment->replies()->create([
                'content' => $this->reply,
                'user_id' => auth()->id(),
            ]);
            $this->shouldUpdate = false;
            $this->reply = '';
            $this->currentReply = null;
            $this->comment = $comment;
            $this->shouldShowReply = false;
        }

        $this->dispatchBrowserEvent('refresh-page');

        return redirect()->back();

    }

    public function render()
    {
        return view('livewire.comments.show');
    }
}
