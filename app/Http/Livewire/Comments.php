<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Comments extends Component
{
    //making comments publicly available to blade
    public  $comments;

    //allow us to have access to Post
    public Post $post;

    //event listener for when code is created
    protected $listeners =[
        'commentCreated' => 'commentCreated'
    ];

    public function mount(Post $post)
    {
        $this->post = $post;

        $this->comments=Comment::where('post_id', '=', $this->post->id)->orderByDesc('created_at')->get();
    }

    
    public function render()
    {
        

        return view('livewire.comments');
    }

    public function commentCreated(int $id)
    {
        $comment = Comment::where('id', '=', $id)->first();
        $this->comments = $this->comments->prepend($comment);
        

    }
}
