@extends('layouts.admin')

@section('content')
    <div class="container pt-3">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body d-flex align-items-center">
                        <i class='bx bx-user nav_icon fs-1 me-3'></i>
                        <div>
                            <h5 class="card-title">Customers</h5>
                            <p class="card-text">{{ $customerCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body d-flex align-items-center"> 
                        <i class='bx bx-video nav_icon fs-1 me-3'></i>
                        <div>
                            <h5 class="card-title">Videos</h5>
                            <p class="card-text">{{ $videoCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body d-flex align-items-center"> 
                        <i class='bx bx-task nav_icon fs-1 me-3'></i>
                        <div>
                            <h5 class="card-title">Requests</h5>
                            <p class="card-text">{{ $requestCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection
