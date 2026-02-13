@extends('layouts.guest')

@section('content')
<style>
    .auth-card {
        background-color: var(--card-bg);
        padding: 2.5rem;
        border-radius: 1rem;
        box-shadow: var(--card-shadow);
        width: 100%;
        max-width: 420px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }
    .auth-title {
        text-align: center;
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: var(--text-color);
        letter-spacing: -0.025em;
    }
    .auth-subtitle {
        text-align: center;
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 2rem;
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        color: var(--text-color);
    }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        border-radius: 0.625rem;
        color: var(--text-color);
        font-size: 0.9375rem;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px var(--primary-light, rgba(79, 70, 229, 0.1));
    }
    .btn-submit {
        width: 100%;
        background-color: var(--primary-color);
        color: white;
        padding: 0.875rem;
        border: none;
        border-radius: 0.625rem;
        font-weight: 600;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.2s;
        margin-top: 0.5rem;
    }
    .btn-submit:hover {
        background-color: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }
    .btn-submit:active {
        transform: translateY(0);
    }
    .error-msg {
        color: #ef4444;
        font-size: 0.8125rem;
        margin-top: 0.375rem;
        font-weight: 500;
    }
    .auth-footer {
        margin-top: 1.75rem;
        text-align: center;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }
    .auth-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.15s;
    }
    .auth-link:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    .auth-page-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 128px); /* Full height minus nav and footer */
        padding: 2rem 1rem;
        box-sizing: border-box;
    }

    @media (max-width: 480px) {
        .auth-card {
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: none;
            border: none;
            background: transparent;
        }
        .auth-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="auth-page-wrapper">
    <div class="auth-card">
        <div class="auth-title">Welcome Back</div>
        <div class="auth-subtitle">Please sign in to your account</div>
        
        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="name@company.com" required autofocus>
                @error('email')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <label for="password" class="form-label" style="margin-bottom: 0;">Password</label>
                    {{-- <a href="#" class="auth-link" style="font-size: 0.8125rem; font-weight: 500;">Forgot password?</a> --}}
                </div>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>
            
            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-top: -0.5rem; margin-bottom: 1.5rem;">
                <input type="checkbox" id="remember" name="remember" style="width: 1rem; height: 1rem; accent-color: var(--primary-color); cursor: pointer;">
                <label for="remember" style="font-size: 0.875rem; color: var(--text-secondary); cursor: pointer; user-select: none;">Remember me</label>
            </div>

            <button type="submit" class="btn-submit">Sign In</button>
            
            <div class="auth-footer">
                Don't have an account? <a href="{{ url('/register') }}" class="auth-link">Create one</a>
            </div>
        </form>
    </div>
</div>
@endsection
