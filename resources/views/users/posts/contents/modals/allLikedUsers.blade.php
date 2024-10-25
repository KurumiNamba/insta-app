<div class="modal fade" id="all-liked-users-{{$post->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">All Liked Users</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul class="list-group list-group-flush">
                    @foreach ($post->likedByUsers as $user)
                        <li class="mb-3 list-group-item d-flex justify-content-between">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm me-3">
                            @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm me-3"></i>
                            @endif
                            <span class="text-dark fw-bold"> {{$user->name}}</span>
                        </a>
                        @if ($user->id !== Auth::user()->id)
                            
                        @if ($user->isFollowed())
                        <form action="{{route('follow.destroy', $user->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border-0 bg-transparent text-secondary btn-sm">Following</button>
                        </form>
                            @else
                                <form action="{{route('follow.store', $user->id)}}" method="post">
                                @csrf
                                <button type="submit" class="border-0 bg-transparent text-primary btn-sm">Follow</button>
                                </form>
                            @endif
                            
                        @endif
                        </li>
                    @endforeach
            </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>