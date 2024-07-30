@extends('layouts.admin')

@section('content')
    <h1>Customers</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('admin.editCustomer', $customer->id) }}"
                            class="btn btn-primary btn-sm">Edit</a>
    
                        <!-- Delete Form -->
                        <form action="{{ route('admin.deleteCustomer', $customer->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
