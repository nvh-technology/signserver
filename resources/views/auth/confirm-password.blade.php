@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card p-4 shadow">
                    <div class="mb-4 text-muted">
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection