@extends('layouts.admin')

@section('title', 'Tạo vai trò')

@section('content')
    <h1>Tạo vai trò mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên vai trò</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Quyền</label>
            @foreach ($permissions as $permission)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Tạo vai trò</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection