@if (Auth::user()->theme == 'normal')
    {{-- Clickable image --}}
<div class="container p-0">
    <a href="{{route('post.show', $post->id)}}">
        <img src="{{$post->image}}" alt="{{$post->id}}" class="w-100">
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
            <span>{{$post->likes->count()}}</span>
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
        <img src="{{$post->image}}" alt="{{$post->id}}" class="w-100">
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
            <span class="text-white">{{$post->likes->count()}}</span>
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
