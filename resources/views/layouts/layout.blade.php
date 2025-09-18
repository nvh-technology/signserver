<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tân Hưng Signserver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .top-header {
            background-color: #2c3e50;
            color: #fff;
            padding: 5px 0;
            font-size: 0.9rem;
        }

        .main-header {
            background-color: #fff;
            padding: 10px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .main-header .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }

        .main-header .title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .carousel-item img {
            height: 450px;
            /* Điều chỉnh chiều cao của slider */
            object-fit: cover;
        }

        .card-signserver {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <header class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <span>871 Trần Xuân Soạn - Phường Tân Hưng - Tp. Hồ Chí Minh</span>
                </div>
            </div>
        </div>
    </header>

    <header class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span class="logo">Tân Hưng</span>
                </div>
                <div class="col-md-6 text-end">
                    <span class="title">PHẦN MỀM KÝ SỐ</span>
                </div>
            </div>
        </div>
    </header>

    <main class="py-4">
        <div class="container">
            <div class="row">

                <div class="col-md-7">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Trang trình bày 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                aria-label="Trang trình bày 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                aria-label="Trang trình bày 3"></button>
                        </div>
                        <div class="carousel-inner rounded-3">
                            <div class="carousel-item active">
                                <img src="https://via.placeholder.com/1000x450/007bff/ffffff?text=Slide+1"
                                    class="d-block w-100" alt="Trang trình bày 1">
                            </div>
                            <div class="carousel-item">
                                <img src="https://via.placeholder.com/1000x450/6c757d/ffffff?text=Slide+2"
                                    class="d-block w-100" alt="Trang trình bày 2">
                            </div>
                            <div class="carousel-item">
                                <img src="https://via.placeholder.com/1000x450/28a745/ffffff?text=Slide+3"
                                    class="d-block w-100" alt="Trang trình bày 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Trước</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Tiếp theo</span>
                        </button>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card p-4 card-signserver">
                        <h4 class="card-title text-center">TÂN HƯNG SIGNSERVER</h4>
                        <hr>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('fail'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('fail') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file_to_sign" class="form-label">File cần ký</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="file_to_sign" name="file_to_sign"
                                        required accept=".pdf,.docx,.xlsx,.pptx,.xml,.txt">
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Ký dữ liệu</button>
                            </div>
                        </form>

                        <hr class="mt-4">

                        <div class="mt-4">
                            <h6>HƯỚNG DẪN KÝ TÀI LIỆU</h6>
                            <ol>
                                <li>Bấm nút **Browse** để chọn tệp dữ liệu. SignServer hỗ trợ các định dạng dữ liệu
                                    (.pdf, .docx, .xlsx, .pptx, .xml, .txt)</li>
                                <li>Bấm nút **Ký dữ liệu** để ký</li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
