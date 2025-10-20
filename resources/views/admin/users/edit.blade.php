@extends('layouts.admin')

@section('title', 'Chỉnh sửa người dùng')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
        </ol>
    </nav>

    <h2 class="mb-4">Chỉnh sửa người dùng</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg">
        <div class="card-body">

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h5>Thông tin người dùng</h5>
                <hr>
                <div class="mb-3">
                    <label for="name" class="form-label">Tên</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="{{ old('username', $user->username) }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ old('email', $user->email) }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu (để trống nếu không đổi)</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="passcode" class="form-label">Mã OTP (4 chữ số, để trống nếu không đổi)</label>
                    <input type="password" class="form-control" id="passcode" name="passcode" maxlength="4"
                        autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="backgroundSignature" class="form-label">Chữ ký nền (chỉ PNG)</label>
                    <input type="file" class="form-control" id="backgroundSignature" name="backgroundSignature"
                        accept=".png">
                    @if ($user->backgroundSignature)
                        <div class="mt-2">
                            <p>Chữ ký nền hiện tại:</p>
                            <img src="{{ route('users.backgroundSignature', $user) }}?{{ rand() }}" alt="Background Signature"
                                width="150">
                        </div>
                    @endif
                </div>

                <h5 class="mt-4">Thông tin tổ chức</h5>
                <hr>
                <div class="mb-3">
                    <label class="form-label">Gán tổ chức</label>
                    <div id="owners-container">
                        @foreach ($owners as $owner)
                            @php
                                $isAssigned = $user->owners->contains($owner->id);
                                $pivotData = $isAssigned
                                    ? $user->owners->where('id', $owner->id)->first()->pivot
                                    : null;
                            @endphp
                            <div class="form-check mb-2">
                                <input class="form-check-input owner-checkbox" type="checkbox" name="owners[]"
                                    value="{{ $owner->id }}" id="owner_{{ $owner->id }}"
                                    {{ old('owners') ? (in_array($owner->id, old('owners')) ? 'checked' : '') : ($isAssigned ? 'checked' : '') }}>
                                <label class="form-check-label" for="owner_{{ $owner->id }}">
                                    {{ $owner->name }}
                                </label>
                            </div>
                            <div class="owner-pivot-fields card card-body bg-light mb-3"
                                id="pivot_fields_{{ $owner->id }}"
                                style="display: {{ old('owners') ? (in_array($owner->id, old('owners')) ? 'block' : 'none') : ($isAssigned ? 'block' : 'none') }};">
                                <h6 class="card-title">Chi tiết cho {{ $owner->name }}</h6>
                                <div class="mb-3">
                                    <label for="userName_{{ $owner->id }}" class="form-label">User ID:</label>
                                    <input type="text" class="form-control"
                                        name="owner_pivot[{{ $owner->id }}][userName]"
                                        id="userName_{{ $owner->id }}"
                                        value="{{ old('owner_pivot.' . $owner->id . '.userName', $pivotData ? $pivotData->userName : '') }}"
                                        autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label for="passcode_{{ $owner->id }}" class="form-label">Passcode:</label>
                                    <input type="text" class="form-control"
                                        name="owner_pivot[{{ $owner->id }}][passcode]"
                                        id="passcode_{{ $owner->id }}"
                                        value="{{ old('owner_pivot.' . $owner->id . '.passcode', $pivotData ? $pivotData->passcode : '') }}"
                                        autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label for="credentialID_{{ $owner->id }}" class="form-label">Credential
                                        ID:</label>
                                    <input type="text" class="form-control"
                                        name="owner_pivot[{{ $owner->id }}][credentialID]"
                                        id="credentialID_{{ $owner->id }}"
                                        value="{{ old('owner_pivot.' . $owner->id . '.credentialID', $pivotData ? $pivotData->credentialID : '') }}"
                                        autocomplete="off">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.owner-checkbox').forEach(function(checkbox) {
                var pivotFields = document.getElementById('pivot_fields_' + checkbox.value);
                // Initial state based on whether it's checked (e.g., from old input or existing relationship)
                if (checkbox.checked) {
                    pivotFields.style.display = 'block';
                }

                checkbox.addEventListener('change', function() {
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
