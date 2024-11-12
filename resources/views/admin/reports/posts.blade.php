@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<h3><a href="{{route('reports')}}" class="text-decoration-none text-dark"><i class="fa-solid fa-chart-line"></i> Reports</a></h3>
<h4><i class="fa-solid fa-arrow-right-long ms-3"></i> Posts</h4>
    <div class="row mt-3">
        <div class="col-4 text-center">
            <p class="fw-bold">Total Posts</p>
            <p class="fw-bold fs-3">{{count($all_posts)}}</p>
        </div>
        <div class="col-4 text-center">
            <p class="fw-bold">This Week's Posts</p>
            <p class="fw-bold fs-3">{{count($weeks_posts)}}</p>
        </div>
        <div class="col-4 text-center">
            <p class="fw-bold">Today's Posts</p>
            <p class="fw-bold fs-3">{{count($todays_posts)}}</p>
        </div>
    </div>

    <div class="row mt-5">
        <h4>All Posts</h4>
    </div>
    <div class="row">
        @foreach ($all_posts as $post)
        <div class="col-4 my-3 photo-container">
            <a href="{{route('post.show', $post->id)}}">
            <img src="{{$post->image}}" alt="{{$post->id}}" class="grid-img">
            
            <div class="overlay">
                <p class="fs-4"><i class="fa-solid fa-heart icon-sm me-2"></i>{{$post->likes()->count()}} Likes</p>
                <p class="fs-4"><i class="fa-regular fa-comment icon-sm me-2"></i>{{$post->comments()->count()}} Comments</p>
                <p class="fs-5">Posted By: {{$post->user->name}}</p>
            </div>
        </a>
        </div>
        @endforeach
    </div>
@endsection