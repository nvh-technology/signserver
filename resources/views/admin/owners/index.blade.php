@extends('layouts.admin')

@section('title', 'Tổ chức')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Owners') }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Tổ chức</h2>
        @can('manage owners')
            <a href="{{ route('admin.owners.create') }}" class="btn btn-primary">Thêm tổ chức mới</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
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
                                        <a href="{{ route('admin.owners.downloadConfig', $owner->id) }}" target="_blank">Tải
                                            tệp</a>
                                    @else
                                        Không có
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.owners.show', $owner->id) }}"
                                        class="btn btn-sm btn-info">Xem</a>
                                    @can('manage owners')
                                        <a href="{{ route('admin.owners.edit', $owner->id) }}"
                                            class="btn btn-sm btn-warning">Sửa</a>
                                        <form action="{{ route('admin.owners.destroy', $owner->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Bạn có chắc chắn không?')">Xóa</button>
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
            </div>
        </div>
    </div>
@endsection
