<?php

namespace App\Http\Livewire\HumanResource\Performance\Resignations;

use App\Models\Comment;
use App\Models\HumanResource\Performance\Resignation;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Show extends Component
{
    public $resignation;

    public $additional_comment;

    public $reply;

    public $shouldShowReply = false;

    public $rules = [
        'additional_comment' => 'nullable'
    ];


    public function mount(Resignation $resignation)
    {
        $this->resignation = $resignation;
    }

    public function close()
    {
    }

    public function store()
    {
        $this->validate();

        return DB::transaction(function () {
            $this->resignation->update([
                'acknowledged_at' => now()
            ]);
            if($this->additional_comment != null) {
                $this->resignation->comments()->create([
                    'content' => $this->additional_comment,
                    'user_id' => auth()->id(),
                ]);
            }

            $this->resignation->fresh();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('refresh-page');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Acknowledgement  submitted!']);


            return redirect()->back();
        });
    }

    public function download()
    {
        $mediaItem =  $this->resignation->getFirstMedia();
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


            $this->resignation->fresh();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('refresh-page');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Acknowledgement  submitted!']);


            return redirect()->back();
        });
    }

    public function render()
    {
        return view('livewire.human-resource.performance.resignations.show');
    }
}
