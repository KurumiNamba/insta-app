@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <h3><i class="fa-solid fa-chart-line"></i> Reports</h3>

    <div class="row d-flex justify-cotent-center mt-5">
        <div class="col">
            <a href="{{route('reports.posts')}}" class="btn btn-secondary w-75 fs-3">
                <i class="fa-solid fa-newspaper icon-md"></i><br>Posts
            </a>
        </div>
        <div class="col">
            <a href="{{route('reports.users')}}" class="btn btn-secondary w-75 fs-3">
                <i class="fa-solid fa-users icon-md"></i><br>Users
            </a>
        </div>
    </div>
    <div class="row d-flex justify-cotent-center mt-5">
        <div class="col">
        <a href="" class="btn btn-secondary w-75 fs-3">
            <i class="fa-solid fa-tags icon-md"></i><br>Categories
        </a>
        </div>
        <div class="col">
        <a href="" class="btn btn-secondary w-75 fs-3">
            <i class="fa-solid fa-heart icon-md"></i><br>Likes
        </a>
        </div>
    </div>
    
@endsection