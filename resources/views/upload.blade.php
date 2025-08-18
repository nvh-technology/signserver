@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                            aria-label="Slide 4"></button>
                    </div>
                    <div class="carousel-inner rounded-3">
                        <div class="carousel-item active" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/1.png') }}" class="d-block w-100" alt="Slide 1">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/2.png') }}" class="d-block w-100" alt="Slide 2">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/3.png') }}" class="d-block w-100" alt="Slide 3">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/4.png') }}" class="d-block w-100" alt="Slide 4">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-5">
                @auth
                    <div class="card p-4 card-signserver shadow">
                        <h4 class="card-title text-center">TÂN HƯNG SIGNSERVER</h4>
                        <hr>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('fail'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('fail') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

                        <form id="upload-form-sign" action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="signature_page" id="signature_page">
                            <input type="hidden" name="signature_position" id="signature_position">
                            <div class="mb-3">
                                <label for="file_to_sign" class="form-label">File cần ký</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="file_to_sign" name="file_to_sign" required
                                        accept=".pdf">
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-secondary" id="select-position-btn" style="display: none;"
                                    data-bs-toggle="modal" data-bs-target="#pdf-modal">
                                    Chọn vị trí ký
                                </button>
                                <span id="selected-position-info"></span>
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
                                    (.pdf)
                                </li>
                                <li>(Tùy chọn) Bấm **Chọn vị trí ký** để đặt chữ ký vào vị trí mong muốn.</li>
                                <li>Bấm nút **Ký dữ liệu** để ký</li>
                            </ol>
                        </div>
                    </div>
                @endauth

                @guest
                    <div class="card p-4 shadow">
                        <h4 class="card-title text-center">Đăng nhập để sử dụng SignServer</h4>
                        <hr>
                        @if (session('status'))
                            <div class="alert alert-success mb-3 rounded-0" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">Ghi nhớ đăng nhập</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Đăng nhập</button>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">Quên mật
                                        khẩu?</a>
                                </div>
                            @endif
                        </form>
                    </div>
                @endguest
            </div>

        </div>
    </div>

    <!-- PDF Modal -->
    <div class="modal fade" id="pdf-modal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Chọn vị trí ký</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="pdf-viewer" style="overflow: auto; max-height: 75vh; border: 1px solid #ccc;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="save-position-btn" data-bs-dismiss="modal">Lưu
                        vị trí</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.worker.min.js";
        const fileInput = document.getElementById('file_to_sign');
        const selectPosBtn = document.getElementById('select-position-btn');
        const pdfViewer = document.getElementById('pdf-viewer');
        const signaturePageInput = document.getElementById('signature_page');
        const signaturePositionInput = document.getElementById('signature_position');
        const selectedPositionInfo = document.getElementById('selected-position-info');

        let pdfDoc = null;
        let selectedPage = null;
        let selectedPosition = null;
        const signatureBoxSize = {
            width: 170,
            height: 70
        };

        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                selectPosBtn.style.display = 'inline-block';
            } else {
                selectPosBtn.style.display = 'none';
            }
            selectedPositionInfo.textContent = '';
            signaturePageInput.value = null;
            signaturePositionInput.value = null;
        });

        selectPosBtn.addEventListener('click', function() {
            const file = fileInput.files[0];
            if (!file) return;

            const fileReader = new FileReader();
            fileReader.onload = function() {
                const typedarray = new Uint8Array(this.result);
                pdfjsLib.getDocument(typedarray).promise.then(pdf => {
                    pdfDoc = pdf;
                    renderAllPages();
                });
            };
            fileReader.readAsArrayBuffer(file);
        });

        function renderAllPages() {
            pdfViewer.innerHTML = '';
            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                pdfDoc.getPage(pageNum).then(page => {
                    const canvas = document.createElement('canvas');
                    canvas.dataset.pageNumber = pageNum;
                    const context = canvas.getContext('2d');
                    const viewport = page.getViewport({
                        scale: 1.5
                    });
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext);
                    pdfViewer.appendChild(canvas);

                    canvas.addEventListener('click', function(e) {
                        selectedPage = parseInt(canvas.dataset.pageNumber);
                        const rect = canvas.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;

                        const originalViewport = page.getViewport({
                            scale: 1
                        });
                        let pdfX = (x / viewport.width) * originalViewport.width;
                        let pdfY = originalViewport.height - (y / viewport.height) * originalViewport
                            .height;

                        if (pdfX + signatureBoxSize.width > originalViewport.width) {
                            pdfX = originalViewport.width - signatureBoxSize.width;
                        }

                        if (pdfY - signatureBoxSize.height < 0) {
                            pdfY = signatureBoxSize.height;
                        }

                        const llx = pdfX;
                        const lly = pdfY - signatureBoxSize.height;
                        const urx = pdfX + signatureBoxSize.width;
                        const ury = pdfY;

                        selectedPosition =
                            `${llx.toFixed(2)},${lly.toFixed(2)},${urx.toFixed(2)},${ury.toFixed(2)}`;

                        // Redraw all pages to clear previous selections
                        renderAllPagesAndHighlight();
                    });
                });
            }
        }

        function renderAllPagesAndHighlight() {
            pdfViewer.innerHTML = '';
            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                pdfDoc.getPage(pageNum).then(page => {
                    const canvas = document.createElement('canvas');
                    canvas.dataset.pageNumber = pageNum;
                    const context = canvas.getContext('2d');
                    const viewport = page.getViewport({
                        scale: 1.5
                    });
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext).promise.then(() => {
                        if (pageNum === selectedPage && selectedPosition) {
                            const pos = selectedPosition.split(',');
                            const originalViewport = page.getViewport({
                                scale: 1
                            });
                            const x = parseFloat(pos[0]) * viewport.width / originalViewport.width;
                            const y = (originalViewport.height - parseFloat(pos[3])) * viewport.height /
                                originalViewport.height;
                            const width = signatureBoxSize.width * viewport.width / originalViewport.width;
                            const height = signatureBoxSize.height * viewport.height / originalViewport
                                .height;

                            context.strokeStyle = 'red';
                            context.lineWidth = 2;
                            context.strokeRect(x, y, width, height);
                        }
                    });

                    pdfViewer.appendChild(canvas);

                    canvas.addEventListener('click', function(e) {
                        selectedPage = parseInt(canvas.dataset.pageNumber);
                        const rect = canvas.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;

                        const originalViewport = page.getViewport({
                            scale: 1
                        });
                        let pdfX = (x / viewport.width) * originalViewport.width;
                        let pdfY = originalViewport.height - (y / viewport.height) * originalViewport
                            .height;

                        if (pdfX + signatureBoxSize.width > originalViewport.width) {
                            pdfX = originalViewport.width - signatureBoxSize.width;
                        }

                        if (pdfY - signatureBoxSize.height < 0) {
                            pdfY = signatureBoxSize.height;
                        }

                        const llx = pdfX;
                        const lly = pdfY - signatureBoxSize.height;
                        const urx = pdfX + signatureBoxSize.width;
                        const ury = pdfY;

                        selectedPosition =
                            `${llx.toFixed(2)},${lly.toFixed(2)},${urx.toFixed(2)},${ury.toFixed(2)}`;

                        // Redraw all pages to clear previous selections
                        renderAllPagesAndHighlight();
                    });
                });
            }
        }


        document.getElementById('save-position-btn').addEventListener('click', function() {
            if (selectedPage && selectedPosition) {
                signaturePageInput.value = selectedPage;
                signaturePositionInput.value = selectedPosition;
                selectedPositionInfo.textContent = `Đã chọn vị trí ở trang ${selectedPage}`;
            }
        });

        document.querySelector('#upload-form-sign').addEventListener('submit', function(e) {
            if (!signaturePositionInput.value) {
                e.preventDefault();
                alert('Vui lòng chọn vị trí ký');
            }
        });
    </script>
@endpush
