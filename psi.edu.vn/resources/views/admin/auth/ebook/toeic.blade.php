@extends('admin.auth.ebook.layout')

@section('title', 'Tài liệu TOEIC')
@section('header_title', 'Tài liệu TOEIC')
@section('header_desc', 'Tài liệu luyện thi TOEIC được cập nhật liên tục')

@section('content')
    @php
        $books = [
            [
                'title' => 'Tải miễn phí 600 Essential Words For The TOEIC PDF',
                'tag' => '📘Tài liệu TOEIC',
                'highlight' => '600 Essential Words For The TOEIC',
                'description' =>
                    'giúp mở rộng vốn từ vựng với 600 từ quan trọng, chia theo 50 chủ đề thường gặp trong bài thi TOEIC. Mỗi từ đều có định nghĩa, ví dụ minh họa và bài tập thực hành, giúp ghi nhớ hiệu quả...',
                'pdf' => 'https://drive.google.com/drive/folders/1gsU876BmrGy-wSlnG70JtE9JUB3i0vKy',
                'audio' => 'https://www.fshare.vn/folder/5QYCKKT8BNZS?token=1692346655',
                'image' => 'admin/assets/images/ebook/img/TOEIC/image36.png',
            ],
            [
                'title' => 'Tải miễn phí Sách 3420 Từ Vựng Cần Biết Cho TOEIC PDF',
                'tag' => '📘Tài liệu TOEIC',
                'highlight' => 'Sách 3420 Từ Vựng Cần Biết Cho TOEIC',
                'description' =>
                    'giúp người học nắm vững các từ vựng quan trọng để đạt điểm cao trong kỳ thi TOEIC. Sách được biên soạn theo phương pháp Anh-Anh-Việt, giúp hiểu sâu nghĩa của từ và cách sử dụng trong ngữ cảnh thực tế...',
                'pdf' => 'https://drive.google.com/file/d/1jkauI1v2knWKvVVt-U5tOjZum6Q3H0hs/view?usp=sharing',
                'image' => 'admin/assets/images/ebook/img/TOEIC/image1.png',
            ],
            [
                'title' => 'Tải miễn phí sách Hackers TOEIC Vocabulary PDF và cách học hiệu quả',
                'tag' => '📘Tài liệu TOEIC',
                'highlight' => 'Hackers TOEIC Vocabulary',
                'description' =>
                    'giúp người học nâng cao vốn từ vựng một cách có hệ thống, hỗ trợ hiệu quả trong kỳ thi TOEIC. Sách cung cấp gần 7.600 từ vựng, phân chia theo từng chủ đề thường xuất hiện trong đề thi...',
                'pdf' => 'https://drive.google.com/drive/folders/1dZ9o4fiXNY4ZZ8xByxV-U_Y6I2DS7Eeu',
                'image' => 'admin/assets/images/ebook/img/TOEIC/image2.png',
            ],
            // Thêm các sách khác tương tự
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
                        @isset($book['audio'])
                            <li><a href="{{ $book['audio'] }}">🎧 Tải file Audio</a></li>
                        @endisset
                    </ul>
                    <a href="#" class="psi-buy-btn">Mua sách</a>
                </div>
                <div class="psi-book-image">
                    <img src="{{ asset($book['image']) }}" alt="TOEIC Book Cover">
                </div>
            </div>
        </div>
    @endforeach

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
