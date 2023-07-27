@php

// Annotating for links so as to acces the onEachSide() method to format our pagination
/** @var $posts \Illuminate\Pagination\LengthAwarePaginator */
@endphp


<x-app-layout meta-description="Brian Blog about nature and events as they happen">

    {{-- post section --}}

    <section class="w-full md:w-2/3 flex flex-col items-center px-3">

        {{-- Article section output from database using post-item component --}}

        @foreach ($posts as $post)
        <x-post-item :post="$post" />

        @endforeach
        
        


        {{-- for creating pagination --}}
        {{ $posts->onEachSide(1)->links() }}



    </section>
    <!--aside bar-->
   <x-sidebar/>

</x-app-layout>