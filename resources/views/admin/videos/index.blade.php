@extends('layouts.admin')

@section('content')
    
<h2>Videos</h2>
<ul>
    @foreach ($videos as $video)
        <li>{{ $video->title }}
            <form action="{{ route('admin.updateVideo', $video->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text" name="title" value="{{ $video->title }}" required>
                <textarea name="description" required>{{ $video->description }}</textarea>
                <input type="url" name="url" value="{{ $video->url }}" required>
                <button type="submit">Update</button>
            </form>
            <form action="{{ route('admin.deleteVideo', $video->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
