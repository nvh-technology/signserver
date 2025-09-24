@extends('layouts.admin')

@section('title', 'Chi tiết người dùng')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Show') }}</li>
        </ol>
    </nav>

    <h2>Chi tiết người dùng</h2>

    <div class="card shadow-lg">
        <div class="card-header py-3">
            <ul class="nav nav-pills" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                        data-bs-target="#details-tab-pane" type="button" role="tab"
                        aria-controls="details-tab-pane" aria-selected="true">{{ __('User Details') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="history-tab" data-bs-toggle="tab"
                        data-bs-target="#history-tab-pane" type="button" role="tab"
                        aria-controls="history-tab-pane" aria-selected="false">{{ __('File History') }}</button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="details-tab-pane" role="tabpanel"
                    aria-labelledby="details-tab" tabindex="0">

                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text"><strong>Tên đăng nhập:</strong> {{ $user->username }}</p>
                    <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="card-text"><strong>Ngày tạo:</strong> {{ $user->created_at }}</p>
                    <p class="card-text"><strong>Ngày cập nhật:</strong> {{ $user->updated_at }}</p>

                    @if ($user->backgroundSignature)
                        <div class="card mb-3">
                            <div class="card-header">
                                Chữ ký nền
                            </div>
                            <div class="card-body">
                                <img src="{{ route('admin.users.backgroundSignature', $user) }}" alt="Chữ ký nền"
                                    class="img-fluid">
                            </div>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            Tổ chức được gán
                        </div>
                        <div class="card-body">
                            @if ($user->owners->count() > 0)
                                <ul class="list-group">
                                    @foreach ($user->owners as $owner)
                                        <li class="list-group-item">
                                            <strong>{{ $owner->name }}</strong> (ID: {{ $owner->id }})
                                            <ul>
                                                <li>Tên người dùng: {{ $owner->pivot->userName }}</li>
                                                <li>Mã OTP: {{ $owner->pivot->passcode }}</li>
                                                <li>Credential ID: {{ $owner->pivot->credentialID }}</li>
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Không có tổ chức nào được gán cho người dùng này.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab"
                    tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('File Name') }}</th>
                                    <th>{{ __('Signed At') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($userFiles as $file)
                                    <tr>
                                        <td>{{ $file->original_file_name }}</td>
                                        <td>{{ $file->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('user-files.download', $file) }}"
                                                class="btn btn-sm btn-primary">{{ __('Download Signed') }}</a>
                                            <a href="{{ route('user-files.download-original', $file) }}"
                                                class="btn btn-sm btn-secondary">{{ __('Download Original') }}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">{{ __('No files found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $userFiles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách người dùng</a>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('button[data-bs-toggle="tab"]');
            tabButtons.forEach(button => {
                button.addEventListener('shown.bs.tab', event => {
                                    console.log(1111111111111);

                    localStorage.setItem('activeUserShowTab', event.target.id);
                });
            });

            const savedTabId = localStorage.getItem('activeUserShowTab');
            if (savedTabId) {
                const savedTab = document.getElementById(savedTabId);
                if (savedTab) {
                    const tab = new bootstrap.Tab(savedTab);
                    tab.show();
                }
            }
        });
    </script>
@endpush
