@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
                        </ol>
                    </nav>
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">{{ __('Back') }}</a>
                </div>

                <h2 class="mb-4">{{ __('Profile') }}</h2>

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ __('Your profile has been updated.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @elseif (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ __('Your password has been updated.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @elseif (session('status') === 'passcode-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ __('Your passcode has been updated.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @if (session('fail'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('fail') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-lg">
                    <div class="card-header py-3">
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile-tab-pane" type="button" role="tab"
                                    aria-controls="profile-tab-pane"
                                    aria-selected="true">{{ __('Profile Information') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="password-tab" data-bs-toggle="tab"
                                    data-bs-target="#password-tab-pane" type="button" role="tab"
                                    aria-controls="password-tab-pane"
                                    aria-selected="false">{{ __('Update Password') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="passcode-tab" data-bs-toggle="tab"
                                    data-bs-target="#passcode-tab-pane" type="button" role="tab"
                                    aria-controls="passcode-tab-pane"
                                    aria-selected="false">{{ __('Update Passcode') }}</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel"
                                aria-labelledby="profile-tab" tabindex="0">

                                <div class="alert alert-light alert-dismissible fade show" role="alert">
                                    <p class="card-text text-muted">
                                        {{ __("Update your account's profile information and email address.") }}
                                    </p>
                                </div>

                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                </form>

                                <form method="post" action="{{ route('profile.update') }}" class="mt-3">
                                    @csrf
                                    @method('patch')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('Name') }}</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                        @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="username" class="form-label">{{ __('Username') }}</label>
                                        <input id="username" name="username" type="text" class="form-control"
                                            value="{{ old('username', $user->username) }}" required
                                            autocomplete="username">
                                        @error('username')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('Email') }}</label>
                                        <input id="email" name="email" type="email" class="form-control"
                                            value="{{ old('email', $user->email) }}" autocomplete="email">
                                        @error('email')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                            <div class="mt-2">
                                                <p class="text-sm text-muted">
                                                    {{ __('Your email address is unverified.') }}

                                                    <button form="send-verification"
                                                        class="btn btn-link p-0 m-0 align-baseline">
                                                        {{ __('Click here to re-send the verification email.') }}
                                                    </button>
                                                </p>

                                                @if (session('status') === 'verification-link-sent')
                                                    <p class="mt-2 text-success">
                                                        {{ __('A new verification link has been sent to your email address.') }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="password-tab-pane" role="tabpanel"
                                aria-labelledby="password-tab" tabindex="0">

                                <div class="alert alert-light alert-dismissible fade show" role="alert">
                                    <p class="card-text text-muted">
                                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                                    </p>
                                </div>

                                <form method="post" action="{{ route('password.update') }}" class="mt-3">
                                    @csrf
                                    @method('put')

                                    <div class="mb-3">
                                        <label for="update_password_current_password"
                                            class="form-label">{{ __('Current Password') }}</label>
                                        <input id="update_password_current_password" name="current_password"
                                            type="password" class="form-control" autocomplete="current-password">
                                        @error('current_password', 'updatePassword')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="update_password_password"
                                            class="form-label">{{ __('New Password') }}</label>
                                        <input id="update_password_password" name="password" type="password"
                                            class="form-control" autocomplete="new-password">
                                        @error('password', 'updatePassword')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="update_password_password_confirmation"
                                            class="form-label">{{ __('Confirm Password') }}</label>
                                        <input id="update_password_password_confirmation" name="password_confirmation"
                                            type="password" class="form-control" autocomplete="new-password">
                                        @error('password_confirmation', 'updatePassword')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="passcode-tab-pane" role="tabpanel"
                                aria-labelledby="passcode-tab" tabindex="0">

                                <div class="alert alert-light alert-dismissible fade show" role="alert">
                                    <p class="card-text text-muted">
                                        {{ __('Ensure your account is using a 4-digit passcode.') }}
                                    </p>
                                </div>

                                <form method="post" action="{{ route('profile.passcode.update') }}" class="mt-3">
                                    @csrf
                                    @method('put')

                                    @if (Auth::user()->passcode)
                                        <div class="mb-3">
                                            <label for="current_passcode"
                                                class="form-label">{{ __('Current Passcode') }}</label>
                                            <input id="current_passcode" name="current_passcode" type="password"
                                                class="form-control" autocomplete="current-passcode" maxlength="4">
                                            @error('current_passcode', 'updatePasscode')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="passcode" class="form-label">{{ __('New Passcode') }}</label>
                                        <input id="passcode" name="passcode" type="password" class="form-control"
                                            autocomplete="new-passcode" maxlength="6">
                                        @error('passcode', 'updatePasscode')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="passcode_confirmation"
                                            class="form-label">{{ __('Confirm Passcode') }}</label>
                                        <input id="passcode_confirmation" name="passcode_confirmation" type="password"
                                            class="form-control" autocomplete="new-passcode" maxlength="6">
                                        @error('passcode_confirmation', 'updatePasscode')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
