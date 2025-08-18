@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
    <h1>Edit Role: {{ $role->name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Permissions</label>
            @foreach ($permissions as $permission)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" {{ (in_array($permission->name, old('permissions', $role->permissions->pluck('name')->toArray()))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Update Role</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection