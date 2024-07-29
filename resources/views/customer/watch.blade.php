<!-- resources/views/customer/watch.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Watch Video</h1>

        @if($video)
            <div>
                <h2>{{ $video->title }}</h2>
                <p>{{ $video->description }}</p>
                <video controls>
                    <source src="{{ $video->url }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @else
            <p>You do not have access to this video or your access has expired.</p>
        @endif
    </div>
@endsection
