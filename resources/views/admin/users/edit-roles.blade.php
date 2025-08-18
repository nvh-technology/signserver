@extends('layouts.admin')

@section('title', 'Edit User Roles')

@section('content')
    <h1>Edit Roles for User: {{ $user->name }}</h1>

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
            <label class="form-label">Roles</label>
            @foreach ($roles as $role)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                    <label class="form-check-label" for="role_{{ $role->id }}">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Update Roles</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection