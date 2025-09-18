@extends('layouts.admin')

@section('title', 'Vai trò')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Vai trò</h1>
        @can('manage roles')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Thêm vai trò mới</a>
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
                <th>Tên</th>
                <th>Quyền</th>
                <th>Hành động</th>
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
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn không?')">Xóa</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Không tìm thấy vai trò nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection