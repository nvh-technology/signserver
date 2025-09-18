@extends('layouts.admin')

@section('title', 'Chỉnh sửa vai trò người dùng')

@section('content')
    <h1>Chỉnh sửa vai trò cho người dùng: {{ $user->name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.updateRoles', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Vai trò</label>
            @foreach ($roles as $role)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                    <label class="form-check-label" for="role_{{ $role->id }}">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật vai trò</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection