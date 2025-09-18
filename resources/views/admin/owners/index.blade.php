@extends('layouts.admin')

@section('title', 'Tổ chức')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Tổ chức</h1>
        @can('manage owners')
            <a href="{{ route('admin.owners.create') }}" class="btn btn-primary">Thêm tổ chức mới</a>
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
                <th>File Config</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($owners as $owner)
                <tr>
                    <td>{{ $owner->id }}</td>
                    <td>{{ $owner->name }}</td>
                    <td>
                        @if ($owner->fileConfig)
                            <a href="{{ route('admin.owners.downloadConfig', $owner->id) }}" target="_blank">Tải tệp</a>
                        @else
                            Không có
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.owners.show', $owner->id) }}" class="btn btn-sm btn-info">Xem</a>
                        @can('manage owners')
                            <a href="{{ route('admin.owners.edit', $owner->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('admin.owners.destroy', $owner->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn không?')">Xóa</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Không tìm thấy tổ chức nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
