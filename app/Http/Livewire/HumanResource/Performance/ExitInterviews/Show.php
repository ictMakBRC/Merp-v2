<?php

namespace App\Http\Livewire\HumanResource\Performance\ExitInterviews;

use App\Models\Comment;
use App\Models\HumanResource\Performance\ExitInterview;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public $exitInterview;

    public $additional_comment;

    public $reply;

    public $shouldShowReply = false;

    public $rules = [
        'additional_comment' => 'nullable',
    ];

    public function mount(ExitInterview $exitInterview)
    {
        $this->exitInterview = $exitInterview;
    }

    public function close()
    {
    }

    public function store()
    {
        $this->validate();

        return DB::transaction(function () {
            $this->exitInterview->update([
                'acknowledged_at' => now(),
            ]);
            if ($this->additional_comment != null) {
                $this->exitInterview->comments()->create([
                    'content' => $this->additional_comment,
                    'user_id' => auth()->id(),
                ]);
            }

            $this->exitInterview->fresh();

            return redirect()->back();
        });
    }

    public function download()
    {
        $mediaItem = $this->exitInterview->getFirstMedia();

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

            $this->exitInterview->fresh();

            return redirect()->back();
        });
    }

    public function render()
    {
        $this->authorize('view', ExitInterview::class);

        return view('livewire.human-resource.performance.exit-interviews.show');
    }
}
