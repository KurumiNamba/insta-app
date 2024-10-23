@extends('layouts.app')

@section('title', 'Update Password')

@section('content')
@if (Auth::user()->theme == 'normal')
<div class="row justify-content-center">
    <div class="col-8">
        @if(session('valid'))
            <form action="{{ route('profile.updatePassword') }}" method="post" class="bg-white shadow rounded-3 p-5">
                @csrf
                <h2 class="h3 mb-3 fw-light text-muted">Update Password</h2>
                <div class="row mb-3">
                    <label for="new_pass">New Password</label>
                    <div class="input-group">
                        <input type="password" name="new_pass" id="new_pass" class="form-control" required autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="new_pass_check">Confrim Password</label>
                    <div class="input-group">
                        <input type="password" name="new_pass_check" id="new_pass_check" class="form-control" required>
                        @if(session('error'))
                        <span class="text-danger mt-2">{{ session('error') }}</span>
                    @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Update Password</button>
            </form>
        @else
        @if (session('confirm_error'))
            <div class="alert alert-danger">
                {{ session('confirm_error') }}
            </div>
        @endif
            <form action="{{ route('profile.passwordValidate') }}" method="post" class="bg-white shadow rounded-3 p-5">
                @csrf
                <h2 class="h3 mb-3 fw-light text-muted">Update Password</h2>
                <div class="row mb-3">
                    <label for="current_pass">Current Password</label>
                    <div class="input-group">
                        <input type="password" name="current_pass" id="current_pass" class="form-control" required autofocus>
                    </div>
                    @if(session('error'))
                        <span class="text-danger mt-2">{{ session('error') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
            </form>
        @endif
    </div>
</div>
@else
{{-- dark mode --}}
<div class="row justify-content-center">
    <div class="col-8">
        @if(session('valid'))
            <form action="{{ route('profile.updatePassword') }}" method="post" class=" bg-dark shadow rounded-3 p-5">
                @csrf
                <h2 class="h3 mb-3 fw-light text-white">Update Password</h2>
                <div class="row mb-3">
                    <label for="new_pass" class="dark-mode-text">New Password</label>
                    <div class="input-group">
                        <input type="password" name="new_pass" id="new_pass" class="form-control" required autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="new_pass_check" class="dark-mode-text">Confrim Password</label>
                    <div class="input-group">
                        <input type="password" name="new_pass_check" id="new_pass_check" class="form-control" required>
                        @if(session('error'))
                        <span class="text-danger mt-2">{{ session('error') }}</span>
                    @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Update Password</button>
            </form>
        @else
        @if (session('confirm_error'))
            <div class="alert alert-danger">
                {{ session('confirm_error') }}
            </div>
        @endif
            <form action="{{ route('profile.passwordValidate') }}" method="post" class="bg-dark shadow rounded-3 p-5">
                @csrf
                <h2 class="h3 mb-3 fw-light text-white">Update Password</h2>
                <div class="row mb-3">
                    <label for="current_pass" class="dark-mode-text">Current Password</label>
                    <div class="input-group">
                        <input type="password" name="current_pass" id="current_pass" class="form-control" required autofocus>
                    </div>
                    @if(session('error'))
                        <span class="text-danger mt-2">{{ session('error') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
            </form>
        @endif
    </div>
</div>
@endif

@endsection
