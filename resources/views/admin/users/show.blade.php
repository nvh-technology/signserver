@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
    <h1>User Details</h1>

    <div class="card mb-3">
        <div class="card-header">
            User Information
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>ID:</strong> {{ $user->id }}</p>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ $user->created_at }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ $user->updated_at }}</p>
        </div>
    </div>

    @if ($user->backgroundSignature)
        <div class="card mb-3">
            <div class="card-header">
                Background Signature
            </div>
            <div class="card-body">
                <img src="{{ route('admin.users.backgroundSignature', $user) }}" alt="Background Signature" class="img-fluid">
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Assigned Owners
        </div>
        <div class="card-body">
            @if ($user->owners->count() > 0)
                <ul class="list-group">
                    @foreach ($user->owners as $owner)
                        <li class="list-group-item">
                            <strong>{{ $owner->name }}</strong> (ID: {{ $owner->id }})
                            <ul>
                                <li>User Name: {{ $owner->pivot->userName }}</li>
                                <li>Passcode: {{ $owner->pivot->passcode }}</li>
                                <li>Credential ID: {{ $owner->pivot->credentialID }}</li>
                            </ul>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No owners assigned to this user.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Back to User List</a>
@endsection