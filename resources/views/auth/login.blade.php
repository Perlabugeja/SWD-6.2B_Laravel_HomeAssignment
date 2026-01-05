@extends('layouts.main')

@section('content')
    <div class="card-body">
        <h1>Welcome Back</h1>

        <form method="POST" action="/login">
            @csrf

            <!-- Email -->
            <label>
                <input type="email"
                        name="email"
                        placeholder="[mail@example.com](<mailto:mail@example.com>)"
                        value="{{ old('email') }}"
                        class="input input-bordered @error('email') input-error @enderror"
                        required
                        autofocus>
                <span>Email</span>
            </label>

            @error('email')
                <div>
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
            @enderror

            <!-- Password -->
            <label>
                <input type="password"
                        name="password"
                        placeholder="••••••••"
                        class="input input-bordered @error('password') input-error @enderror"
                        required>
                <span>Password</span>
            </label>

            @error('password')
                <div>
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </div>
            @enderror

            <!-- Remember Me -->
            <div>
                <label class="label cursor-pointer justify-start">
                    <input type="checkbox"
                            name="remember"
                            class="checkbox">
                    <span class="label-text ml-2">Remember me</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit">
                    Sign In
                </button>
            </div>
        </form>

        <div class="divider">OR</div>
        <p class="text-center text-sm">
            Don't have an account?
            <a href="/register" class="link link-primary">Register</a>
        </p>
    </div>
@endsection