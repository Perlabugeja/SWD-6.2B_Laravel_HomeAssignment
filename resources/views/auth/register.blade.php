@extends('layouts.main')

@section('content')
<x-slot:title>
    Register
</x-slot:title>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">

                    <h1 class="mb-4 text-center">Create Account</h1>

                    <form method="POST" action="/register">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="John Doe"
                                   value="{{ old('name') }}"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="mail@example.com"
                                   value="{{ old('email') }}"
                                   required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••"
                                   required>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                Confirm Password
                            </label>
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   class="form-control"
                                   placeholder="••••••••"
                                   required>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <p class="text-center">
                        Already have an account?
                        <a href="/login">Sign in</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
