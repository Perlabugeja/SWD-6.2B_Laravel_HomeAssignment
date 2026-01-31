@extends('layouts.main')

@section('title', 'Register')

@section('content')
<div class="playlist-page">
    <div class="form-wrapper">

        @include('partials.alerts')

        <h1 class="mb-4 text-center">Create Account</h1>

        <form method="POST" action="/register">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="John Doe"
                    value="{{ old('name') }}"
                >
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="mail@example.com"
                    value="{{ old('email') }}"
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                >
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="••••••••"
                >
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">Register</button>
            </div>
        </form>

        <hr class="my-4">
        <p class="text-center">Already have an account? <a href="/login">Sign in</a></p>

    </div>
</div>
@endsection
