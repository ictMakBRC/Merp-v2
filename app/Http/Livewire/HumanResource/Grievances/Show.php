<?php

namespace App\Http\Livewire\HumanResource\Grievances;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Models\HumanResource\Grievance;
use App\Models\HumanResource\GrievanceType;

class Show extends Component
{
    public $grievance;

    public $additional_comment;

    public $reply;

    public $shouldShowReply = false;

    public $rules = [
        'additional_comment' => 'nullable'
    ];


    public function mount(Grievance $grievance)
    {
        $this->grievance = $grievance;
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
        return view('livewire.human-resource.grievances.show');
    }
}
