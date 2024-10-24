@extends('layouts.app')

@section('title', $user->name)

@section('content')
    
    @include('users.profile.header')
    {{-- show all the posts of the user --}}
    <div style="margin-top: 100px">
        @if ($user->posts->isNotEmpty())
            <div class="row">
                @foreach ($user->posts as $post)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{route('post.show', $post->id)}}">
                            <img src="{{$post->image}}" alt="post id {{$post->id}}" class="grid-img ">
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            @if (Auth::user()->theme == 'normal')
                <h3 class="text-muted text-center">No posts yet</h3>
            @else
            {{-- dark mode --}}
                <h3 class=" text-center dark-mode-text">No posts yet</h3>
            @endif
        @endif
    </div>

@endsection