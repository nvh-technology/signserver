@extends('layouts.admin')

@section('title', 'Chi tiết người dùng')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Show') }}</li>
        </ol>
    </nav>

    <h2>Chi tiết người dùng</h2>

    <div class="card mb-3">
        <div class="card-header">
            Thông tin người dùng
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>Tên đăng nhập:</strong> {{ $user->username }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Ngày tạo:</strong> {{ $user->created_at }}</p>
            <p class="card-text"><strong>Ngày cập nhật:</strong> {{ $user->updated_at }}</p>
        </div>
    </div>

    @if ($user->backgroundSignature)
        <div class="card mb-3">
            <div class="card-header">
                Chữ ký nền
            </div>
            <div class="card-body">
                <img src="{{ route('admin.users.backgroundSignature', $user) }}" alt="Chữ ký nền" class="img-fluid">
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Tổ chức được gán
        </div>
        <div class="card-body">
            @if ($user->owners->count() > 0)
                <ul class="list-group">
                    @foreach ($user->owners as $owner)
                        <li class="list-group-item">
                            <strong>{{ $owner->name }}</strong> (ID: {{ $owner->id }})
                            <ul>
                                <li>Tên người dùng: {{ $owner->pivot->userName }}</li>
                                <li>Mã OTP: {{ $owner->pivot->passcode }}</li>
                                <li>Credential ID: {{ $owner->pivot->credentialID }}</li>
                            </ul>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Không có tổ chức nào được gán cho người dùng này.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách người dùng</a>
@endsection
