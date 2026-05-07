<!-- resources/views/auth/login.blade.php -->
@extends('layout')

@section('content')

<div class="auth-container">
    <div class="auth-card">
        <h2>Login</h2>

        @if ($errors->any())
        <div class="auth-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        @if (session('success'))
        <div class="auth-success">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="@error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="Enter your email"
                >
                @error('email')
                    <span class="auth-error" style="margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="@error('password') is-invalid @enderror"
                    required
                    placeholder="Enter your password"
                >
                @error('password')
                    <span class="auth-error" style="margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-check">
                <input 
                    type="checkbox" 
                    name="remember" 
                    id="remember"
                >
                <label for="remember">Remember Me</label>
            </div>

            <button type="submit" class="btn-auth">Login</button>
        </form>

        <div class="auth-link">
            Don't have an account? 
            <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</div>

@endsection
