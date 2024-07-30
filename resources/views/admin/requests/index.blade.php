@extends('layouts.admin')

@section('content')
<div class="container pt-3">
    <div class="d-flex justify-content-between mb-3">
        <h1>Requests</h1>
    </div>

    @if ($requests->isEmpty())
        <div class="alert alert-info" role="alert">
            No requests available.
        </div>
    @else
        <ul class="list-group">
            @foreach ($requests as $request)
                @if ($request->status != 'expired')
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            {{ $request->customer->name }} requested {{ $request->video->title }} - {{ $request->status }}
                        </div>
                        
                        <form action="{{ route('admin.manageRequest', $request->id) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            @method('PATCH')
                            <div class="me-2">
                                <select name="status" class="form-select form-select-sm" required>
                                    <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="me-2">
                                <input type="number" name="duration" class="form-control form-control-sm" placeholder="Duration in hours" min="1">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif
</div>
@endsection
