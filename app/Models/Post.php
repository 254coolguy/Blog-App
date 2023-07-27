<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'thumbnail','body','active','published_at', 'user_id', 'meta_title', 'meta_description'];

    //creating protected cast so that for this instance published_at is no longer a string
    protected $casts =[
        'published_at' => 'datetime'
    ];
    //creating relationship manytoone,
    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }

     //creating relationship manytomany  
    public function categories(): BelongsToMany
    {
        return $this->BelongsToMany(related: Category::class);
    }
    //shortbody function
    public function shortBody(): string
    {
        return Str::words(strip_tags($this->body), words:30);
    }
    //function to format date
    public function getFormattedDate(){
        //dd($this->published_at);
        return $this->published_at->format('F jS Y');

    }

    //function which check if url of faker thumbnail start with http
    public function getThumbnail(){
        if(str_starts_with($this->thumbnail, 'http')){
            return $this->thumbnail;
        }
        return '/storage/' . $this->thumbnail;
    }
}
