@extends('layouts.app')

@section('title', 'Explore People')

@section('content')
@if (Auth::user()->theme == 'normal')
<div class="row justify-content-center">
    <div class="col-5">
        <p class="h5 text-muted mb-4">Search results for "<span class="fw-bold">{{$search}}</span>"</p>

        {{-- Loop and display the results --}}
        @forelse ($users as $user)
            <div class="row align-items-center mb-3">
                <div class="col-auto">
                    <a href="{{route('profile.show', $user->id)}}">
                        @if ($user->avatar)
                            <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                        @endif
                    </a>
                </div>
                <div class="col ps-0 text-truncate">
                    <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark fw-bold">
                        {{$user->name}}
                        @if ($user->isFollowing())
                            <span class="text-muted small ms-3">Follows You</span>
                        @endif
                    </a>
                    <p class="text-muted small mb-0">{{$user->email}}</p>
                </div>
                <div class="col-auto">
                    @if ($user->id !== Auth::user()->id)
                        @if ($user->isFollowed())
                            <form action="{{route('follow.destroy', $user->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary fw-bold btn-sm">Following</button>
                            </form>
                        @else
                            <form action="{{route('follow.store', $user->id)}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary fw-bold btn-sm">Follow</button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            
        @endforelse
    </div>
    <div class="d-flex justify-content-center">
        {{$users->appends(['search' => $search])->links()}}
    </div>
    
</div>
@else
    {{-- dark mode --}}
    <div class="row justify-content-center">
        <div class="col-5">
            <p class="h5 dark-mode-text mb-4">Search results for "<span class="fw-bold">{{$search}}</span>"</p>

            {{-- Loop and display the results --}}
            @forelse ($users as $user)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{route('profile.show', $user->id)}}">
                            @if ($user->avatar)
                                <img src="{{$user->avatar}}" alt="{{$user->name}}" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-circle-user text-white icon-md"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-white fw-bold">
                            {{$user->name}}
                            @if ($user->isFollowing())
                                <span class="dark-mode-text small ms-3">Follows You</span>
                            @endif
                        </a>
                        <p class="dark-mode-text small mb-0">{{$user->email}}</p>
                    </div>
                    <div class="col-auto">
                        @if ($user->id !== Auth::user()->id)
                            @if ($user->isFollowed())
                                <form action="{{route('follow.destroy', $user->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-white fw-bold btn-sm">Following</button>
                                </form>
                            @else
                                <form action="{{route('follow.store', $user->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary fw-bold btn-sm">Follow</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                
            @endforelse
        </div>
        <div class="d-flex justify-content-center">
            {{$users->appends(['search' => $search])->links()}}
        </div>
        
    </div>
@endif


@endsection