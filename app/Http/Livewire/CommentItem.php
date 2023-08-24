<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentItem extends Component
{
    //access to comment from database
    public Comment $comment;

    public bool $editing = false;
    

    protected $listeners = [
        'cancelEditing' => 'cancelEditing',
        'commentUpdated' => 'commentUpdated'
    ];


    public function mount(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function render()
    {
        return view('livewire.comment-item');
    }
    //delete comment
    public function deleteComment()
    {


        //check if it is authorized user performing this action
        $user = auth()->user();
        if (!$user) {
            return $this->redirect('login');
        }

        if ($this->comment->user_id != $user->id) {
            return response('You are not allowed to perform this action', status: 403);
        }
        $id = $this->comment->id;
        $this->comment->delete();
        $this->emitUp('commentDeleted', $id);
    }

    public function startCommentEdit()
    {
        $this->editing = true;
    }

    public function cancelEditing()
    {
        $this->editing = false;
    }
    public function commentUpdated()
    {
        $this->editing = false;
    }
}
