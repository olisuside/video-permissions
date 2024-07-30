@extends('layouts.admin')

@section('content')
    <div class="container">@section('content')
        <h1>Dashboard</h1>
        <p>Jumlah Customers: {{ $customerCount }}</p>
        <p>Jumlah Videos: {{ $videoCount }}</p>
        <p>Jumlah Requests: {{ $requestCount }}</p>
    @endsection

