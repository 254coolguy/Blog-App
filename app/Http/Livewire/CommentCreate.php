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

    public function mount(Post $post)
    {
        $this->post = $post;
    }


    public function render()
    {
        return view('livewire.comment-create');
    }
    //creating Create comment function


    
     public function createComment(){
        $user = auth()->user();
        if(!$user){
        return $this->redirect('login');
    }
    //have look if comment is created
        $comment = Comment::create([
            'comment' => $this->comment,
            'post_id' => $this->post->id,
            'user_id' => $user->id,
        ]);

        //when comment is created, then render and display immediately

        $this->emitUp('commentCreated', $comment->id);
        //clear the inpt after we emiit
        $this->comment = '';
       
        
     }
}
