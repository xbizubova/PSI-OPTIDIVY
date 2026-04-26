@extends('layouts.app')
@section('title', 'Log In')

@section('content')
    <div class="auth-layout">
        <div class="auth-card">
            <h1 class="auth-title">LOG IN</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email">email</label>
                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.5">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}" required autofocus/>
                    </div>
                    @error('email')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">password</label>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password" required/>
                        <button type="button" class="toggle-pw"
                                onclick="togglePw('password', this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5">
                                <ellipse cx="12" cy="12" rx="10" ry="6"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <a href="{{ route('password.request') }}" class="forgot">
                    Forgot password?
                </a>

                <button type="submit" class="btn-primary">LOG IN</button>

                <p class="switch-text">
                    Nemáš účet?
                    <a href="{{ route('register') }}">Zaregistruj sa</a>
                </p>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/auth.js') }}"></script>
@endpush
