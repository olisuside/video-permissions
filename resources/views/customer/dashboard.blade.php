@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Main Title -->
        <h1 class="my-4 text-center">Customer Dashboard</h1>

        <!-- Videos Section -->
        <h2 class="my-4 text-center">Videos</h2>
        <div class="row justify-content-center">
            @foreach($videos as $video)
                @php
                    $request = $requests->firstWhere('video_id', $video->id);
                    $hasAccess = $accesses->firstWhere('videoRequest.video_id', $video->id);
                @endphp
                <div class="col-md-4 mb-4 d-flex justify-content-center">
                    <div class="card text-bg-dark border-0" style="width: 300px;">
                        <img src="https://via.placeholder.com/300x400" class="card-img" alt="{{ $video->title }}" style="object-fit: cover; width: 100%; height: 400px;">
                        <div class="card-img-overlay d-flex flex-column justify-content-end p-3">
                            <h5 class="card-title text-white mb-3 text-center">{{ $video->title }}</h5>
                            <div class="d-flex justify-content-center">
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
