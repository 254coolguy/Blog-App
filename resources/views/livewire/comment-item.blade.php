<div class="mt-6" >
    <div class="flex mb-3 gap-3">
        <div class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
              </svg>
              
        </div>
        <div class="">
            <div>
                <a href="#" class="text-indigo-600 font-bold">{{$comment->user->name}}</a>
                <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
            </div>

           @if ($editing)
           <livewire:comment-create :comment-model="$comment"/>
            
               
           @else
            <div class="text-black text-justify ">
                {{ $comment->comment }}
            </div>
               
           @endif
            
            <div class="mt-3">
                <a href="#"class="text-sm text-indigo-600 mr-3">Reply</a>
                {{-- if user is not the current owner of comment then not able to delete and edit but see commen --}}
                @if (\Illuminate\Support\Facades\Auth::id() == $comment->user_id)
                <a wire:click.prevent="startCommentEdit "href="#"class="text-sm text-blue-900 mr-3 text-semibold font-semibold">Edit</a>
                <a wire:click.prevent="deleteComment" href="#"class="text-sm text-red-600 font-semibold">Delete</a>   
                @endif
                
            </div>
        </div>     
    </div> 
</div>
