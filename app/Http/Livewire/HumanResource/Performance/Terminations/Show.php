<?php

namespace App\Http\Livewire\HumanResource\Performance\Terminations;

use App\Models\Comment;
use App\Models\HumanResource\Performance\Termination;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public $termination;

    public $additional_comment;

    public $reply;

    public $shouldShowReply = false;

    public $rules = [
        'additional_comment' => 'nullable',
    ];

    public function mount(Termination $termination)
    {
        $this->termination = $termination;
    }

    public function close()
    {
    }

    public function store()
    {
        $this->validate();

        return DB::transaction(function () {
            $this->termination->update([
                'acknowledged_at' => now(),
            ]);
            if ($this->additional_comment != null) {
                $this->termination->comments()->create([
                    'content' => $this->additional_comment,
                    'user_id' => auth()->id(),
                ]);
            }

            $this->termination->fresh();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('refresh-page');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Acknowledgement  submitted!']);

            return redirect()->back();
        });
    }

    public function download()
    {
        $mediaItem = $this->termination->getFirstMedia();

        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }

    public function toggleReplyButton($currentReply)
    {
        $this->shouldShowReply = ! $this->shouldShowReply;

        return $this->shouldShowReply;
    }

    public function addReply($commentId)
    {
        $this->validate(['reply' => 'required']);

        return DB::transaction(function () use ($commentId) {
            $comment = Comment::find($commentId);
            $comment->replies()->create([
                'content' => $this->reply,
                'user_id' => auth()->id(),
            ]);

            $this->grievance->fresh();

            return redirect()->back();
        });
    }

    public function render()
    {
        $this->authorize('view', Termination::class);

        return view('livewire.human-resource.performance.terminations.show');
    }
}
