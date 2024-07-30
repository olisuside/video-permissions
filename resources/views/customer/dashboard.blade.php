@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Customer Dashboard</h1>

        <!-- Videos Section -->
        <h2 class="my-4">Videos</h2>
        <div class="row">
            @foreach($videos as $video)
                @php
                    $request = $requests->firstWhere('video_id', $video->id);
                    $hasAccess = $accesses->firstWhere('videoRequest.video_id', $video->id);
                @endphp
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="{{ $video->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $video->title }}</h5>
                            @if($hasAccess && now()->between($hasAccess->access_start_time, $hasAccess->access_end_time))
                                <a href="{{ route('customer.watchVideo', $hasAccess->id) }}" class="btn btn-success">Watch</a>
                            @elseif($request)
                                @if($request->status === 'pending')
                                    <button class="btn btn-secondary" disabled>Pending</button>
                                @elseif($request->status === 'rejected' || $request->status === 'expired')
                                    <form action="{{ route('customer.requestAccess', $video->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Request Access</button>
                                    </form>
                                @endif
                            @else
                                <form action="{{ route('customer.requestAccess', $video->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Request Access</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
