<x-layout>
    <h1>You are now listening too {{$file->name}}</h1>
    {{-- <h2>By {{$}}</h2> --}}
    <audio controls seeked>
        <source src="{{url($file->file_path)}}" type="audio/mpeg"> 
    </audio>
</x-layout>