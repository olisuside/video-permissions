@extends('layouts.app')

@section('content')
        <!-- Carousel Section -->
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
                @foreach($latestVideos as $index => $video)
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($latestVideos as $index => $video)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ $video->thumbnail }}" class="d-block w-100" alt="{{ $video->title }}" style="height: 70vh; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $video->title }}</h5>
                            <p>{{ $video->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="container">

        <!-- Videos Section -->
        <h2 class="my-4 text-center">All Videos</h2>
        <div class="row justify-content-center">
            @foreach($videos as $video)
                @php
                    $request = $requests->firstWhere('video_id', $video->id);
                    $hasAccess = $accesses->firstWhere('videoRequest.video_id', $video->id);
                @endphp
                <div class="col-md-4 mb-4 d-flex justify-content-center">
                    <div class="card border-0 shadow-lg rounded-lg" style="width: 28rem;">
                        <img src="{{ $video->thumbnail }}" class="card-img-top" alt="{{ $video->title }}" style="object-fit: cover; width: 100%; height: 400px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $video->title }}</h5>
                                @if($hasAccess && now()->between($hasAccess->access_start_time, $hasAccess->access_end_time))
                                    <a href="{{ route('customer.watchVideo', $hasAccess->id) }}" class="btn btn-success">Watch</a>
                                @elseif($request)
                                    @if($request->status === 'pending')
                                        <button class="btn btn-secondary" disabled>Pending</button>
                                    @elseif($request->status === 'rejected' || $request->status === 'expired')
                                        <form action="{{ route('customer.requestAccess', $video->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Request Access</button>
                                        </form>
                                    @endif
                                @else
                                    <form action="{{ route('customer.requestAccess', $video->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Request Access</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
