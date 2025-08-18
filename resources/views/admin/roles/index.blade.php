@extends('layouts.admin')

@section('title', 'Roles')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Roles</h1>
        @can('manage roles')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Add New Role</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach ($role->permissions as $permission)
                            <span class="badge bg-info">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @can('manage roles')
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No roles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection