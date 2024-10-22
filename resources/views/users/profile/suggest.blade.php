@extends('layouts.app')

@section('title', 'See all')

@section('content')
    <div class="mt-4">
        <h3>All Users</h3>
        <div class="row  d-flex justify-content-around">
        @foreach ($suggested_users as $suggested_user)
        <div class="card mt-4 col-5 p-3" style="height: 88px">
            <div class="row">
                <div class="col-2  d-flex justify-content-center align-items-center ">
            <a href="{{route('profile.show', $suggested_user->id)}}">
                @if ($suggested_user->avatar)
                    <img src="{{$suggested_user->avatar}}" alt="{{$suggested_user->name}}" class="rounded-circle avatar-md">
                @else
                    <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                @endif
            </a>
                </div>
                <div class="col-7">
            <a href="{{route('profile.show', $suggested_user->id)}}" class="text-decoration-none text-dark fw-bold">
                {{$suggested_user->name}}
                @if ($suggested_user->isFollowing())
                    <span class="small text-muted ms-3">Follows you</span>
                @endif
                @if ($suggested_user->introduction)
                    <br><span class="text-muted small"> {{ Str::limit($suggested_user->introduction, 30, '...') }}</span>
                @endif
            </a>
                </div>
                <div class="col-auto  d-flex justify-content-center align-items-center">
            @if ($suggested_user->isFollowed())
                <form action="{{route('follow.destroy', $suggested_user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="border-0 bg-transparent text-secondary btn-sm">Following</button>
                </form>
            @else
                <form action="{{route('follow.store', $suggested_user->id)}}" method="post">
                @csrf
                <button type="submit" class="border-0 bg-transparent text-primary btn-sm">Follow</button>
                </form>
            @endif
        </div>
        </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $suggested_users->links() }}
    </div>
    </div>
@endsection