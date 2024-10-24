@extends('layouts.app')

@section('title', 'Followers')
    
@section('content')

@include('users.profile.header')

<div style="margin-top:100px">
    @if ($user->followers->isNotEmpty())
        <div class="row justify-content-center">
            <div class="col-4">
                @if (Auth::user()->theme == 'normal')
                <h3 class="text-muted text-center">
                    Followers
                </h3>
                @else
                {{-- dark mode --}}
                <h3 class="dark-mode-text text-center">
                    Followers
                </h3>
                @endif
                @foreach ($user->followers as $follower)
                @if (Auth::user()->theme == 'normal')
                <div class="row align-items-center mt-3">
                    <div class="col-auto">
                        <a href="{{'profile.show', $follower->follower->id}}">
                            @if ($follower->follower->avatar)
                                <img src="{{$follower->follower->avatar}}" alt="{{$follower->follower->avatar}}" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        <a href="{{route('profile.show', $follower->follower->id)}}" class="text-decoration-none text-dark fw-bold">{{$follower->follower->name}}</a>
                    </div>
                    <div class="col-auto text-end">
                        @if ($follower->follower->id !== Auth::id())    
                            @if ($follower->follower->isFollowed())
                                <form action="{{route('follow.destroy', $follower->follower->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent p-0 text-secondary btn-sm">Following</button>
                                </form>
                            @else
                                <form action="{{route('follow.store', $follower->follower->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
                @else
                    {{-- dark mode --}}
                    <div class="row align-items-center mt-3">
                        <div class="col-auto">
                            <a href="{{'profile.show', $follower->follower->id}}">
                                @if ($follower->follower->avatar)
                                    <img src="{{$follower->follower->avatar}}" alt="{{$follower->follower->avatar}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-white icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            <a href="{{route('profile.show', $follower->follower->id)}}" class="text-decoration-none text-white fw-bold">{{$follower->follower->name}}</a>
                        </div>
                        <div class="col-auto text-end">
                            @if ($follower->follower->id !== Auth::id())    
                                @if ($follower->follower->isFollowed())
                                    <form action="{{route('follow.destroy', $follower->follower->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-0 bg-transparent p-0 text-white btn-sm">Following</button>
                                    </form>
                                @else
                                    <form action="{{route('follow.store', $follower->follower->id)}}" method="post">
                                        @csrf
                                        <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
                @endforeach
            </div>
        </div>
    @else
        <h3 class="text-secondary text-center">No Follower Yet</h3>
    @endif
</div>

@endsection