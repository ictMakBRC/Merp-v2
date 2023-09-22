<?php

namespace App\Http\Livewire\HumanResource\Grievances;

use App\Models\Comment as GComment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Comment extends Component
{
    public $comment;

    public $additional_comment;

    public $reply;

    public $currentReply;

    public $shouldShowReply = false;

    public $shouldUpdate = false;

    public $rules = [
        'additional_comment' => 'nullable'
    ];

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function store()
    {
        $this->validate();

        return DB::transaction(function () {
            $this->grievance->update([
                'acknowledged_at' => now()
            ]);
            if($this->additional_comment != null) {
                $this->grievance->comments()->create([
                    'content' => $this->additional_comment,
                    'user_id' => auth()->id(),
                ]);
            }

            $this->grievance->fresh();

            return redirect()->back();
        });
    }


    public function toggleReplyButton($currentReply)
    {
        $this->shouldShowReply = !$this->shouldShowReply;
        return $this->shouldShowReply;
    }

    public function editReply(GComment $reply)
    {
        $this->shouldShowReply = !$this->shouldShowReply;
        $this->shouldUpdate = true;
        $this->reply = $reply->content;
        $this->currentReply = $reply;
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

    public function submitReply($commentId)
    {
        $this->validate(['reply' => 'required']);

        return DB::transaction(function () use ($commentId) {
            $comment = GComment::find($commentId);

            if($this->shouldUpdate == true) {
                $this->currentReply->update([
                    'content' => $this->reply
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

            return redirect()->back();
        });
    }

    public function render()
    {
        return view('livewire.human-resource.grievances.comment');
    }
}
