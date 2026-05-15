@extends('admin.auth.ebook.layout')

@section('title', 'Tài liệu SAT')
@section('header_title', 'Tài liệu SAT')
@section('header_desc', 'Tổng hợp tài liệu và sách luyện thi SAT miễn phí')

@section('content')
    @php
        $books = [
            [
                'title' => 'Tải miễn phí The Official SAT Study Guide PDF: Cẩm nang chinh phục kỳ thi SAT',
                'tag' => '📘 Tài liệu SAT',
                'highlight' => 'The Official SAT Study Guide',
                'description' =>
                    'giúp học sinh chuẩn bị hiệu quả cho kỳ thi SAT với tài liệu chính thức từ College Board. Sách cung cấp bài thi thực hành sát với đề thi thật, giúp học sinh làm quen với cấu trúc, dạng câu hỏi và cách tính điểm.',
                'pdf' => 'https://drive.google.com/file/d/1Y99Aa2LQG4F34fkNJ1Zkwu-98yyMwy8T/view?usp=sharing',
                'image' => 'admin/assets/images/ebook/img/SAT/image34.png',
            ],
            // Thêm sách khác tương tự
        ];
    @endphp

    @foreach ($books as $book)
        <div class="psi-book-box">
            <div class="psi-book-content">
                <div class="psi-book-text">
                    <div class="psi-book-title">{{ $book['title'] }}</div>
                    <div class="psi-tag">{{ $book['tag'] }}</div>
                    <div class="psi-book-description">
                        <strong class="psi-highlight">{{ $book['highlight'] }}</strong> {{ $book['description'] }}
                    </div>
                    <ul class="psi-book-links">
                        <li><a href="{{ $book['pdf'] }}">📥 Tải file PDF</a></li>
                    </ul>
                    <a href="#" class="psi-buy-btn">Mua sách</a>
                </div>
                <div class="psi-book-image">
                    <img src="{{ asset($book['image']) }}" alt="SAT Book Cover">
                </div>
            </div>
        </div>
    @endforeach

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
        // Load more button
        document.getElementById("loadMoreBtn").addEventListener("click", function() {
            const btn = this;
            const spinner = document.getElementById("spinner");
            btn.style.display = "none";
            spinner.style.display = "block";
            setTimeout(() => {
                spinner.style.display = "none";
                btn.style.display = "inline-block";
            }, 2000);
        });

        // Popup
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

        closeBtn.addEventListener("click", () => popup.classList.remove("show"));

        form.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append("entry.88323563", form.fullname.value);
            formData.append("entry.909184540", form.phone.value);
            formData.append("entry.1426992672", form.email.value);
            formData.append("entry.1756670565", form.address.value);
            formData.append("entry.94594449", form.book.value);

            fetch("https://docs.google.com/forms/u/0/d/e/1FAIpQLSdJ8tK_GuiuG1IUD82uMV8teuedc1RJHuctM-IWCyIV4b_Olw/formResponse", {
                method: "POST",
                mode: "no-cors",
                body: formData
            }).then(() => {
                alert("🎉 Đặt sách thành công! Thông tin đã được gửi.");
                popup.classList.remove("show");
                form.reset();
            }).catch(() => alert("❌ Có lỗi xảy ra khi gửi. Vui lòng thử lại."));
        });

        // Move images on mobile
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
