@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
    <h1>Create New User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Assign Owners</label>
            <div id="owners-container">
                @foreach ($owners as $owner)
                <div class="form-check mb-2">
                    <input class="form-check-input owner-checkbox" type="checkbox" name="owners[]" value="{{ $owner->id }}" id="owner_{{ $owner->id }}" {{ in_array($owner->id, old('owners', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="owner_{{ $owner->id }}">
                        {{ $owner->name }}
                    </label>
                </div>
                <div class="owner-pivot-fields card card-body bg-light mb-3" id="pivot_fields_{{ $owner->id }}" style="display: {{ in_array($owner->id, old('owners', [])) ? 'block' : 'none' }};">
                    <h6 class="card-title">Details for {{ $owner->name }}</h6>
                    <div class="mb-3">
                        <label for="userName_{{ $owner->id }}" class="form-label">User Name:</label>
                        <input type="text" class="form-control" name="owner_pivot[{{ $owner->id }}][userName]" id="userName_{{ $owner->id }}" value="{{ old('owner_pivot.' . $owner->id . '.userName') }}">
                    </div>
                    <div class="mb-3">
                        <label for="passcode_{{ $owner->id }}" class="form-label">Passcode:</label>
                        <input type="text" class="form-control" name="owner_pivot[{{ $owner->id }}][passcode]" id="passcode_{{ $owner->id }}" value="{{ old('owner_pivot.' . $owner->id . '.passcode') }}">
                    </div>
                    <div class="mb-3">
                        <label for="credentialID_{{ $owner->id }}" class="form-label">Credential ID:</label>
                        <input type="text" class="form-control" name="owner_pivot[{{ $owner->id }}][credentialID]" id="credentialID_{{ $owner->id }}" value="{{ old('owner_pivot.' . $owner->id . '.credentialID') }}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.owner-checkbox').forEach(function (checkbox) {
            var pivotFields = document.getElementById('pivot_fields_' + checkbox.value);
            // Initial state based on whether it's checked (e.g., from old input)
            if (checkbox.checked) {
                pivotFields.style.display = 'block';
            }

            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    pivotFields.style.display = 'block';
                } else {
                    pivotFields.style.display = 'none';
                    // Clear input values when unchecked
                    pivotFields.querySelectorAll('input').forEach(function(input) {
                        input.value = '';
                    });
                }
            });
        });
    });
</script>
@endsection
