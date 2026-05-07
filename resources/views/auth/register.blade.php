<!-- resources/views/auth/register.blade.php -->
@extends('layout')

@section('content')

<div class="auth-container">
    <div class="auth-card">
        <h2>Create Account</h2>

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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="@error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="Enter your full name"
                >
                @error('name')
                    <span class="auth-error" style="margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="@error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    required
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
                    onchange="checkPasswordStrength()"
                    oninput="checkPasswordStrength()"
                >
                <div class="password-strength">
                    <div class="strength-bar" id="strengthBar"></div>
                </div>
                @error('password')
                    <span class="auth-error" style="margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
                <small style="color: #666; display: block; margin-top: 5px;">
                    Password must be at least 8 characters with uppercase, lowercase, number, and symbol
                </small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="@error('password_confirmation') is-invalid @enderror"
                    required
                    placeholder="Confirm your password"
                >
                @error('password_confirmation')
                    <span class="auth-error" style="margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-auth">Create Account</button>
        </form>

        <div class="auth-link">
            Already have an account? 
            <a href="{{ route('login') }}">Login here</a>
        </div>
    </div>
</div>

<script>
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthBar = document.getElementById('strengthBar');
    
    if (password.length === 0) {
        strengthBar.className = 'strength-bar';
        return;
    }
    
    let strength = 0;
    
    // Check length
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    
    // Check for lowercase
    if (/[a-z]/.test(password)) strength++;
    
    // Check for uppercase
    if (/[A-Z]/.test(password)) strength++;
    
    // Check for numbers
    if (/[0-9]/.test(password)) strength++;
    
    // Check for special characters
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    strengthBar.className = 'strength-bar';
    
    if (strength <= 2) {
        strengthBar.classList.add('weak');
    } else if (strength <= 4) {
        strengthBar.classList.add('medium');
    } else {
        strengthBar.classList.add('strong');
    }
}
</script>

@endsection
