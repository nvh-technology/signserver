@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card p-4 shadow">
                    <h4 class="card-title text-center">{{ __('Log in') }}</h4>
                    <hr>
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-3 rounded-0" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                            @error('email')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('Log in') }}
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center mt-3">
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection