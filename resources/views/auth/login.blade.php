@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">

                    <h1 class="mb-4 text-center">Welcome Back</h1>

                    <form method="POST" action="/login">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="mail@example.com"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>

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

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox"
                                   name="remember"
                                   class="form-check-input"
                                   id="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Sign In
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <p class="text-center text-sm">
                        Don't have an account?
                        <a href="/register">Register</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
