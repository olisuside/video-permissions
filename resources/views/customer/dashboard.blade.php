@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Customer Dashboard</h1>

        <h2>Videos</h2>
        <ul>
            @foreach($videos as $video)
                <li>{{ $video->title }}
                    <form action="{{ route('customer.requestAccess', $video->id) }}" method="POST">
                        @csrf
                        <button type="submit">Request Access</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <h2>Your Requests</h2>
        <ul>
            @foreach($requests as $request)
                <li>{{ $request->video->title }} - {{ $request->status }}</li>
            @endforeach
        </ul>

        <h2>Your Accesses</h2>
        <ul>
            @foreach($accesses as $access)
                <li>
                    {{ $access->videoRequest->video->title }} 
                    ({{ $access->access_start_time }} - {{ $access->access_end_time }})
                    <a href="{{ route('customer.watchVideo', $access->id) }}">Watch</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
