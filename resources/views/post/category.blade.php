@php
/** @var \Illuminate\Pagination\LengthAwarePaginator $posts */
@endphp


<x-app-layout :meta-title="'The Brans Blog - Posts by category' . $category->title" meta-description="Brian Blog about nature and events as they happen">

    {{-- post section --}}

    <section class="w-full md:w-2/3 flex flex-col items-center px-3">

        {{-- Article section output from database using post-item component --}}

        @foreach ($posts as $post)
            <x-post-item :post="$post" />
        @endforeach
        
        <!-- for creating pagination -->
        {{ $posts->onEachSide(1)->links() }}

    </section>
   
   {{-- Include the x-sidebar component using the Blade directive --}}
   <x-sidebar/>

</x-app-layout>
