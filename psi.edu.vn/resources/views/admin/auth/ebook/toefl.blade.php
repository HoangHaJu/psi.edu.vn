@extends('admin.auth.ebook.layout')

@section('title', 'Tài liệu TOEFL')
@section('header_title', 'Tài liệu TOEFL')
@section('header_desc', 'Tài liệu luyện thi, sách TOEFL được cập nhật liên tục')

@section('content')
    @php
        $books = [
            [
                'title' => 'Tải miễn phí English Pronunciation in Use PDF+Audio',
                'tag' => '📘 Tài liệu TOEFL',
                'highlight' => 'English Pronunciation in Use',
                'description' =>
                    'là bộ sách hữu ích giúp người học cải thiện phát âm tiếng Anh một cách chuẩn xác và tự nhiên. Sách cung cấp hướng dẫn chi tiết về cách phát âm từng âm, cách nối âm, trọng âm và ngữ điệu trong câu, giúp người học nói tiếng Anh trôi chảy hơn. Ngoài ra, bộ sách đi kèm các bài tập nghe và thực hành, giúp phân biệt những âm gần giống nhau, từ đó nâng cao kỹ năng nghe và giao tiếp.',
                'pdf' => 'https://drive.google.com/file/d/11igITVpHa5D1_yjbU6XR4b4z6KzHcRri/view',
                'image' => 'admin/assets/images/ebook/img/TOEFL/image68.png',
            ],
            [
                'title' => 'Tải miễn phí bộ sách TOEFL Primary Step 1 book 1,2,3 PDF',
                'tag' => '📘 Tài liệu TOEFL',
                'highlight' => 'TOEFL Primary Step 1',
                'description' =>
                    'giúp học sinh từ 8-11 tuổi phát triển toàn diện kỹ năng Nghe và Đọc tiếng Anh, đồng thời làm quen với định dạng bài thi TOEFL Primary do ETS tổ chức. Sách cung cấp từ vựng, ngữ pháp, bài tập thực hành theo từng cấp độ, giúp các em rèn luyện khả năng phản xạ và sử dụng tiếng Anh một cách tự nhiên.',
                'pdf' => 'https://drive.google.com/file/d/1gQzPPMnYKYTxufFMbXmaNHe6yYcsVsmC/view',
                'image' => 'admin/assets/images/ebook/img/TOEFL/image.png',
            ],
            [
                'title' => 'Tải miễn phí bộ sách The Official Guide To The TOEFL Test',
                'tag' => '📘 Tài liệu TOEFL',
                'highlight' => 'The Official Guide To The TOEFL Test',
                'description' =>
                    'giúp người học hiểu rõ cấu trúc bài thi và rèn luyện đầy đủ 4 kỹ năng: Nghe, Nói, Đọc, Viết. Sách cung cấp các bài thi thực hành thật, giúp người học làm quen với dạng câu hỏi và nâng cao kỹ năng làm bài. Ngoài ra, sách còn có chiến lược, mẹo làm bài và hướng dẫn chi tiết.',
                'pdf' =>
                    'https://hawallieltblog.wordpress.com/wp-content/uploads/2011/04/the-official-guide-to-the-toefl-ibt.pdf',
                'image' => 'admin/assets/images/ebook/img/TOEFL/image43.png',
            ],
            [
                'title' => 'Tải miễn phí bộ sách Perfect TOEFL Junior Practice Test PDF',
                'tag' => '📘 Tài liệu TOEFL',
                'highlight' => 'Perfect TOEFL Junior Practice Test',
                'description' =>
                    'giúp học sinh trung học phát triển toàn diện các kỹ năng nghe, đọc, và ngữ pháp để chuẩn bị cho kỳ thi TOEFL Junior. Sách cung cấp đề thi thực hành sát với đề thi thật, giúp người học làm quen với cấu trúc bài thi và cải thiện kỹ năng làm bài.',
                'pdf' => 'https://drive.google.com/drive/folders/1RCaIivw77jNpVtf8_1yw0s6jTl1f37v5',
                'image' => 'admin/assets/images/ebook/img/TOEFL/image37.png',
            ],
            [
                'title' => 'Tải miễn phí bộ sách American English File',
                'tag' => '📘 Tài liệu TOEFL',
                'highlight' => 'American English File',
                'description' =>
                    'giúp người học phát triển toàn diện 4 kỹ năng nghe, nói, đọc, viết thông qua các chủ đề giao tiếp thực tế, đồng thời rèn luyện phát âm chuẩn giọng Mỹ, củng cố ngữ pháp và mở rộng từ vựng theo lộ trình bài bản từ cơ bản đến nâng cao.',
                'pdf' => 'https://drive.google.com/file/d/191Ro1-7278cK3KhTYipWBei_uIA-xaPa/view?usp=sharing',
                'image' => 'admin/assets/images/ebook/img/TOEFL/image1.png',
            ],
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
                        <li><a href="{{ $book['pdf'] }}">📥 Tải file PDF + audio</a></li>
                    </ul>
                    <a href="#" class="psi-buy-btn">Mua sách</a>
                </div>
                <div class="psi-book-image">
                    <img src="{{ asset($book['image']) }}" alt="TOEFL Book Cover">
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
