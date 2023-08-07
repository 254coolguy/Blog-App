@php

// Annotating for links so as to acces the onEachSide() method to format our pagination
/** @var $posts \Illuminate\Pagination\LengthAwarePaginator */
@endphp


<x-app-layout meta-description="Brian Blog about nature and events as they happen">

    <div class="container max-w-5xl mx-auto  py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Latest Post --}}
            <div class="col-span-2 ">
                <h2 class="text-lg sm:test-xl font-blue text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                    Latest post</h2>
                <div>
                    <x-post-item :post="$latestPost" />
                </div>


            </div>
            {{-- Popular 3 post --}}
            <div class="">
                <h2 class="text-lg sm:test-xl font-blue text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                    Popular post</h2>
                @foreach ($popularPosts as $post)
                <div class="  py-4 grid grid-cols-4 gap-2">
                    <a href="{{ route('view', $post) }}">
                        <img src="{{ $post->getThumbnail() }}" alt="" class="pt-2" />
                    </a>
                    <div class="col-span-3">
                        <a href="{{ route('view', $post) }}">
                            <h3 class=" font-bold uppercase">{{ $post->title }}</h3>
                        </a>
                        <div class="flex gap-4">
                            {{-- itarate over categories --}}
                            @foreach ($post->categories as $category)

                            <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4">{{ $category->title
                                }}</a>

                            @endforeach
                        </div>
                        <a href="{{ route('view', $post) }}"
                            class="uppercase text-gray-700 hover:text-blue-500">Continue Reading <i
                                class="fas fa-arrow-right"></i></a>

                    </div>


                </div>



                @endforeach





            </div>
        </div>
        {{-- recommended Post --}}
        <div class="mb-4">
            <h2 class="text-lg sm:test-xl font-blue text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">
                Recommended</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach ($recommendedPosts as $post)
                <x-post-item :post="$post" :show-author="false" />

                @endforeach
            </div>



        </div>
        {{-- latest categories --}}
        <div>
            <h2 class="text-lg sm:text-xl font-blue text-blue-500 uppercase pb-1 border-b-2 border-blue-500 mb-3">Recent
                categories post</h2>
        
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach ($categories as $category)
                <div class="border border-gray-300 rounded p-4">
                    <a href="{{ route('by-category', $category) }}"><h3 class="mb-3 font-bold text-center">{{ $category->title }}</h3></a>
                    
                    @foreach ($category->publishedPosts->take(1) as $post)
                    <div class="mb-3">
                        <x-post-item :post="$post" :show-author="false" :post="$post" :show-shadow="false" />
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
        
        
        
         
        

    </div>


</x-app-layout>