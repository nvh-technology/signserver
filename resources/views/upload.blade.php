@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Trang trình bày 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Trang trình bày 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Trang trình bày 3"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                            aria-label="Trang trình bày 4"></button>
                    </div>
                    <div class="carousel-inner rounded-3">
                        <div class="carousel-item active" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/1.jpg') }}" style="aspect-ratio: 5/3;"
                                class="object-fit-cover d-block w-100" alt="Trang trình bày 1">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/2.jpg') }}" style="aspect-ratio: 5/3;"
                                class="object-fit-cover d-block w-100" alt="Trang trình bày 2">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/3.jpg') }}" style="aspect-ratio: 5/3;"
                                class="object-fit-cover d-block w-100" alt="Trang trình bày 3">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{ asset('images/carousel/4.jpg') }}" style="aspect-ratio: 5/3;"
                                class="object-fit-cover d-block w-100" alt="Trang trình bày 4">
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

            <div class="col-lg-5">
                @auth
                    <div class="card p-4 card-signserver shadow">
                        <h4 class="card-title text-center">TÂN HƯNG SIGNSERVER</h4>
                        <hr>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                            </div>
                        @endif

                        @if (session('fail'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('fail') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
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
                                    <label for="signature_type" class="form-label">Loại chữ ký</label>
                                    <select class="form-select" id="signature_type" name="signature_type">
                                        <option value="main" selected>Ký chính</option>
                                        <option value="draft">Ký nháy</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Lý do ký</label>
                                    <input type="text" class="form-control" id="reason" name="reason"
                                        value="Ký số điện tử">
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Nơi ký</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                        value="Tp. Hồ Chí Minh">
                                </div>
                                <div class="mb-3">
                                    <label for="text_alignment" class="form-label">Căn lề chữ ký</label>
                                    <select class="form-select" id="text_alignment" name="text_alignment">
                                        <option value="ALIGN_LEFT">Căn trái</option>
                                        <option value="ALIGN_CENTER" selected>Căn giữa</option>
                                        <option value="ALIGN_RIGHT">Căn phải</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="text_bold" name="text_bold">
                                        <label class="form-check-label" for="text_bold">Chữ đậm</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="text_italic" name="text_italic">
                                        <label class="form-check-label" for="text_italic">Chữ nghiêng</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="line_spacing" class="form-label">Khoảng cách dòng</label>
                                    <input type="number" class="form-control" id="line_spacing" name="line_spacing"
                                        value="1.5" min="0" max="5" step="0.1">
                                    <small class="form-text text-muted">Giá trị từ 0 đến 5 (mặc định: 1.5)</small>
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
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username') }}" required autofocus>
                                @error('username')
                                    <div class="text-danger mt-2">{{ __($message) }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <div class="text-danger mt-2">{{ __($message) }}</div>
                                @enderror
                            </div>

                            {{-- <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">Ghi nhớ đăng nhập</label>
                            </div> --}}

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Đăng nhập</button>
                            </div>

                            {{-- @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">Quên mật
                                        khẩu?</a>
                                </div>
                            @endif --}}
                        </form>
                    </div>
                @endguest
            </div>

        </div>
    </div>

    <!-- PDF Modal Fullscreen -->
    <div class="modal fade" id="pdf-modal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Chọn vị trí ký</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body p-0 d-flex">
                    <!-- Sidebar Form Ký -->
                    <div class="bg-white border-end" style="width: 350px; overflow-y: auto;">
                        <div class="p-4">
                            <h6 class="mb-3">Thông tin ký</h6>

                            <div class="mb-3">
                                <label for="modal-owner-id" class="form-label">Tổ chức</label>
                                <select class="form-select" id="modal-owner-id" name="owner_id" required>
                                    @foreach ($owners as $owner)
                                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="modal-signature-type" class="form-label">Loại chữ ký</label>
                                <select class="form-select" id="modal-signature-type" name="signature_type">
                                    <option value="main" selected>Ký chính</option>
                                    <option value="draft">Ký nháy</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="modal-reason" class="form-label">Lý do ký</label>
                                <input type="text" class="form-control" id="modal-reason" name="reason"
                                    value="Ký số điện tử">
                            </div>

                            <div class="mb-3">
                                <label for="modal-location" class="form-label">Nơi ký</label>
                                <input type="text" class="form-control" id="modal-location" name="location"
                                    value="Tp. Hồ Chí Minh">
                            </div>

                            <div class="mb-3">
                                <label for="modal-text-alignment" class="form-label">Căn lề chữ ký</label>
                                <select class="form-select" id="modal-text-alignment" name="text_alignment">
                                    <option value="ALIGN_LEFT">Căn trái</option>
                                    <option value="ALIGN_CENTER" selected>Căn giữa</option>
                                    <option value="ALIGN_RIGHT">Căn phải</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="modal-text-bold" name="text_bold">
                                    <label class="form-check-label" for="modal-text-bold">Chữ đậm</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="modal-text-italic" name="text_italic">
                                    <label class="form-check-label" for="modal-text-italic">Chữ nghiêng</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="modal-line-spacing" class="form-label">Khoảng cách dòng</label>
                                <input type="number" class="form-control" id="modal-line-spacing" name="line_spacing"
                                    value="1.5" min="0" max="5" step="0.1">
                                <small class="form-text text-muted">Giá trị từ 0 đến 5 (mặc định: 1.5)</small>
                            </div>

                            <div class="d-grid">
                                <button type="button" class="btn btn-primary btn-lg" id="modal-sign-btn">
                                    Ký dữ liệu
                                </button>
                            </div>

                            <hr class="my-4">

                            <div class="alert alert-info mb-0">
                                <small>
                                    <strong>Hướng dẫn:</strong><br>
                                    1. Nhấp vào vị trí trên PDF để đặt chữ ký<br>
                                    2. Kéo thả để điều chỉnh vị trí<br>
                                    3. Nhập thông tin và nhấn "Ký dữ liệu"
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- PDF Viewer Area -->
                    <div class="flex-grow-1 bg-light p-3" style="overflow-y: auto; overflow-x: clip;">
                        <div id="pdf-viewer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Passcode Modal -->
    <div class="modal fade" id="passcode-modal" tabindex="-1" aria-labelledby="passcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passcodeModalLabel">Nhập mã OTP ký số (4 số)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <form id="passcode-form">
                        <div class="mb-3">
                            <label for="passcode" class="form-label">Mã OTP</label>
                            <input type="password" class="form-control" id="passcode" name="passcode" required
                                maxlength="4">
                        </div>
                        @if (request()->user() && !request()->user()->passcode)
                            <div class="alert alert-info">
                                Nếu bạn chưa có mã OTP ký số, mã OTP ký số bạn nhập sẽ được dùng làm mã OTP ký số mới.
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="confirm-passcode-btn">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        /* Định nghĩa họ font Times New Roman với 4 kiểu */

        /* 1. Kiểu Thường (Regular) */
        @font-face {
        font-family: 'Times New Roman';
        font-style: normal;
        font-weight: 400; /* 400 là "normal" */
        src: url('{{ asset('fonts/times.ttf') }}') format('truetype');
        }

        /* 2. Kiểu Nghiêng (Italic) */
        @font-face {
        font-family: 'Times New Roman';
        font-style: italic;
        font-weight: 400;
        src: url('{{ asset('fonts/timesi.ttf') }}') format('truetype');
        }

        /* 3. Kiểu Đậm (Bold) */
        @font-face {
        font-family: 'Times New Roman';
        font-style: normal;
        font-weight: 900; /* 700 là "bold" */
        src: url('{{ asset('fonts/timesbd.ttf') }}') format('truetype');
        }

        /* 4. Kiểu Đậm Nghiêng (Bold Italic) */
        @font-face {
        font-family: 'Times New Roman';
        font-style: italic;
        font-weight: 700;
        src: url('{{ asset('fonts/timesbi.ttf') }}') format('truetype');
        }

  
    </style>
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
        const passcodeModal = new bootstrap.Modal(document.getElementById('passcode-modal'));
        const confirmPasscodeBtn = document.getElementById('confirm-passcode-btn');
        const passcodeForm = document.getElementById('passcode-form');
        const uploadForm = document.getElementById('upload-form-sign');

        // Sidebar modal elements
        const modalSignBtn = document.getElementById('modal-sign-btn');
        const modalOwnerId = document.getElementById('modal-owner-id');
        const modalReason = document.getElementById('modal-reason');
        const modalLocation = document.getElementById('modal-location');
        const modalSignatureType = document.getElementById('modal-signature-type');
        const signatureTypeInput = document.getElementById('signature_type');
        const modalTextAlignment = document.getElementById('modal-text-alignment');
        const textAlignmentInput = document.getElementById('text_alignment');
        const modalLineSpacing = document.getElementById('modal-line-spacing');
        const lineSpacingInput = document.getElementById('line_spacing');
        const modalTextBold = document.getElementById('modal-text-bold');
        const textBoldInput = document.getElementById('text_bold');
        const modalTextItalic = document.getElementById('modal-text-italic');
        const textItalicInput = document.getElementById('text_italic');

        // Add event listeners to update preview when form values change
        modalOwnerId.addEventListener('change', updateSignaturePreview);
        modalReason.addEventListener('input', updateSignaturePreview);
        modalLocation.addEventListener('input', updateSignaturePreview);
        modalTextAlignment.addEventListener('change', updateSignaturePreview);
        modalLineSpacing.addEventListener('input', updateSignaturePreview);
        modalTextBold.addEventListener('change', updateSignaturePreview);
        modalTextItalic.addEventListener('change', updateSignaturePreview);

        function updateSignaturePreview() {
            if (selectedPage && selectedPosition) {
                createOrUpdateHighlight(selectedPage, selectedPosition);
            }
        }

        // Khai báo các biến trạng thái
        let pdfDoc = null;
        let selectedPage = null;
        let selectedPosition = null;
        const signatureBoxSizes = {
            main: {
                width: 170,
                height: 70
            },
            draft: {
                width: 42,
                height: 17
            }
        };
        let currentSignatureType = 'main'; // Mặc định là ký chính
        let signatureHighlight = null;
        const pageData = {}; // { pageNum: { viewport: originalViewport, canvas: canvasElement } }

        // Lắng nghe thay đổi loại chữ ký
        modalSignatureType.addEventListener('change', function() {
            currentSignatureType = this.value;
            // Nếu đã chọn vị trí, cập nhật lại highlight với kích thước mới
            if (selectedPage && selectedPosition) {
                // Xóa position cũ và yêu cầu chọn lại
                clearSavedPosition();
                alert('Vui lòng chọn lại vị trí ký với kích thước chữ ký mới.');
            }
        });

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

            // Reset thông tin khi chọn file mới
            clearSavedPosition();

            if (e.target.files.length > 0) {
                const fileName = e.target.files[0].name;
                const fileExtension = fileName.split('.').pop().toLowerCase();
                if (fileExtension === 'pdf') {
                    pdfOptions.style.display = 'block';
                    selectPosBtn.style.display = 'block';
                    signBtn.style.display = 'none';

                    // Tự động mở modal PDF
                    const pdfModalInstance = new bootstrap.Modal(pdfModal);
                    pdfModalInstance.show();
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
        });

        // === THAY ĐỔI CHÍNH BẮT ĐẦU ===
        // Lắng nghe sự kiện KHI MODAL ĐÃ HIỂN THỊ XONG
        pdfModal.addEventListener('shown.bs.modal', function() {
            // Đồng bộ dữ liệu từ form chính sang sidebar modal
            const mainOwnerId = document.getElementById('owner_id');
            const mainReason = document.getElementById('reason');
            const mainLocation = document.getElementById('location');
            const mainSignatureType = document.getElementById('signature_type');

            modalOwnerId.value = mainOwnerId.value;
            modalReason.value = mainReason.value;
            modalLocation.value = mainLocation.value;
            modalSignatureType.value = mainSignatureType.value;
            modalTextAlignment.value = textAlignmentInput.value;
            modalLineSpacing.value = lineSpacingInput.value;
            modalTextBold.checked = textBoldInput.checked;
            modalTextItalic.checked = textItalicInput.checked;
            currentSignatureType = mainSignatureType.value; // Cập nhật loại chữ ký hiện tại

            // Toàn bộ logic load và render PDF được chuyển vào đây
            const file = fileInput.files[0];
            if (!file) {
                console.error("Chưa có tệp nào được chọn.");
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
                        '<div class="alert alert-danger">Không thể đọc được tệp PDF này.</div>';
                });
            };
            fileReader.readAsArrayBuffer(file);
        });
        // Nút "Chọn vị trí ký" bây giờ CHỈ CÓ TÁC DỤNG MỞ MODAL thông qua thuộc tính data-bs-toggle
        // Toàn bộ logic render đã được chuyển vào sự kiện 'shown.bs.modal' ở trên.
        // === THAY ĐỔI CHÍNH KẾT THÚC ===

        // Xử lý nút "Ký dữ liệu" trong modal
        modalSignBtn.addEventListener('click', function() {
            // Kiểm tra đã chọn vị trí ký chưa
            if (!signaturePositionInput.value || !signaturePageInput.value) {
                alert('Vui lòng chọn vị trí ký trên PDF trước khi ký dữ liệu.');
                return;
            }

            // Đồng bộ dữ liệu từ sidebar modal về form chính
            const mainOwnerId = document.getElementById('owner_id');
            const mainReason = document.getElementById('reason');
            const mainLocation = document.getElementById('location');
            const mainSignatureType = document.getElementById('signature_type');

            mainOwnerId.value = modalOwnerId.value;
            mainReason.value = modalReason.value;
            mainLocation.value = modalLocation.value;
            mainSignatureType.value = modalSignatureType.value;
            textAlignmentInput.value = modalTextAlignment.value;
            lineSpacingInput.value = modalLineSpacing.value;
            textBoldInput.checked = modalTextBold.checked;
            textItalicInput.checked = modalTextItalic.checked;

            // Đóng modal và submit form
            bootstrap.Modal.getInstance(pdfModal).hide();

            // Trigger submit event trên form chính (sẽ mở passcode modal)
            uploadForm.dispatchEvent(new Event('submit'));
        });

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

                // Get canvas dimensions for consistent boundary checks
                const canvas = container.querySelector('canvas');
                const maxWidth = canvas.width;
                const maxHeight = canvas.height;

                if (newX < 0) newX = 0;
                if (newY < 0) newY = 0;
                if (newX + element.offsetWidth > maxWidth) {
                    newX = maxWidth - element.offsetWidth;
                }
                if (newY + element.offsetHeight > maxHeight) {
                    newY = maxHeight - element.offsetHeight;
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

                // Calculate scale factor between canvas (scaled) and original viewport
                const scaleX = canvas.width / originalViewport.width;
                const scaleY = canvas.height / originalViewport.height;

                // Convert pixel position to PDF coordinates (using original viewport dimensions)
                // LLX, LLY (lower left)
                const llx = x / scaleX;
                const lly = originalViewport.height - ((y + height) / scaleY);

                // URX, URY (upper right)
                const urx = (x + width) / scaleX;
                const ury = originalViewport.height - (y / scaleY);

                selectedPage = pageNum;
                selectedPosition = `${Math.round(llx)},${Math.round(lly)},${Math.round(urx)},${Math.round(ury)}`;

                savePosition();
            };

            element.addEventListener('mousedown', onMouseDown);
        }


        // // Load custom font
        // let customFont = null;
        // async function loadCustomFont() {
        //     try {
        //         const fontFace = new FontFace('Times New Roman', 'url({{ asset('fonts/times-new-roman.ttf') }})');
        //         const loadedFont = await fontFace.load();
        //         document.fonts.add(loadedFont);
        //         customFont = loadedFont;
        //         console.log('Font Times New Roman loaded successfully');
        //     } catch (error) {
        //         console.error('Failed to load Times New Roman font:', error);
        //     }
        // }

        // // Load font when page loads
        // loadCustomFont();

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
            signatureHighlight.style.overflow = 'hidden';

            // Create canvas for signature preview
            const previewCanvas = document.createElement('canvas');
            signatureHighlight.appendChild(previewCanvas);

            pageContainer.appendChild(signatureHighlight);
            makeDraggable(signatureHighlight, pageContainer);


            const pos = position.split(',');
            const llx_render = parseFloat(pos[0]);
            const lly_render = parseFloat(pos[1]);
            const urx_render = parseFloat(pos[2]);
            const ury_render = parseFloat(pos[3]);

            const originalViewport = pageInfo.viewport;
            const canvas = pageInfo.canvas;

            // Calculate scale factor between canvas (scaled) and original viewport
            const scaleX = canvas.width / originalViewport.width;
            const scaleY = canvas.height / originalViewport.height;

            // Convert PDF coordinates to pixel position
            const x = llx_render * scaleX;
            const y = (originalViewport.height - ury_render) * scaleY;
            const width = (urx_render - llx_render) * scaleX;
            const height = (ury_render - lly_render) * scaleY;

            signatureHighlight.style.left = `${x}px`;
            signatureHighlight.style.top = `${y}px`;
            signatureHighlight.style.width = `${width}px`;
            signatureHighlight.style.height = `${height}px`;

            // Setup preview canvas
            previewCanvas.width = width;
            previewCanvas.height = height;

            drawSignaturePreview(previewCanvas, width, height, pageNum);
        }

        function wrapText(ctx, text, maxWidth) {
            if (!text) return [''];

            const words = text.split(' ');
            const lines = [];
            let currentLine = '';

            for (let i = 0; i < words.length; i++) {
                const word = words[i];
                const testLine = currentLine ? currentLine + ' ' + word : word;
                const metrics = ctx.measureText(testLine);
                const testWidth = metrics.width;

                if (testWidth > maxWidth && currentLine) {
                    lines.push(currentLine);
                    currentLine = word;
                } else {
                    currentLine = testLine;
                }
            }

            if (currentLine) {
                lines.push(currentLine);
            }

            return lines.length > 0 ? lines : [''];
        }

        function drawSignaturePreview(canvas, width, height, pageNum) {
            const ctx = canvas.getContext('2d');
            const backgroundSignatureUrl =
                "{{ auth()->user() && auth()->user()->backgroundSignature ? (route('users.backgroundSignature', auth()->user()) . '?' . rand()) : '' }}";

            const doDrawing = (bgImage) => {
                const pageInfo = pageData[pageNum];
                if (!pageInfo) {
                    console.error("Page info not found for page: ", pageNum);
                    return;
                }
                const pageCanvas = pageInfo.canvas;
                const originalViewport = pageInfo.viewport;

                const scaleX = pageCanvas.width / originalViewport.width;
                const scaleY = pageCanvas.height / originalViewport.height;

                // Set font properties
                const fontSize = scaleX*10;
                let fontStyle = '';
                if (modalTextBold.checked) fontStyle += 'bold ';
                if (modalTextItalic.checked) fontStyle += 'italic ';
                ctx.font = `${fontStyle}${fontSize}px 'Times New Roman'`;
                ctx.fillStyle = 'red';

                // Get text alignment from form
                const textAlignment = modalTextAlignment.value || 'ALIGN_LEFT';
                switch(textAlignment) {
                    case 'ALIGN_CENTER':
                        ctx.textAlign = 'center';
                        break;
                    case 'ALIGN_RIGHT':
                        ctx.textAlign = 'right';
                        break;
                    case 'ALIGN_LEFT':
                    default:
                        ctx.textAlign = 'left';
                        break;
                }
                ctx.textBaseline = 'top';

                // Get form values
                const reason = modalReason.value || '';
                const location = modalLocation.value || '';
                const now = new Date();
                const formattedDate =
                    `${String(now.getDate()).padStart(2, '0')}/${String(now.getMonth() + 1).padStart(2, '0')}/${now.getFullYear()} ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}:${String(now.getSeconds()).padStart(2, '0')}`;

                const textContent = [{
                    label: 'Ký bởi:',
                    value: "{{ request()->user()->name ?? '' }}"
                }, {
                    label: 'Ngày ký:',
                    value: formattedDate
                }, {
                    label: 'Nơi ký:',
                    value: location
                }, {
                    label: 'Lý do:',
                    value: reason
                }];

                // Get line spacing from form
                const lineSpacingValue = parseFloat(modalLineSpacing.value) || 1;
                // Đúng theo cách tính của C#: fontSize * lineSpacing (nếu lineSpacing != 0)
                var lineHeight = fontSize * 1;
                if(lineSpacingValue !== 0){
                    lineHeight = fontSize * (lineSpacingValue/1.1);
                }
                const paddingX = 5;
                const paddingY = 5;
                const maxWidth = width - (paddingX * 2);

                const wrappedLines = [];

                // Only wrap lines if we are not in draft mode
                if (currentSignatureType !== 'draft') {
                    textContent.forEach(item => {
                        const fullText = `${item.label} ${item.value}`;
                        wrapText(ctx, fullText, maxWidth).forEach(line => wrappedLines.push(
                            line));
                    });
                }

                const requiredHeight = (wrappedLines.length * lineHeight) + (paddingY * 2);

                // Clear canvas
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                let finalHeight = height;

                // Resize logic only for non-draft
                if (currentSignatureType !== 'draft' && requiredHeight != height) {
                    const oldHeight = height;
                    finalHeight = requiredHeight;

                    canvas.height = finalHeight;
                    canvas.parentElement.style.height = `${finalHeight}px`;

                    adjustPositionAfterResize(canvas.parentElement, finalHeight);

                    if (selectedPosition) {
                        updateSignaturePositionAfterResize(width, oldHeight, finalHeight);
                    }

                    // Reset font after resize
                    let fontStyle = '';
                    if (modalTextBold.checked) fontStyle += 'bold ';
                    if (modalTextItalic.checked) fontStyle += 'italic ';
                    ctx.font = `${fontStyle}${fontSize}px TimesNewRoman`;
                    ctx.fillStyle = 'red';
                    ctx.textBaseline = 'top';
                    switch(textAlignment) {
                        case 'ALIGN_CENTER':
                            ctx.textAlign = 'center';
                            break;
                        case 'ALIGN_RIGHT':
                            ctx.textAlign = 'right';
                            break;
                        case 'ALIGN_LEFT':
                        default:
                            ctx.textAlign = 'left';
                            break;
                    }
                }

                // Draw background if it exists
                if (bgImage) {
                    ctx.drawImage(bgImage, 0, 0, canvas.width, finalHeight);
                }

                // Draw text if not draft
                if (currentSignatureType !== 'draft') {
                    wrappedLines.forEach((line, index) => {
                        const y = paddingY + (index * lineHeight);

                        // Calculate x position based on text alignment
                        let x = paddingX;

                        const textAlignment = modalTextAlignment.value || 'ALIGN_LEFT';

                        switch(textAlignment) {
                            case 'ALIGN_CENTER':
                                x = width / 2;
                                break;
                            case 'ALIGN_RIGHT':
                                x = width - paddingX;
                                break;
                            case 'ALIGN_LEFT':
                            default:
                                x = paddingX;
                                break;
                        }
                        ctx.fillText(line, x, y);
                    });
                }
            };

            if (backgroundSignatureUrl) {
                const img = new Image();
                img.onload = () => doDrawing(img);
                img.onerror = () => doDrawing(null);
                img.src = backgroundSignatureUrl + '?t=' + new Date().getTime();
            } else {
                doDrawing(null);
            }
        }

        function adjustPositionAfterResize(element, newHeight) {
            if (!selectedPage || !element) return;

            const pageContainer = document.getElementById(`pdf-page-container-${selectedPage}`);
            if (!pageContainer) return;

            let currentTop = parseFloat(element.style.top);
            let currentLeft = parseFloat(element.style.left);
            const currentWidth = parseFloat(element.style.width);

            // Get canvas dimensions (same as in makeDraggable onMouseMove)
            const canvas = pageContainer.querySelector('canvas');
            const containerHeight = canvas.height;
            const containerWidth = canvas.width;

            let positionChanged = false;

            // Apply boundary checks (same logic as onMouseMove in makeDraggable)
            // Check left boundary
            if (currentLeft < 0) {
                currentLeft = 0;
                positionChanged = true;
            }

            // Check top boundary
            if (currentTop < 0) {
                currentTop = 0;
                positionChanged = true;
            }

            // Check right boundary
            if (currentLeft + currentWidth > containerWidth) {
                currentLeft = containerWidth - currentWidth;
                positionChanged = true;
            }

            // Check bottom boundary (important after height resize!)
            if (currentTop + newHeight > containerHeight) {
                currentTop = containerHeight - newHeight;
                positionChanged = true;
            }

            // Ensure position doesn't go negative after adjustment
            if (currentLeft < 0) currentLeft = 0;
            if (currentTop < 0) currentTop = 0;

            // Update position if needed
            if (positionChanged) {
                element.style.top = `${currentTop}px`;
                element.style.left = `${currentLeft}px`;

                // Recalculate PDF coordinates with new position (same as onMouseUp)
                const pageInfo = pageData[selectedPage];
                if (pageInfo) {
                    const canvas = pageInfo.canvas;
                    const originalViewport = pageInfo.viewport;

                    // Calculate scale factor
                    const scaleX = canvas.width / originalViewport.width;
                    const scaleY = canvas.height / originalViewport.height;

                    // Calculate PDF coordinates from pixel position
                    const llx = currentLeft / scaleX;
                    const lly = originalViewport.height - ((currentTop + newHeight) / scaleY);
                    const urx = (currentLeft + currentWidth) / scaleX;
                    const ury = originalViewport.height - (currentTop / scaleY);

                    selectedPosition = `${Math.round(llx)},${Math.round(lly)},${Math.round(urx)},${Math.round(ury)}`;
                    signaturePositionInput.value = selectedPosition;
                }
            }
        }

        function updateSignaturePositionAfterResize(canvasWidth, oldHeight, newHeight) {
            if (!selectedPosition || !selectedPage) return;

            const pageInfo = pageData[selectedPage];
            if (!pageInfo) return;

            const pos = selectedPosition.split(',');
            const llx = parseFloat(pos[0]);
            const lly = parseFloat(pos[1]);
            const urx = parseFloat(pos[2]);
            const ury = parseFloat(pos[3]);

            const originalViewport = pageInfo.viewport;
            const canvas = pageInfo.canvas;

            // Calculate scale factor
            const scaleY = canvas.height / originalViewport.height;

            // Calculate the height difference in screen pixels
            const heightDiffPx = newHeight - oldHeight;

            // Convert height difference to PDF coordinates
            const heightDiffPDF = heightDiffPx / scaleY;

            // Update LLY (lower left Y) by subtracting the height difference
            const newLly = lly - heightDiffPDF;

            // Update the selected position
            selectedPosition = `${Math.round(llx)},${Math.round(newLly)},${Math.round(urx)},${Math.round(ury)}`;

            // Update the input field
            signaturePositionInput.value = selectedPosition;
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

                        // Calculate scale factor
                        const scaleX = canvas.width / originalViewport.width;
                        const scaleY = canvas.height / originalViewport.height;

                        // Convert click position to PDF coordinates
                        let pdfX = x / scaleX;
                        let pdfY = originalViewport.height - (y / scaleY);

                        const signatureBoxSize = signatureBoxSizes[currentSignatureType];
                        const halfWidth = signatureBoxSize.width / 2;
                        const halfHeight = signatureBoxSize.height / 2;

                        // Apply boundary checks in PDF coordinate space
                        if (pdfX - halfWidth < 0) pdfX = halfWidth;
                        if (pdfX + halfWidth > originalViewport.width) pdfX = originalViewport.width -
                            halfWidth;
                        if (pdfY - halfHeight < 0) pdfY = halfHeight;
                        if (pdfY + halfHeight > originalViewport.height) pdfY = originalViewport.height -
                            halfHeight;

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

        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn form submit ngay lập tức

            const fileName = fileInput.files[0].name;
            const fileExtension = fileName.split('.').pop().toLowerCase();
            if (fileExtension === 'pdf' && !signaturePositionInput.value) {
                alert('Vui lòng chọn vị trí ký.');
                return; // Dừng lại nếu là file PDF và chưa chọn vị trí
            }

            passcodeModal.show(); // Hiển thị modal nhập passcode
        });

        confirmPasscodeBtn.addEventListener('click', function() {
            const passcode = document.getElementById('passcode').value;
            if (!passcode) {
                alert('Vui lòng nhập mã OTP.');
                return;
            }

            // Thêm passcode vào form chính
            const passcodeHiddenInput = document.createElement('input');
            passcodeHiddenInput.type = 'hidden';
            passcodeHiddenInput.name = 'passcode';
            passcodeHiddenInput.value = passcode;
            uploadForm.appendChild(passcodeHiddenInput);

            passcodeModal.hide();
            uploadForm.submit(); // Submit form chính
        });
    </script>
@endpush
