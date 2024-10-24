@extends('layouts.app')

@section('title', 'Following')

@section('content')

    @include('users.profile.header')

    <div style="margin-top: 100px">
        @if ($user->following->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-4">
                    @if (Auth::user()->theme == 'normal')
                    <h3 class="text-muted text-center">
                        Following
                    </h3>
                    @else
                    {{-- dark mode --}}
                    <h3 class="dark-mode-text text-center">
                        Following
                    </h3>
                    @endif
                   

                    @foreach ($user->following as $following)
                    @if (Auth::user()->theme == 'normal')
                    <div class="row align-items-canter mt-3">
                        <div class="col-auto">
                            <a href="{{route('profile.show',$following->following->id)}}">
                                @if ($following->following->avatar)
                                    <img src="{{$following->following->avatar}}" alt="{{$following->following->name}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            <a href="{{route('profile.show',$following->following->id)}}" class="text-decoration-none text-dark fw-bold">
                                {{$following->following->name}}
                            </a>
                        </div>
                        <div class="col-auto text-end">
                            @if ($following->following->id != Auth::user()->id)
                                @if ($following->following->isFollowed())
                                    <form action="{{route('follow.destroy', $following->following->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-0 bg-transparent p-0 text-secondary btn-sm">Following</button>
                                    </form>
                                @else
                                <form action="{{route('follow.store', $following->following->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                                </form>
                                @endif
                                
                            @endif
                        </div>
                    </div>
                    @else
                        {{-- dark mode --}}
                        <div class="row align-items-canter mt-3">
                            <div class="col-auto">
                                <a href="{{route('profile.show',$following->following->id)}}">
                                    @if ($following->following->avatar)
                                        <img src="{{$following->following->avatar}}" alt="{{$following->following->name}}" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-white icon-sm"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="col ps-0 text-truncate">
                                <a href="{{route('profile.show',$following->following->id)}}" class="text-decoration-none text-white fw-bold">
                                    {{$following->following->name}}
                                </a>
                            </div>
                            <div class="col-auto text-end">
                                @if ($following->following->id != Auth::user()->id)
                                    @if ($following->following->isFollowed())
                                        <form action="{{route('follow.destroy', $following->following->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0 bg-transparent p-0 text-white btn-sm">Following</button>
                                        </form>
                                    @else
                                    <form action="{{route('follow.store', $following->following->id)}}" method="post">
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
            <h3 class="text-secondary text-center">No Following Yet</h3>
        @endif
    </div>

@endsection