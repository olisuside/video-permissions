@extends('layouts.admin')

@section('content')
<h2>Requests</h2>
<ul>
    @foreach ($requests as $request)
        @if ($request->status != 'expired')
            <li>{{ $request->customer->name }} requested {{ $request->video->title }} - {{ $request->status }}
                <form action="{{ route('admin.manageRequest', $request->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" required>
                        <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Approved
                        </option>
                        <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Rejected
                        </option>
                    </select>
                    <input type="number" name="duration" placeholder="Duration in hours" min="1">
                    <button type="submit">Update</button>
                </form>
            </li>
        @endif
    @endforeach
</ul>

@endsection
