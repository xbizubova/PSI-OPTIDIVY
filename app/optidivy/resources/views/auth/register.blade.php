@extends('layouts.app')
@section('title', 'Sign Up')

@section('content')
    <div class="auth-layout">
        <div class="auth-card">
            <h1 class="auth-title">SIGN UP</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke-width="1.5">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}" required/>
                    </div>
                    @error('email') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="first_name">First name</label>
                    <div class="input-wrap">
                        <input type="text" id="first_name" name="first_name"
                               value="{{ old('first_name') }}" required/>
                    </div>
                    @error('first_name') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="last_name">Surname</label>
                    <div class="input-wrap">
                        <input type="text" id="last_name" name="last_name"
                               value="{{ old('last_name') }}" required/>
                    </div>
                    @error('last_name') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="password">Create a password</label>
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
                    @error('password') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Repeat password</label>
                    <div class="input-wrap">
                        <input type="password" id="password_confirmation"
                               name="password_confirmation" required/>
                        <button type="button" class="toggle-pw"
                                onclick="togglePw('password_confirmation', this)">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5">
                                <ellipse cx="12" cy="12" rx="10" ry="6"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary">REGISTER ME!</button>

                <p class="switch-text">
                    Už máš účet? <a href="{{ route('login') }}">Prihlás sa</a>
                </p>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/auth.js') }}"></script>
@endpush
