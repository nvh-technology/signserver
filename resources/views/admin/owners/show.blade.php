@extends('layouts.admin')

@section('title', 'Owner Details')

@section('content')
    <h1>Owner Details</h1>

    <div class="card mb-3">
        <div class="card-header">
            Owner Information
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $owner->name }}</h5>
            <p class="card-text"><strong>ID:</strong> {{ $owner->id }}</p>
            <p class="card-text"><strong>File Config:</strong>
                @if ($owner->fileConfig)
                    <a href="{{ route('admin.owners.downloadConfig', $owner->id) }}" target="_blank">{{ basename($owner->fileConfig) }}</a>
                @else
                    N/A
                @endif
            </p>
            <p class="card-text"><strong>Keystore File:</strong>
                @if ($owner->keystoreFile)
                    <a href="{{ route('admin.owners.downloadKeystore', $owner->id) }}" target="_blank">{{ basename($owner->keystoreFile) }}</a>
                @else
                    N/A
                @endif
            </p>
            <p class="card-text"><strong>Created At:</strong> {{ $owner->created_at }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ $owner->updated_at }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Associated Users
        </div>
        <div class="card-body">
            @if ($owner->users->count() > 0)
                <ul class="list-group">
                    @foreach ($owner->users as $user)
                        <li class="list-group-item">{{ $user->name }} ({{ $user->email }})</li>
                    @endforeach
                </ul>
            @else
                <p>No users associated with this owner.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.owners.index') }}" class="btn btn-secondary mt-3">Back to Owners</a>
@endsection
