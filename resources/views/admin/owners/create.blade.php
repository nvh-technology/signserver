@extends('layouts.admin')

@section('title', 'Tạo tổ chức')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.owners.index') }}">{{ __('Owners') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
        </ol>
    </nav>

    <h2 class="mb-4">Tạo tổ chức mới</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg">
        <div class="card-body">
            <form action="{{ route('admin.owners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Tên tổ chức</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="fileConfig" class="form-label">File Config</label>
                    <input type="file" class="form-control" id="fileConfig" name="fileConfig" required>
                </div>
                <div class="mb-4">
                    <label for="keystoreFile" class="form-label">Keystore File</label>
                    <input type="file" class="form-control" id="keystoreFile" name="keystoreFile" required>
                </div>
                <button type="submit" class="btn btn-primary">Tạo</button>
                <a href="{{ route('admin.owners.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
