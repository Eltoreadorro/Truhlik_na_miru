@foreach($images as $i)
<div class="gallery-item group cursor-pointer overflow-hidden rounded-lg shadow-md transition-transform duration-300 hover:scale-105 hover:z-10"
     data-src="{{ asset('img/gallery/kashpo-'.$i.'.jpg') }}">
    <div class="aspect-w-1 aspect-h-1 bg-gray-100 overflow-hidden">
        <img src="{{ asset('img/gallery/kashpo-'.$i.'.jpg') }}"
             alt="Truhlik {{ $i + ($offset ?? 0) }}"
             class="object-cover w-full h-full transition duration-500 group-hover:scale-110">
    </div>
</div>
@endforeach
