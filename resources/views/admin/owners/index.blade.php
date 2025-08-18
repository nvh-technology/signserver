@extends('layouts.admin')

@section('title', 'Owners')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Owners</h1>
        @can('manage owners')
            <a href="{{ route('admin.owners.create') }}" class="btn btn-primary">Add New Owner</a>
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
                <th>File Config</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($owners as $owner)
                <tr>
                    <td>{{ $owner->id }}</td>
                    <td>{{ $owner->name }}</td>
                    <td>
                        @if ($owner->fileConfig)
                            <a href="{{ route('admin.owners.downloadConfig', $owner->id) }}" target="_blank">Download File</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.owners.show', $owner->id) }}" class="btn btn-sm btn-info">View</a>
                        @can('manage owners')
                            <a href="{{ route('admin.owners.edit', $owner->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.owners.destroy', $owner->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No owners found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
