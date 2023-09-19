<?php

namespace App\Http\Livewire\HumanResource\Performance\Appraisals;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\HumanResource\Performance\Appraisal;

class Show extends Component
{
    public $appraisal;

    public $additional_comment;

    public $reply;

    public $shouldShowReply = false;

    public $rules = [
        'additional_comment' => 'nullable'
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

        return DB::transaction(function () {
            $this->appraisal->update([
                'acknowledged_at' => now()
            ]);
            if($this->additional_comment != null) {
                $this->appraisal->comments()->create([
                    'content' => $this->additional_comment,
                    'user_id' => auth()->id(),
                ]);
            }

            $this->appraisal->fresh();

            return redirect()->back();
        });
    }

    public function download()
    {
        $mediaItem =  $this->appraisal->getFirstMedia();
        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }

    public function toggleReplyButton($currentReply)
    {
        $this->shouldShowReply = !$this->shouldShowReply;
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
        return view('livewire.human-resource.performance.appraisals.show');
    }
}
