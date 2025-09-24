<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tân Hưng Signserver')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}" />
</head>

<body>

    <header class="top-header bg-primary py-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center text-white">
                    <span>871 Trần Xuân Soạn - Phường Tân Hưng - Tp. Hồ Chí Minh</span>
                </div>
            </div>
        </div>
    </header>


    <header class="main-header shadow py-2">
        <nav class="navbar navbar-expand-lg navbar-light bg-light bg-transparent">
            <div class="container">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <a class="navbar-brand" href="/">
                        <span class="logo">
                            <img src="{{ asset('images/logo.jpg') }}" style="max-height: 80px;" class="img-fluid" alt="">
                        </span>
                    </a>
                    <div class="w-100 text-end">
                        @if (request()->user())
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                aria-label="Chuyển đổi điều hướng">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                                <ul class="navbar-nav align-items-center">
                                    @role('admin')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.users.index') }}">Quản lý người dùng</a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.edit') }}">
                                            {{ request()->user()->name }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="nav-link" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                                Đăng xuất
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <span class="title">PHẦN MỀM KÝ SỐ</span>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
