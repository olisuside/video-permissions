@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>

        <h2>Customers</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.createCustomer') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Add Customer</button>
        </form>

        <!-- Table for Customers -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('admin.editCustomer', $customer->id) }}" class="btn btn-primary btn-sm">Edit</a>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.deleteCustomer', $customer->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <h2>Videos</h2>
        <ul>
            @foreach($videos as $video)
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

        <h2>Requests</h2>
        <ul>
            @foreach($requests as $request)
                <li>{{ $request->customer->name }} requested {{ $request->video->title }} - {{ $request->status }}
                    <form action="{{ route('admin.manageRequest', $request->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" required>
                            <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
