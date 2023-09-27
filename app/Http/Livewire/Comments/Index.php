<?php

namespace App\Http\Livewire\Comments;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $comments;

    public $selectedComment;

    public $commentable;

    public $additional_comment = '';

    public $shouldUpdate = false;

    protected $listeners = ['commentSelected'];

    public $rules = [
        'additional_comment' => 'required'
    ];

    public function mount($commentable){
        $this->commentable = $commentable;
        $this->comments = $commentable->comments;
    }

    public function commentSelected(Comment $comment)
    {
        $this->selectedComment = $comment;
        $this->additional_comment = $this->selectedComment->content;
        $this->shouldUpdate = true;
    }

    public function store()
    {
        $this->validate([
            'additional_comment' => 'required'
        ]);

        if($this->shouldUpdate == false) {
            $this->commentable->comments()->create([
                'content' => $this->additional_comment,
                'user_id' => auth()->id(),
            ]);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Comment  added!']);

        } else {
            $this->selectedComment->update([
                'content' => $this->additional_comment,
            ]);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Comment  updated!']);

        }
        $this->shouldUpdate = false;
        $this->additional_comment = '';
        $this->comments = $this->commentable->comments;
        $this->dispatchBrowserEvent('refresh-page');
    }


    public function render()
    {
        return view('livewire.comments.index');
    }
}
