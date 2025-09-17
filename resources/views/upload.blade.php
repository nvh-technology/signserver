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
                            <img src="{{ asset('images/carousel/1.jpg') }}" style="aspect-ratio: 5/3;"
                                class="object-fit-cover d-block w-100" alt="Slide 1">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/2.jpg') }}" style="aspect-ratio: 5/3;"
                                class="object-fit-cover d-block w-100" alt="Slide 2">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/3.jpg') }}" style="aspect-ratio: 5/3;"
                                class="object-fit-cover d-block w-100" alt="Slide 3">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/4.jpg') }}" style="aspect-ratio: 5/3;"
                                class="object-fit-cover d-block w-100" alt="Slide 4">
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

                        <form id="upload-form-sign" action="{{ route('upload.file') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="signature_page" id="signature_page">
                            <input type="hidden" name="signature_position" id="signature_position">
                            <div class="mb-3">
                                <label for="file_to_sign" class="form-label">File cần ký</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="file_to_sign" name="file_to_sign" required
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="owner_id" class="form-label">Tổ chức</label>
                                <select class="form-select" id="owner_id" name="owner_id" required>
                                    @foreach ($owners as $owner)
                                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="pdf-options">
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Lý do ký</label>
                                    <input type="text" class="form-control" id="reason" name="reason"
                                        value="Ký hợp đồng điện tử">
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Nơi ký</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                        value="Hồ Chí Minh">
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-secondary" id="select-position-btn"
                                    data-bs-toggle="modal" data-bs-target="#pdf-modal">
                                    Chọn vị trí ký
                                </button>
                                <span id="selected-position-info"></span>
                                <button type="submit" id="sign-btn" class="btn btn-primary btn-lg"
                                    style="display: none">Ký dữ liệu</button>
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
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username') }}" required autofocus>
                                @error('username')
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

                            {{-- <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">Ghi nhớ đăng nhập</label>
                            </div> --}}

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
                <div class="modal-body bg-light p-0">
                    <div id="pdf-viewer"
                        style="overflow-y: scroll;overflow-x: clip;max-height: 75vh;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdn.jsdelivr.net/npm/pdfjs-dist@2.16.105/build/pdf.worker.min.js";

        // Khai báo các biến DOM
        const fileInput = document.getElementById('file_to_sign');
        const selectPosBtn = document.getElementById('select-position-btn');
        const pdfViewer = document.getElementById('pdf-viewer');
        const signaturePageInput = document.getElementById('signature_page');
        const signaturePositionInput = document.getElementById('signature_position');
        const selectedPositionInfo = document.getElementById('selected-position-info');
        const pdfModal = document.getElementById('pdf-modal'); // Thêm ID modal
        const signBtn = document.getElementById('sign-btn');

        // Khai báo các biến trạng thái
        let pdfDoc = null;
        let selectedPage = null;
        let selectedPosition = null;
        const signatureBoxSize = {
            width: 170,
            height: 70
        };
        let signatureHighlight = null;
        const pageData = {}; // { pageNum: { viewport: originalViewport, canvas: canvasElement } }

        function savePosition() {
            signBtn.style.display = 'none';
            if (selectedPage && selectedPosition) {
                signaturePageInput.value = selectedPage;
                signaturePositionInput.value = selectedPosition;
                selectedPositionInfo.textContent = `Đã chọn vị trí ở trang ${selectedPage}`;
                signBtn.style.display = 'block';
            }
        }

        function clearSavedPosition() {
            selectedPage = null;
            selectedPosition = null;
            signaturePageInput.value = '';
            signaturePositionInput.value = '';
            selectedPositionInfo.textContent = '';
            signBtn.style.display = 'none';
            clearHighlight();
        }

        fileInput.addEventListener('change', function(e) {
            const pdfOptions = document.getElementById('pdf-options');
            if (e.target.files.length > 0) {
                const fileName = e.target.files[0].name;
                const fileExtension = fileName.split('.').pop().toLowerCase();
                if (fileExtension === 'pdf') {
                    pdfOptions.style.display = 'block';
                    selectPosBtn.style.display = 'block';
                    signBtn.style.display = 'none';
                } else {
                    pdfOptions.style.display = 'none';
                    selectPosBtn.style.display = 'none';
                    signBtn.style.display = 'block';
                }
            } else {
                pdfOptions.style.display = 'block';
                selectPosBtn.style.display = 'none';
                signBtn.style.display = 'none';
            }
            // Reset thông tin khi chọn file mới
            clearSavedPosition();
        });

        // === THAY ĐỔI CHÍNH BẮT ĐẦU ===
        // Lắng nghe sự kiện KHI MODAL ĐÃ HIỂN THỊ XONG
        pdfModal.addEventListener('shown.bs.modal', function() {
            // Toàn bộ logic load và render PDF được chuyển vào đây
            const file = fileInput.files[0];
            if (!file) {
                console.error("Không có file nào được chọn.");
                return;
            }

            // Xóa nội dung cũ trước khi render mới
            pdfViewer.innerHTML = '<div class="text-center">Đang tải tài liệu...</div>';

            const fileReader = new FileReader();
            fileReader.onload = function() {
                const typedarray = new Uint8Array(this.result);
                pdfjsLib.getDocument(typedarray).promise.then(pdf => {
                    pdfDoc = pdf;
                    renderAllPages(); // Gọi hàm render chính
                }, reason => {
                    console.error("Lỗi khi tải PDF:", reason);
                    pdfViewer.innerHTML =
                        '<div class="alert alert-danger">Không thể đọc được file PDF này.</div>';
                });
            };
            fileReader.readAsArrayBuffer(file);
        });
        // Nút "Chọn vị trí ký" bây giờ CHỈ CÓ TÁC DỤNG MỞ MODAL thông qua thuộc tính data-bs-toggle
        // Toàn bộ logic render đã được chuyển vào sự kiện 'shown.bs.modal' ở trên.
        // === THAY ĐỔI CHÍNH KẾT THÚC ===

        function clearHighlight() {
            if (signatureHighlight && signatureHighlight.parentElement) {
                signatureHighlight.parentElement.removeChild(signatureHighlight);
                signatureHighlight = null;
            }
        }

        function makeDraggable(element, container) {
            let isDragging = false;
            let offsetX, offsetY;

            const onMouseDown = (e) => {
                if (e.button !== 0) return;
                isDragging = true;
                const elementRect = element.getBoundingClientRect();
                offsetX = e.clientX - elementRect.left;
                offsetY = e.clientY - elementRect.top;
                element.style.cursor = 'grabbing';
                document.body.style.cursor = 'grabbing';
                document.addEventListener('mousemove', onMouseMove);
                document.addEventListener('mouseup', onMouseUp);
                e.preventDefault();
                e.stopPropagation(); // Prevent canvas click event
            };

            const onMouseMove = (e) => {
                if (!isDragging) return;
                const containerRect = container.getBoundingClientRect();
                let newX = e.clientX - containerRect.left - offsetX;
                let newY = e.clientY - containerRect.top - offsetY;

                if (newX < 0) newX = 0;
                if (newY < 0) newY = 0;
                if (newX + element.offsetWidth > container.clientWidth) {
                    newX = container.clientWidth - element.offsetWidth;
                }
                if (newY + element.offsetHeight > container.clientHeight) {
                    newY = container.clientHeight - element.offsetHeight;
                }

                element.style.left = `${newX}px`;
                element.style.top = `${newY}px`;
            };

            const onMouseUp = () => {
                if (!isDragging) return;
                isDragging = false;
                element.style.cursor = 'move';
                document.body.style.cursor = 'default';
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);

                const pageNum = parseInt(container.querySelector('canvas').dataset.pageNumber);
                const pageInfo = pageData[pageNum];
                const canvas = pageInfo.canvas;
                const originalViewport = pageInfo.viewport;

                const x = parseFloat(element.style.left);
                const y = parseFloat(element.style.top);
                const width = parseFloat(element.style.width);
                const height = parseFloat(element.style.height);

                // Convert pixel center to PDF center
                const centerX_px = x + width / 2;
                const centerY_px = y + height / 2;
                let pdfX = (centerX_px / canvas.width) * originalViewport.width;
                let pdfY = originalViewport.height - (centerY_px / canvas.height) * originalViewport.height;

                // Apply boundary checks from click event
                const halfWidth = signatureBoxSize.width / 2;
                const halfHeight = signatureBoxSize.height / 2;

                if (pdfX - halfWidth < 0) pdfX = halfWidth;
                if (pdfX + halfWidth > originalViewport.width) pdfX = originalViewport.width - halfWidth;
                if (pdfY - halfHeight < 0) pdfY = halfHeight;
                if (pdfY + halfHeight > originalViewport.height) pdfY = originalViewport.height - halfHeight;

                // Calculate final PDF coordinates
                const llx = Math.round(pdfX - halfWidth);
                const lly = Math.round(pdfY - halfHeight);
                const urx = Math.round(pdfX + halfWidth);
                const ury = Math.round(pdfY + halfHeight);

                selectedPage = pageNum;
                selectedPosition = `${llx},${lly},${urx},${ury}`;

                // Visually snap the highlight to the corrected position
                const finalX_px = ((llx) / originalViewport.width) * canvas.width;
                const finalY_px = ((originalViewport.height - ury) / originalViewport.height) * canvas.height;
                element.style.left = `${finalX_px}px`;
                element.style.top = `${finalY_px}px`;

                savePosition();
            };

            element.addEventListener('mousedown', onMouseDown);
        }


        function createOrUpdateHighlight(pageNum, position) {
            clearHighlight();

            const pageInfo = pageData[pageNum];
            if (!pageInfo) return;

            const pageContainer = document.getElementById(`pdf-page-container-${pageNum}`);
            if (!pageContainer) return;


            signatureHighlight = document.createElement('div');
            signatureHighlight.style.position = 'absolute';
            signatureHighlight.style.border = '2px dashed red';
            signatureHighlight.style.cursor = 'move';
            pageContainer.appendChild(signatureHighlight);
            makeDraggable(signatureHighlight, pageContainer);


            const pos = position.split(',');
            const llx_render = parseFloat(pos[0]);
            const lly_render = parseFloat(pos[1]);
            const urx_render = parseFloat(pos[2]);
            const ury_render = parseFloat(pos[3]);

            const originalViewport = pageInfo.viewport;
            const canvas = pageInfo.canvas;

            const x = llx_render * canvas.width / originalViewport.width;
            const y = (originalViewport.height - ury_render) * canvas.height / originalViewport.height;
            const width = (urx_render - llx_render) * canvas.width / originalViewport.width;
            const height = (ury_render - lly_render) * canvas.height / originalViewport.height;

            signatureHighlight.style.left = `${x}px`;
            signatureHighlight.style.top = `${y}px`;
            signatureHighlight.style.width = `${width}px`;
            signatureHighlight.style.height = `${height}px`;
        }


        function renderAllPages() {
            pdfViewer.innerHTML = '';
            for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                pdfDoc.getPage(pageNum).then(page => {
                    const pageContainer = document.createElement('div');
                    pageContainer.id = `pdf-page-container-${pageNum}`;
                    pageContainer.style.position = 'relative';
                    pageContainer.style.marginBottom = '10px';

                    const canvas = document.createElement('canvas');
                    canvas.dataset.pageNumber = pageNum;
                    const context = canvas.getContext('2d', {
                        willReadFrequently: true
                    });

                    const containerWidth = pdfViewer.clientWidth;
                    const originalViewportForScale = page.getViewport({
                        scale: 1
                    });
                    const scale = containerWidth / originalViewportForScale.width;
                    const viewport = page.getViewport({
                        scale: scale
                    });

                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    pageData[pageNum] = {
                        canvas: canvas,
                        viewport: originalViewportForScale
                    };

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext).promise.then(() => {
                        if (pageNum === selectedPage && selectedPosition) {
                            createOrUpdateHighlight(pageNum, selectedPosition);
                        }
                    });

                    pageContainer.appendChild(canvas);
                    pdfViewer.appendChild(pageContainer);

                    canvas.addEventListener('click', function(e) {
                        const currentPageNum = parseInt(canvas.dataset.pageNumber);
                        selectedPage = currentPageNum;

                        const rect = canvas.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;

                        const originalViewport = page.getViewport({
                            scale: 1
                        });

                        let pdfX = (x / rect.width) * originalViewport.width;
                        let pdfY = originalViewport.height - ((y / rect.height) * originalViewport.height);

                        const halfWidth = signatureBoxSize.width / 2;
                        const halfHeight = signatureBoxSize.height / 2;

                        if (pdfX - halfWidth < 0) pdfX = halfWidth;
                        if (pdfX + halfWidth > originalViewport.width) pdfX = originalViewport.width - halfWidth;
                        if (pdfY - halfHeight < 0) pdfY = halfHeight;
                        if (pdfY + halfHeight > originalViewport.height) pdfY = originalViewport.height - halfHeight;

                        const llx = Math.round(pdfX - halfWidth);
                        const lly = Math.round(pdfY - halfHeight);
                        const urx = Math.round(pdfX + halfWidth);
                        const ury = Math.round(pdfY + halfHeight);

                        selectedPosition = `${llx},${lly},${urx},${ury}`;
                        createOrUpdateHighlight(selectedPage, selectedPosition);
                        savePosition();
                    });
                });
            }
        }

        document.querySelector('#upload-form-sign').addEventListener('submit', function(e) {
            const fileName = fileInput.files[0].name;
            const fileExtension = fileName.split('.').pop().toLowerCase();
            if (fileExtension === 'pdf' && !signaturePositionInput.value) {
                // Bạn có thể bật lại tính năng này nếu muốn bắt buộc chọn vị trí
                e.preventDefault();
                alert('Vui lòng chọn vị trí ký');
            }
        });
    </script>
@endpush
