@extends('layouts.app')

@section('title', 'Home')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <div class="row gx-5">
        <div class="col-8">
            @forelse ($home_posts as $post)
                <div class="card mb-4">
                    {{-- title.blade.php --}}
                    @include('users.posts.contents.title')
                    {{-- body.blade.php --}}
                    @include('users.posts.contents.body')
                </div>
            @empty
                @if (Auth::user()->theme == 'normal')
                    {{-- Show this if the site doesn't have any post yet.  --}}
                <div class="text-center">
                    <h2>Share Photos</h2>
                    <p class="text-secondary">When you share photos, they'll appear on your profile.</p>
                    <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
                </div>  
                @else
                    {{-- Show this if the site doesn't have any post yet.  --}}
                <div class="text-center">
                    <h2 class="text-white">Share Photos</h2>
                    <p class="dark-mode-text">When you share photos, they'll appear on your profile.</p>
                    <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
                </div>  
                @endif  
            @endforelse
            
        </div>
        @if (Auth::user()->theme == 'normal')
            <div class="col-4 bg-light">
        @else
        <div class="col-4 dark-mode-bg">
        @endif
            {{-- PROFILE OVERVIEW + SUGGESTIONS --}}
            @if (Auth::user()->theme == 'normal')
                <div class="row align-items center mb-5 bg-white shadow-sm rounded-3 py-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', Auth::user()->id) }}" class="">
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0">
                        <a href="{{ route('profile.show', Auth::user()->id) }}" class="text-decoration-none text-dark fw-bold">{{ Auth::user()->name }}</a>
                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            @else
                <div class="row align-items center mb-5 bg-dark shadow-sm rounded-3 py-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', Auth::user()->id) }}" class="">
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-circle-user text-white icon-md"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0">
                        <a href="{{ route('profile.show', Auth::user()->id) }}" class="text-decoration-none text-white fw-bold">{{ Auth::user()->name }}</a>
                        <p class="dark-mode-text mb-0">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            @endif
            

            {{-- User Suggestions --}}
            <div class="row">
                <div class="col-auto">
                    @if (Auth::user()->theme == 'normal')
                        <p class="fw-bold text-secondary">Suggestions For You</p>
                    @else
                        <p class="fw-bold text-white">Suggestions For You</p>
                    @endif
                    
                </div>
                <div class="col text-end">
                    @if (Auth::user()->theme == 'normal')
                        <a href="{{route('suggest')}}" class="text-decoration-none fw-bold text-dark">See All</a>
                    @else
                    <a href="{{route('suggest')}}" class="text-decoration-none fw-bold dark-mode-text">See All</a>
                    @endif
                </div>
            </div>

            @foreach ($suggested_users as $user)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
                            @else
                                @if (Auth::user()->theme == 'normal')
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @else
                                    <i class="fa-solid fa-circle-user text-white icon-sm"></i>
                                @endif
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        @if (Auth::user()->theme == 'normal')
                            <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                        @else
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-white fw-bold">{{ $user->name }}</a>
                        @endif
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('follow.store', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection









