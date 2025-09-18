@extends('layouts.admin')

@section('title', 'Người dùng')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Người dùng</h1>
        @can('manage users')
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Thêm người dùng mới</a>
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
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Chữ ký nền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->backgroundSignature)
                            <img src="{{ route('admin.users.backgroundSignature', $user) }}" alt="Chữ ký nền" width="100">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">Xem</a>
                        @can('manage users')
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="{{ route('admin.users.editRoles', $user->id) }}" class="btn btn-sm btn-secondary">Quản lý vai trò</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn không?')">Xóa</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Không tìm thấy người dùng nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection