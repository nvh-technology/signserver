@extends('layouts.admin')

@section('title', 'Chi tiết tổ chức')

@section('content')
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.owners.index') }}">{{ __('Owners') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Show') }}</li>
        </ol>
    </nav>

    <h2>Chi tiết tổ chức</h2>

    <div class="card mb-3">
        <div class="card-header">
            Thông tin tổ chức
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $owner->name }}</h5>
            <p class="card-text"><strong>ID:</strong> {{ $owner->id }}</p>
            <p class="card-text"><strong>File Config:</strong>
                @if ($owner->fileConfig)
                    <a href="{{ route('admin.owners.downloadConfig', $owner->id) }}" target="_blank">{{ basename($owner->fileConfig) }}</a>
                @else
                    Không có
                @endif
            </p>
            <p class="card-text"><strong>Keystore File:</strong>
                @if ($owner->keystoreFile)
                    <a href="{{ route('admin.owners.downloadKeystore', $owner->id) }}" target="_blank">{{ basename($owner->keystoreFile) }}</a>
                @else
                    Không có
                @endif
            </p>
            <p class="card-text"><strong>Ngày tạo:</strong> {{ $owner->created_at }}</p>
            <p class="card-text"><strong>Ngày cập nhật:</strong> {{ $owner->updated_at }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Người dùng liên quan
        </div>
        <div class="card-body">
            @if ($owner->users->count() > 0)
                <ul class="list-group">
                    @foreach ($owner->users as $user)
                        <li class="list-group-item">{{ $user->name }} ({{ $user->email }})</li>
                    @endforeach
                </ul>
            @else
                <p>Không có người dùng nào được liên kết với tổ chức này.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.owners.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách tổ chức</a>
@endsection
