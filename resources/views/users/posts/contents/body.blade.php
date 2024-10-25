@if (Auth::user()->theme == 'normal')
    {{-- Clickable image --}}
<div class="container p-0">
    <a href="{{route('post.show', $post->id)}}">
        <img src="{{$post->image}}" alt="{{$post->id}}" class="w-100 post">
    </a>
</div>
<div class="card-body">
    {{-- heart button (icon) + no of likes + categories --}}
    <div class="row align-items-center">
        <div class="col-auto">
            @if ($post->isLiked())
            <form action="{{route('like.destroy', $post->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm shadow-none p-0">
                    <i class="fa-solid fa-heart text-danger"></i>
                </button>
            </form>
            @else
            <form action="{{route('like.store', $post->id)}}" method="post">
                @csrf
                <button type="submit" class="btn btn-sm shadow-none p-0">
                    <i class="fa-regular fa-heart"></i>
                </button>
            </form>
            @endif
        </div>
        <div class="col-auto px-0">
            <span class="fw-bold me-3">{{$post->likes->count()}}</span>
            {{-- いいねしている人を2人とotherを表示させ、otherで一覧を見れるようにしたい --}}
           @foreach ($post->likedByUsers->take(2) as $user)
                @if ($post->likes->count() == 2)
                    <span>
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>{{ !$loop->last ? ' and' : '' }}
                    </span>
                @elseif($post->likes->count() > 2)
                <span>
                    <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>{{ !$loop->last ? ',' : '' }}
                </span>
                @endif
                @endforeach
            
                @if ($post->likes->count() > 2)
                <span> and 
                    <button type="button" class=" btn btn-link p-0 text-decoration-none fw-bold text-dark" data-bs-toggle="modal" data-bs-target="#all-liked-users-{{$post->id}}">
                        Others
                      </button> liked this post.</span>
                @elseif($post->likes->count() == 2)
                    <span> liked this post.</span>
                @elseif($post->likes->count() == 1)
                    <span> <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a> liked this post.</span>
                @endif

                @include('users.posts.contents.modals.allLikedUsers')
            
        </div>
        <div class="col text-end">
            {{-- Lists of categories of specific post --}}
            @forelse ($post->categoryPost as $category_post)
            <div class="badge bg-secondary bg-opacity-50">
                {{$category_post->category->name}}
            </div>
            @empty
            <div class="badge bg-dark text-wrap">Uncategorized</div>
            @endforelse
        </div>
    </div>

    {{-- Owner of the post + Description of the post --}}
    <a href="{{route('profile.show',$post->user->id)}}" class="text-decoration-none text-dark fw-bold">{{$post->user->name}}</a>
    &nbsp;
    <p class="d-inline fw-light">{{$post->description}}</p>
    <p class="text-danger small">Posted on {{$post->created_at->diffForHumans()}}</p>
    <p class="text-uppercase text-muted small">
        {{date('M d, Y', strtotime($post->created_at))}}
        {{-- date(arg1, arg2) --}}
        {{-- arg1 --> Month Day Year --}}
        {{-- strtotime(timestamps) --> strtotime('2024-10-10 13:30:30') --}}
        {{--  --}}
    </p>

    {{-- Comments section here --}}
    @include('users.posts.contents.comments')
</div>
@else
{{-- dark mode --}}
    {{-- Clickable image --}}
<div class="container p-0">
    <a href="{{route('post.show', $post->id)}}">
        <img src="{{$post->image}}" alt="{{$post->id}}" class="w-100 post">
    </a>
</div>
<div class="card-body bg-dark">
    {{-- heart button (icon) + no of likes + categories --}}
    <div class="row align-items-center">
        <div class="col-auto">
            @if ($post->isLiked())
            <form action="{{route('like.destroy', $post->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm shadow-none p-0">
                    <i class="fa-solid fa-heart text-danger"></i>
                </button>
            </form>
            @else
            <form action="{{route('like.store', $post->id)}}" method="post">
                @csrf
                <button type="submit" class="btn btn-sm shadow-none p-0">
                    <i class="fa-regular fa-heart text-white"></i>
                </button>
            </form>
            @endif
        </div>
        <div class="col-auto px-0">
            <span class="text-white fw-bold me-3">{{$post->likes->count()}}</span>
            {{-- いいねしている人を2人とotherを表示させ、otherで一覧を見れるようにしたい --}}

            
                @foreach ($post->likedByUsers->take(2) as $user)
                @if ($post->likes->count() == 2)
                    <span class="text-white">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-white fw-bold" class="text-white">{{ $user->name }}</a>{{ !$loop->last ? ' and' : '' }}
                    </span>
                @elseif($post->likes->count() > 2)
                <span class="text-white">
                    <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-white fw-bold" class="text-white">{{ $user->name }}</a>{{ !$loop->last ? ',' : '' }}
                </span>
                @endif
                @endforeach
            
                @if ($post->likes->count() > 2)
                    <span class="text-white"> and 
                        <button type="button" class=" btn btn-link p-0 text-decoration-none fw-bold text-white" data-bs-toggle="modal" data-bs-target="#all-liked-users-{{$post->id}}">
                            Others
                          </button> liked this post.</span>
                @elseif($post->likes->count() == 2)
                    <span class="text-white"> liked this post.</span>
                @elseif($post->likes->count() == 1)
                    <span class="text-white"> <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-white fw-bold" class="text-white">{{ $user->name }}</a> liked this post.</span>
                @endif

                @include('users.posts.contents.modals.allLikedUsers')
            


        </div>
        <div class="col text-end">
            {{-- Lists of categories of specific post --}}
            @forelse ($post->categoryPost as $category_post)
            <div class="badge bg-secondary bg-opacity-50">
                {{$category_post->category->name}}
            </div>
            @empty
            <div class="badge bg-dark text-wrap">Uncategorized</div>
            @endforelse
        </div>
    </div>

    {{-- Owner of the post + Description of the post --}}
    <a href="{{route('profile.show',$post->user->id)}}" class="text-decoration-none text-white fw-bold">{{$post->user->name}}</a>
    &nbsp;
    <p class="d-inline fw-light text-white">{{$post->description}}</p>
    <p class="text-danger small ">Posted on {{$post->created_at->diffForHumans()}}</p>
    <p class="text-uppercase small dark-mode-text">
        {{date('M d, Y', strtotime($post->created_at))}}
        {{-- date(arg1, arg2) --}}
        {{-- arg1 --> Month Day Year --}}
        {{-- strtotime(timestamps) --> strtotime('2024-10-10 13:30:30') --}}
        {{--  --}}
    </p>

    {{-- Comments section here --}}
    @include('users.posts.contents.comments')
</div>
@endif
