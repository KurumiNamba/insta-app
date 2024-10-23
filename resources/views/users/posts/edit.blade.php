@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
@if (Auth::user()->theme == 'normal')
<form action="{{route('post.update', $post->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="mb-3">
        <label for="category" class="form-label d-block fw-bold">
            Category <span class="text-muted fw-normal">(Up to 3)</span>
        </label>

        @foreach ($all_categories as $category)
        
        @if (in_array($category->id, $selected_categories))
        <div class="form-check form-check-inline">
            <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input" checked>
            <label for="{{$category->name}}" class="form-check-label">{{$category->name}}</label>
        </div>
        @else
        <div class="form-check form-check-inline">
            <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input">
            <label for="{{$category->name}}" class="form-check-label">{{$category->name}}</label>
        </div>
        @endif

            {{-- <div class="form-check form-check-inline">
                <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input">
                <label for="{{$category->name}}" class="form-check-label">{{$category->name}}</label>
            </div> --}}
        @endforeach
        {{-- Error message area --}}
        @error('category')
            <p class="text-danger small">
                {{$message}}
            </p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{old('description', $post->description)}}</textarea>
        {{-- Error message area --}} 
        @error('description')
            <p class="text-danger small">
                {{$message}}
            </p>
        @enderror
    </div>

    <div class=" row mb-4">
        <div class="col-6">
            <label for="image" class="form-label fw-bold">Image</label>
            <img src="{{$post->image}}" alt="{{$post->id}}" class="img-thumbnail w-100">
            <input type="file" name="image" id="image" class="form-control mt-1" aria-describedby="image-info">
            <div class="form-text" id="image-info">
                The acceptable formats are jpeg, jpg, png, and gif only. <br>
                Max file is 1048Kb.
            </div>
            {{-- Error message area --}}
            @error('image')
                <p class="text-danger small">
                    {{$message}}
                </p>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-warning px-5">Save</button>
</form>
@else
    {{-- dark mode --}}
    <form action="{{route('post.update', $post->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="category" class="form-label d-block fw-bold text-white">
                Category <span class="fw-normal">(Up to 3)</span>
            </label>

            @foreach ($all_categories as $category)
            
            @if (in_array($category->id, $selected_categories))
            <div class="form-check form-check-inline">
                <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input" checked>
                <label for="{{$category->name}}" class="form-check-label text-white">{{$category->name}}</label>
            </div>
            @else
            <div class="form-check form-check-inline">
                <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input">
                <label for="{{$category->name}}" class="form-check-label text-white">{{$category->name}}</label>
            </div>
            @endif

                {{-- <div class="form-check form-check-inline">
                    <input type="checkbox" name="category[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input">
                    <label for="{{$category->name}}" class="form-check-label">{{$category->name}}</label>
                </div> --}}
            @endforeach
            {{-- Error message area --}}
            @error('category')
                <p class="text-danger small">
                    {{$message}}
                </p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-bold text-white">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="What's on your mind">{{old('description', $post->description)}}</textarea>
            {{-- Error message area --}} 
            @error('description')
                <p class="text-danger small">
                    {{$message}}
                </p>
            @enderror
        </div>

        <div class=" row mb-4">
            <div class="col-6">
                <label for="image" class="form-label fw-bold text-white">Image</label>
                <img src="{{$post->image}}" alt="{{$post->id}}" class="img-thumbnail w-100">
                <input type="file" name="image" id="image" class="form-control mt-1" aria-describedby="image-info">
                <div class="form-text dark-mode-text" id="image-info">
                    The acceptable formats are jpeg, jpg, png, and gif only. <br>
                    Max file is 1048Kb.
                </div>
                {{-- Error message area --}}
                @error('image')
                    <p class="text-danger small">
                        {{$message}}
                    </p>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-warning px-5">Save</button>
    </form>
@endif

@endsection