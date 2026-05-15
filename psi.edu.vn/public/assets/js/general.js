// --- 1. Module xử lý Video Player (tự động phát/tạm dừng, điều khiển âm lượng) ---
const VideoPlayerHandler = (() => {
    let videoElement; // Renamed to clearly indicate it's an HTMLElement
    let toggleVolumeButton;
    let volumeIcon;
    let intersectionObserver; // Renamed for clarity

    /**
     * Cập nhật biểu tượng âm lượng dựa trên trạng thái 'muted' của video.
     */
    const updateVolumeIcon = () => {
        if (!volumeIcon || !videoElement) {
            // Log a warning if elements are not found, preventing errors
            console.warn("Volume icon or video element not found for updateVolumeIcon.");
            return;
        }

        if (videoElement.muted) {
            volumeIcon.classList.remove("bi-volume-up-fill");
            volumeIcon.classList.add("bi-volume-mute-fill");
        } else {
            volumeIcon.classList.remove("bi-volume-mute-fill");
            volumeIcon.classList.add("bi-volume-up-fill");
        }
    };

    /**
     * Xử lý khi video thay đổi trạng thái hiển thị trên khung nhìn (Intersection Observer callback).
     * @param {Array<IntersectionObserverEntry>} entries - Mảng các đối tượng IntersectionObserverEntry.
     */
    const handleIntersection = (entries) => {
        entries.forEach((entry) => {
            if (entry.target !== videoElement) return; // Ensure we are handling the correct video

            if (entry.isIntersecting) {
                // Nếu video nằm trong khung nhìn, cố gắng phát
                videoElement.play().catch((error) => {
                    // Autoplay can be tricky. Browsers often block unmuted autoplay.
                    // Suggesting a user interaction (like a click to play/unmute) if it fails.
                    console.warn("Video autoplay failed (possibly unmuted or browser policy):", error);
                    // Consider adding a visible play button or unmute prompt here
                });
            } else {
                // Nếu video không còn trong khung nhìn, tạm dừng và tắt tiếng
                if (!videoElement.paused) {
                    // Only pause if it's currently playing
                    videoElement.pause();
                }
                if (!videoElement.muted) {
                    // Only mute if it's currently unmuted
                    videoElement.muted = true;
                    updateVolumeIcon(); // Cập nhật biểu tượng khi tắt tiếng
                }
            }
        });
    };

    /**
     * Xử lý khi nhấp vào nút bật/tắt âm lượng.
     */
    const handleToggleVolumeClick = () => {
        if (!videoElement) return;

        videoElement.muted = !videoElement.muted; // Chuyển đổi trạng thái tắt tiếng
        updateVolumeIcon(); // Cập nhật biểu tượng ngay lập tức

        // Đảm bảo video đang phát khi bật tiếng (nếu trước đó đang tạm dừng)
        // This ensures if a user mutes and then unmutes while scrolled away,
        // and then scrolls back, it will attempt to play.
        if (!videoElement.muted && videoElement.paused) {
            videoElement.play().catch((error) => {
                console.warn("Manual play failed after unmuting:", error);
            });
        }
    };

    /**
     * Khởi tạo module VideoPlayerHandler.
     * Tìm kiếm các phần tử DOM cần thiết và thiết lập các trình lắng nghe sự kiện.
     */
    const init = () => {
        videoElement = document.getElementById("expertReviewVideo");
        toggleVolumeButton = document.getElementById("toggleVolumeButton");

        if (!videoElement || !toggleVolumeButton) {
            console.warn(
                "VideoPlayerHandler: Missing 'expertReviewVideo' or 'toggleVolumeButton' elements. Module not initialized."
            );
            return;
        }

        volumeIcon = toggleVolumeButton.querySelector("i");
        if (!volumeIcon) {
            console.warn(
                "VideoPlayerHandler: Missing icon element within 'toggleVolumeButton'. Volume icon updates will not work."
            );
            // We can still proceed with video control, but icon won't update
        }

        // Khởi tạo Intersection Observer
        intersectionObserver = new IntersectionObserver(handleIntersection, {
            threshold: 0.5, // Kích hoạt khi ít nhất 50% video nằm trong khung nhìn
        });
        intersectionObserver.observe(videoElement); // Bắt đầu quan sát video

        // Đăng ký sự kiện nhấp vào nút điều khiển âm lượng
        toggleVolumeButton.addEventListener("click", handleToggleVolumeClick);

        // Đồng bộ biểu tượng khi trạng thái volume của video thay đổi (ví dụ: người dùng kéo thanh trượt)
        videoElement.addEventListener("volumechange", updateVolumeIcon);

        // Cập nhật biểu tượng ngay khi tải trang dựa trên trạng thái ban đầu của video
        updateVolumeIcon();

        // Initial state: ensure video is muted on load for better autoplay chances
        videoElement.muted = true;
        updateVolumeIcon();
    };

    return {
        init: init,
    };
})();

// --- 2. Module quản lý Iframe YouTube ngẫu nhiên ---
const YoutubeIframeManager = (() => {
    // It's crucial that these are actual YouTube embed URLs, not just arbitrary strings.
    // Example format: "https://www.youtube.com/embed/VIDEO_ID?autoplay=0&controls=1&modestbranding=1&rel=0"
    // Note: autoplay=0 is usually recommended for embeds unless specific user interaction.
    const youtubeVideoIds = [
        "OdxukY0Hnxo", // Rick Astley - Never Gonna Give You Up (Example)
        "PqyysUW8SIM", // Another example ID
        "6mPGb-M-EnM", // Yet another example ID
        "qP3Ox-o64SQ", // One more
        // Add your actual YouTube video IDs here
    ];

    /**
     * Hàm Fisher-Yates shuffle để xáo trộn mảng.
     * @param {Array} array - Mảng cần xáo trộn.
     */
    const shuffleArray = (array) => {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    };

    /**
     * Khởi tạo module YoutubeIframeManager.
     * Gán các liên kết YouTube ngẫu nhiên vào các iframe tìm thấy.
     */
    const init = () => {
        const iframes = document.querySelectorAll(".review-card .video-wrapper iframe");

        if (iframes.length === 0) {
            console.warn(
                "YoutubeIframeManager: Không tìm thấy iframe nào với selector '.review-card .video-wrapper iframe'."
            );
            return;
        }

        if (youtubeVideoIds.length === 0) {
            console.warn("YoutubeIframeManager: Không có ID video YouTube nào được cung cấp. Không thể tải iframe.");
            return;
        }

        let shuffledVideoIds = [...youtubeVideoIds]; // Tạo một bản sao để xáo trộn
        shuffleArray(shuffledVideoIds);

        iframes.forEach((iframe, index) => {
            // Construct the YouTube embed URL with necessary parameters
            // Using `enablejsapi=1` allows for more control via JS (e.g., stopping video)
            // `modestbranding=1` hides YouTube logo, `rel=0` prevents related videos at end
            const videoId = shuffledVideoIds[index % shuffledVideoIds.length];
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=0&controls=1&modestbranding=1&rel=0&enablejsapi=1`;

            // Thêm các thuộc tính iframe an toàn và tốt cho hiệu suất
            iframe.setAttribute("frameborder", "0");
            iframe.setAttribute(
                "allow",
                "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            );
            iframe.setAttribute("allowfullscreen", "");
            // Add a title for accessibility
            iframe.setAttribute("title", `YouTube video player for review ${index + 1}`);
        });
    };

    return {
        init: init,
    };
})();

// --- 3. Module khởi tạo Swiper Slider ---
const SwiperInitializer = (() => {
    /**
     * Khởi tạo module SwiperInitializer.
     * Kiểm tra sự tồn tại của thư viện Swiper và khởi tạo slider.
     */
    const init = () => {
        // Kiểm tra xem thư viện Swiper có sẵn không
        if (typeof Swiper === "undefined") {
            console.error(
                "SwiperInitializer: Thư viện Swiper JS không được tìm thấy. Vui lòng đảm bảo bạn đã nhúng Swiper JS trước khi script này chạy."
            );
            return;
        }

        // Khởi tạo Swiper
        // Ensure that '.mySwiper' element exists on the page
        const swiperContainer = document.querySelector(".mySwiper");
        if (!swiperContainer) {
            console.warn("SwiperInitializer: Không tìm thấy phần tử Swiper với selector '.mySwiper'.");
            return;
        }

        new Swiper(swiperContainer, {
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
            // Optional: Add accessibility features
            a11y: {
                prevSlideMessage: "Previous slide",
                nextSlideMessage: "Next slide",
            },
            // Optional: Keyboard navigation
            keyboard: {
                enabled: true,
                onlyInViewport: true,
            },
        });
    };

    return {
        init: init,
    };
})();

// --- 4. Module xử lý Modal Chi tiết Tin tức ---
const NewsDetailModalHandler = (() => {
    let newsDetailModalElement; // Renamed for clarity
    let modalPostImage, modalPostTitle, modalPostDate, modalPostBody;
    let triggerElementOnShow = null; // Biến để lưu lại phần tử đã kích hoạt modal

    /**
     * Lấy các phần tử con của modal.
     */
    const getModalElements = () => {
        if (!newsDetailModalElement) return;
        modalPostImage = newsDetailModalElement.querySelector("#modalPostImage");
        modalPostTitle = newsDetailModalElement.querySelector("#modalPostTitle");
        modalPostDate = newsDetailModalElement.querySelector("#modalPostDate");
        modalPostBody = newsDetailModalElement.querySelector("#modalPostBody");
    };

    /**
     * Hàm xử lý sự kiện "show.bs.modal" (Bootstrap 5 event).
     * Điền dữ liệu vào modal từ các thuộc tính data của phần tử kích hoạt.
     * @param {Event} event - Sự kiện Bootstrap modal show.
     */
    const handleModalShow = (event) => {
        // Bootstrap 5 uses `relatedTarget` to get the element that triggered the modal
        triggerElementOnShow = event.relatedTarget;

        if (!triggerElementOnShow) {
            console.warn("NewsDetailModalHandler: Không tìm thấy phần tử kích hoạt modal.");
            return;
        }

        // Using optional chaining for safer attribute access if you have a modern build setup
        // Otherwise, simple getAttribute is fine.
        const postId = triggerElementOnShow.getAttribute("data-post-id"); // Unused in this context, but good to have
        const postTitle = triggerElementOnShow.getAttribute("data-post-title");
        const postImage = triggerElementOnShow.getAttribute("data-post-image");
        const postDate = triggerElementOnShow.getAttribute("data-post-date");
        const postContentEncoded = triggerElementOnShow.getAttribute("data-post-content");

        // Giải mã nội dung HTML một cách an toàn và hiệu quả hơn
        // This is a robust way to decode HTML entities
        const postContent = postContentEncoded
            ? new DOMParser().parseFromString(postContentEncoded, "text/html").body.textContent
            : "";

        if (modalPostImage) {
            modalPostImage.src = postImage || "https://via.placeholder.com/600x400?text=No+Image";
            modalPostImage.alt = postTitle || "Bài viết";
        }
        if (modalPostTitle) modalPostTitle.innerText = postTitle || "Tiêu đề không có sẵn";
        if (modalPostDate) modalPostDate.innerText = postDate || "Ngày không có sẵn";
        if (modalPostBody) {
            // Use innerHTML to render HTML content, assuming postContent is safe HTML or has been sanitized
            modalPostBody.innerHTML = postContent || '<p class="text-muted">Nội dung bài viết không có sẵn.</p>';
        }
    };

    /**
     * Hàm xử lý sự kiện "hidden.bs.modal" (Bootstrap 5 event).
     * Xóa nội dung modal và trả focus về phần tử đã mở.
     */
    const handleModalHidden = () => {
        // Xóa nội dung modal khi ẩn để tránh hiển thị nội dung cũ
        if (modalPostImage) {
            modalPostImage.src = "";
            modalPostImage.alt = "";
        }
        if (modalPostTitle) modalPostTitle.innerText = "";
        if (modalPostDate) modalPostDate.innerText = "";
        if (modalPostBody) modalPostBody.innerHTML = "";

        // Trả focus về phần tử đã mở modal để cải thiện khả năng truy cập (accessibility)
        // Ensure the element is still in the DOM and focusable
        if (triggerElementOnShow && typeof triggerElementOnShow.focus === "function") {
            triggerElementOnShow.focus();
        } else {
            // Fallback to body focus or a more suitable default if triggerElementOnShow is no longer valid
            document.body.focus();
        }
        triggerElementOnShow = null; // Clear the reference
    };

    /**
     * Khởi tạo module NewsDetailModalHandler.
     * Thiết lập các trình lắng nghe sự kiện cho modal.
     */
    const init = () => {
        newsDetailModalElement = document.getElementById("newsDetailModal");

        if (!newsDetailModalElement) {
            console.warn(
                "NewsDetailModalHandler: Không tìm thấy modal với ID 'newsDetailModal'. Module không được khởi tạo."
            );
            return;
        }

        // Get modal child elements once after confirming the modal exists
        getModalElements();

        // Lắng nghe sự kiện show và hidden của Bootstrap Modal
        // Ensure Bootstrap JS is loaded for these events to fire correctly
        newsDetailModalElement.addEventListener("show.bs.modal", handleModalShow);
        newsDetailModalElement.addEventListener("hidden.bs.modal", handleModalHidden);
    };

    return {
        init: init,
    };
})();

// --- 5. Module xử lý tính năng "Xem thêm/Thu gọn" cho văn bản đánh giá ---
// Encapsulating the "Read More" logic into its own module for better organization
const ReviewTextExpander = (() => {
    const characterLimit = 400; // Giới hạn ký tự mặc định

    /**
     * Xử lý hiển thị "Xem thêm/Thu gọn" cho một container văn bản đánh giá.
     * @param {HTMLElement} container - Phần tử container chứa văn bản đánh giá.
     */
    const setupReviewText = (container) => {
        const shortTextSpan = container.querySelector(".review-short-text");
        const fullTextSpan = container.querySelector(".review-full-text");
        const readMoreBtn = container.querySelector(".read-more-btn");

        if (!shortTextSpan || !fullTextSpan || !readMoreBtn) {
            console.warn(
                "ReviewTextExpander: Thiếu một trong các phần tử văn bản hoặc nút 'Xem thêm' trong container.",
                container
            );
            return;
        }

        // Get the original full text from where it's initially populated.
        // It's assumed that the full text is initially present in .review-short-text before truncation.
        const originalFullText = shortTextSpan.textContent.trim();

        // Initially set fullTextSpan's content to the full text
        fullTextSpan.textContent = originalFullText;

        if (originalFullText.length > characterLimit) {
            const truncatedText = originalFullText.substring(0, characterLimit) + "...";
            shortTextSpan.textContent = truncatedText;
            readMoreBtn.style.display = "inline"; // Show the "Xem thêm" button
            fullTextSpan.style.display = "none"; // Ensure full text is hidden initially
            shortTextSpan.style.display = "inline"; // Ensure short text is visible initially
        } else {
            // If the text is shorter than or equal to the limit, show full text and hide button
            readMoreBtn.style.display = "none";
            fullTextSpan.style.display = "inline"; // Show full text
            shortTextSpan.style.display = "none"; // Hide short text (or just keep it as fullTextSpan takes over)
            shortTextSpan.textContent = originalFullText; // Ensure short text also has full text if no truncation
        }

        // Add event listener to the "Read More" button
        readMoreBtn.addEventListener("click", function () {
            if (fullTextSpan.style.display === "none" || fullTextSpan.style.display === "") {
                // Currently showing short text, switch to full text
                shortTextSpan.style.display = "none";
                fullTextSpan.style.display = "inline";
                readMoreBtn.textContent = "Thu gọn"; // Change button text to "Thu gọn"
            } else {
                // Currently showing full text, switch to short text
                shortTextSpan.style.display = "inline";
                fullTextSpan.style.display = "none";
                readMoreBtn.textContent = "Xem thêm";
            }
        });
    };

    /**
     * Khởi tạo module ReviewTextExpander.
     * Tìm tất cả các container văn bản đánh giá và thiết lập chúng.
     */
    const init = () => {
        const reviewTextContainers = document.querySelectorAll(".review-text-container");
        if (reviewTextContainers.length === 0) {
            console.warn("ReviewTextExpander: Không tìm thấy phần tử với selector '.review-text-container'.");
            return;
        }

        reviewTextContainers.forEach(setupReviewText);
    };

    return {
        init: init,
    };
})();

// --- Điểm vào chính của ứng dụng khi DOM đã tải xong ---
// Đảm bảo tất cả các module được khởi tạo sau khi DOM đã được tải đầy đủ.
document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM Content Loaded. Initializing modules...");

    VideoPlayerHandler.init();
    YoutubeIframeManager.init();
    SwiperInitializer.init();
    NewsDetailModalHandler.init();
    ReviewTextExpander.init(); // Initialize the new module
});
document.addEventListener("DOMContentLoaded", function () {
    const ebookToggle = document.getElementById("ebookDropdownToggle");
    const ebookMenu = document.getElementById("ebookDropdownMenu");
    const ebookDropdownContainer = document.getElementById("ebookDropdown");

    if (ebookToggle && ebookMenu && ebookDropdownContainer) {
        // Xử lý khi nhấp vào nút Ebook
        ebookToggle.addEventListener("click", function (event) {
            event.preventDefault(); // Ngăn hành vi mặc định của thẻ 'a'
            ebookMenu.classList.toggle("show"); // Thêm/bỏ lớp 'show'
            ebookDropdownContainer.classList.toggle("show"); // Thêm/bỏ lớp 'show' trên parent li để bootstrap styling (tùy chọn)

            // Đóng menu nếu nhấp ra ngoài
            event.stopPropagation(); // Ngăn sự kiện click nổi bọt lên document ngay lập tức
        });

        // Đóng menu khi nhấp vào bất cứ đâu bên ngoài
        document.addEventListener("click", function (event) {
            if (!ebookDropdownContainer.contains(event.target)) {
                ebookMenu.classList.remove("show");
                ebookDropdownContainer.classList.remove("show");
            }
        });
    }
});
