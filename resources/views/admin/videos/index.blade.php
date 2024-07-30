@extends('layouts.admin')

@section('content')
    <div class="container pt-3">
        <div class="d-flex justify-content-between">
            <h1>Videos</h1>

            <!-- Button to Open the Add Video Modal -->
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addVideoModal">
                Add Video
            </button>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>URL</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($videos as $video)
                    <tr>
                        <td>{{ $video->title }}</td>
                        <td>{{ $video->description }}</td>
                        <td>{{ $video->url }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editVideoModal{{ $video->id }}">
                                Edit
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.deleteVideo', $video->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Video Modal -->
                    <div class="modal fade" id="editVideoModal{{ $video->id }}" tabindex="-1"
                        aria-labelledby="editVideoModalLabel{{ $video->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editVideoModalLabel{{ $video->id }}">Edit Video</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.updateVideo', $video->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="title{{ $video->id }}">Title</label>
                                            <input type="text" name="title" id="title{{ $video->id }}"
                                                class="form-control" value="{{ old('title', $video->title) }}" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="description{{ $video->id }}">Description</label>
                                            <textarea name="description" id="description{{ $video->id }}" class="form-control" required>{{ old('description', $video->description) }}</textarea>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="url{{ $video->id }}">URL</label>
                                            <input type="url" name="url" id="url{{ $video->id }}"
                                                class="form-control" value="{{ old('url', $video->url) }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Add Video Modal -->
        <div class="modal fade" id="addVideoModal" tabindex="-1" aria-labelledby="addVideoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addVideoModalLabel">Add Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.createVideo') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" required></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="url">URL</label>
                                <input type="url" name="url" id="url" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
