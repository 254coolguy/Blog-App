<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;

class CommentCreate extends Component
{
    public string $comment = '';

    //allow us to acces Post 
    public Post $post;

    //define model
    public ?Comment $commentModel = null;

    public function mount(Post $post, $commentModel = null)
    {
        $this->post = $post;
        $this->commentModel = $commentModel;

        $this->comment = $commentModel ? $commentModel->comment : '';
    }


    public function render()
    {
        return view('livewire.comment-create');
    }
    //creating Create comment function



    public function createComment()
    {
        $user = auth()->user();
            if (!$user) {
                return $this->redirect('login');
            }
        //editing
        if ($this->commentModel) {

            if($this->commentModel->user_id != $user->id){
                return response('You are not allowed to perform this action', status:403);
            }
            $this->commentModel->comment = $this->comment;
            $this->commentModel->save();

            $this->comment = '';
            $this->emitUp('commentUpdated');


       
        } else
         {
            
            //have look if comment is created
            $comment = Comment::create([
                'comment' => $this->comment,
                'post_id' => $this->post->id,
                'user_id' => $user->id,
            ]);

            //when comment is created, then render and display immediately

            $this->emitUp('commentCreated', $comment->id);
            //clear the input after we emiit
            $this->comment = '';
        }
    }
}
