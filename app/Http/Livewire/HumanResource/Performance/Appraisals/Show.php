<?php

namespace App\Http\Livewire\HumanResource\Performance\Appraisals;

use App\Models\Comment;
use App\Models\HumanResource\Performance\Appraisal;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public $appraisal;

    public $additional_comment;

    public $reply;

    public $shouldShowReply = false;

    public $rules = [
        'additional_comment' => 'nullable',
    ];

    public function mount(Appraisal $appraisal)
    {
        $this->appraisal = $appraisal;
    }

    public function close()
    {
    }

    public function store()
    {
        $this->validate();

        $this->appraisal->update([
            'acknowledged_at' => now(),
        ]);
        if ($this->additional_comment != null) {
            $this->appraisal->comments()->create([
                'content' => $this->additional_comment,
                'user_id' => auth()->id(),
            ]);
        }
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Acknowledgement  submitted!']);
        $this->dispatchBrowserEvent('refresh-page');

        return redirect()->back();

    }

    public function download()
    {
        $mediaItem = $this->appraisal->getFirstMedia();

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
        $this->authorize('view', Appraisal::class);

        return view('livewire.human-resource.performance.appraisals.show');
    }
}
