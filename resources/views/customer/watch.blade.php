<!-- resources/views/customer/watch.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">


        @if ($video)
            <div class="container px-5 my-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="embed-responsive embed-responsive-16by9 mb-4">
                            <iframe class="embed-responsive-item" src="{{ $video->url }}" frameborder="0" allowfullscreen
                                style="width: 100%; height: 75vh;"></iframe>
                        </div>
                        <h2 class="">{{ $video->title }}</h2>
                        <p class="">{{ $video->description }}</p>
                    </div>
                </div>
            </div>
        @else
            <p>You do not have access to this video or your access has expired.</p>
        @endif
    </div>
@endsection
