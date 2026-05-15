@extends('admin.auth.ebook.layout')

@section('title', 'Tài liệu IELTS')
@section('header_title', 'Tài liệu IELTS')
@section('header_desc', 'Tài liệu luyện thi IELTS được cập nhật liên tục')

@section('content')

    {{-- Book 1 --}}
    <div class="psi-book-box">
        <div class="psi-book-content">
            <div class="psi-book-text">
                <div class="psi-book-title">
                    Tải miễn phí sách Get Ready For Flyers 2nd Edition(PDF + Audio)
                </div>
                <div class="psi-tag">📘 Tài liệu IELTS</div>
                <div class="psi-book-description">
                    <strong class="psi-highlight">Get Ready For Flyers 2nd</strong> giúp trẻ em làm quen và chuẩn bị
                    tốt cho kỳ thi Cambridge English: Flyers. Sách cung cấp bài tập thực hành theo định dạng đề thi
                    thật, giúp trẻ nâng cao từ vựng, ngữ pháp và kỹ năng nghe, nói, đọc, viết.
                </div>
                <ul class="psi-book-links">
                    <li>
                        <a href="https://drive.google.com/drive/folders/1uvU2r9A2Q5axDVMg695wm9zw5v_ZRyOb">📥 Tải file
                            PDF</a>
                    </li>
                </ul>
                <a href="#" class="psi-buy-btn">Mua sách</a>
            </div>
            <div class="psi-book-image">
                <img src="{{ asset('admin/assets/images/ebook/img/IELTS/image35.png') }}" alt="IELTS Book Cover">
            </div>
        </div>
    </div>

    {{-- Book 2 --}}
    <div class="psi-book-box">
        <div class="psi-book-content">
            <div class="psi-book-text">
                <div class="psi-book-title">
                    Tải miễn phí sách Facts and Figures PDF kèm Answer Key
                </div>
                <div class="psi-tag">📘 Tài liệu IELTS</div>
                <div class="psi-book-description">
                    <strong class="psi-highlight">Facts and Figures</strong> giúp phát triển kỹ năng đọc hiểu và mở
                    rộng vốn từ vựng tiếng Anh.
                </div>
                <ul class="psi-book-links">
                    <li>
                        <a href="https://drive.google.com/file/d/1cjop517uart-ASSkVQ2bK-XCG7-JPrpk/view">📥 Tải file PDF</a>
                    </li>
                </ul>
                <a href="#" class="psi-buy-btn">Mua sách</a>
            </div>
            <div class="psi-book-image">
                <img src="{{ asset('admin/assets/images/ebook/img/IELTS/fact.png') }}" alt="IELTS Book Cover">
            </div>
        </div>
    </div>

    {{-- Book 3 --}}
    <div class="psi-book-box">
        <div class="psi-book-content">
            <div class="psi-book-text">
                <div class="psi-book-title">
                    Tải miễn phí sách Road To IELTS Reading PDF
                </div>
                <div class="psi-tag">📘 Tài liệu IELTS</div>
                <div class="psi-book-description">
                    <strong class="psi-highlight">Road To IELTS Reading</strong> giúp người học nâng cao kỹ năng đọc
                    hiểu và chuẩn bị tốt cho kỳ thi IELTS Reading.
                </div>
                <ul class="psi-book-links">
                    <li>
                        <a href="https://drive.google.com/file/d/17uob3FymUviNE80Xsg-PCq4UfgbddVld/view">📥 Tải file PDF</a>
                    </li>
                </ul>
                <a href="#" class="psi-buy-btn">Mua sách</a>
            </div>
            <div class="psi-book-image">
                <img src="{{ asset('admin/assets/images/ebook/img/IELTS/image1.png') }}" alt="IELTS Book Cover">
            </div>
        </div>
    </div>

    {{-- Book 4 --}}
    <div class="psi-book-box">
        <div class="psi-book-content">
            <div class="psi-book-text">
                <div class="psi-book-title">
                    Tải miễn phí sách Tiếng Anh cho người mới bắt đầu PDF – Trang Anh
                </div>
                <div class="psi-tag">📘 Tài liệu IELTS</div>
                <div class="psi-book-description">
                    <strong class="psi-highlight">Tiếng Anh dành cho người mới bắt đầu</strong> giúp người học xây
                    dựng nền tảng vững chắc về từ vựng, ngữ pháp và kỹ năng giao tiếp tiếng Anh.
                </div>
                <ul class="psi-book-links">
                    <li>
                        <a href="https://drive.google.com/file/d/1fgBqEMyntJm8YxGfsvofWMmo8_bnkmxT/view">📥 Tải file PDF</a>
                    </li>
                </ul>
                <a href="#" class="psi-buy-btn">Mua sách</a>
            </div>
            <div class="psi-book-image">
                <img src="{{ asset('admin/assets/images/ebook/img/IELTS/image2.png') }}" alt="IELTS Book Cover">
            </div>
        </div>
    </div>

    {{-- Load more --}}
    <div class="load-more-container">
        <div id="spinner" class="spinner" style="display: none;"></div>
        <button id="loadMoreBtn">Xem thêm</button>
    </div>

@endsection

@section('extra')
    @include('components.admin.partials.order-popup')
@endsection

@push('scripts')
    <script>
        document.getElementById("loadMoreBtn").addEventListener("click", function() {
            const btn = document.getElementById("loadMoreBtn");
            const spinner = document.getElementById("spinner");

            btn.style.display = "none";
            spinner.style.display = "block";

            setTimeout(() => {
                spinner.style.display = "none";
                btn.style.display = "inline-block";
            }, 2000);
        });

        const popup = document.getElementById("orderPopup");
        const form = document.getElementById("orderForm");
        const closeBtn = popup.querySelector(".close-btn");

        document.querySelectorAll(".psi-buy-btn").forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                const title = this.closest(".psi-book-box").querySelector(".psi-highlight").innerText;
                form.book.value = title;
                popup.classList.add("show");
            });
        });

        closeBtn.addEventListener("click", () => {
            popup.classList.remove("show");
        });

        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append("entry.775325033", form.fullname.value);
            formData.append("entry.468944834", form.phone.value);
            formData.append("entry.1015054018", form.email.value);
            formData.append("entry.1745495770", form.address.value);
            formData.append("entry.12189843", form.book.value);

            fetch("https://docs.google.com/forms/d/e/1FAIpQLSdxNXlgD0DtSW-jGee5ILlo57fzHh8CkcInSfS8Om0Hei9S7g/formResponse", {
                method: "POST",
                mode: "no-cors",
                body: formData
            }).then(() => {
                alert("🎉 Đặt sách thành công! Thông tin đã được gửi.");
                popup.classList.remove("show");
                form.reset();
            }).catch(() => {
                alert("❌ Có lỗi xảy ra khi gửi. Vui lòng thử lại.");
            });
        });

        function moveImagesOnMobile() {
            if (window.innerWidth <= 576) {
                document.querySelectorAll(".psi-book-box").forEach(box => {
                    const tag = box.querySelector(".psi-tag");
                    const image = box.querySelector(".psi-book-image");
                    const text = box.querySelector(".psi-book-text");
                    if (image && tag && text && !text.contains(image)) {
                        tag.insertAdjacentElement("afterend", image);
                    }
                });
            }
        }

        moveImagesOnMobile();
        window.addEventListener("resize", moveImagesOnMobile);
    </script>
@endpush
