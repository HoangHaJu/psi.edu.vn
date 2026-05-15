<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"
    integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.css"
    integrity="sha512-C4k/QrN4udgZnXStNFS5osxdhVECWyhMsK1pnlk+LkC7yJGCqoYxW4mH3/ZXLweODyzolwdWSqmmadudSHMRLA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .tool-edit-cover {
        left: 0%;
        position: absolute;
        width: 150px;
        text-align: center;
        bottom: 0;
        background: #ffffffbd;
        color: #ff5400;
        cursor: pointer;
        top: 80%;
        height: 0px;
    }

    /* Modal overlay */
    .modal-edit-image.modal {
        display: none;
        position: fixed;
        z-index: 3;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);

        /* căn giữa nội dung bên trong */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-edit-image {
        justify-content: center;
        align-items: center;
    }

    /* Nội dung chính của modal */
    .modal-edit-image .modal-content-edit {
        background-color: #fefefe;
        border: 1px solid #888;
        border-radius: 8px;
        padding: 20px;

        /* Cố định kích thước hoặc co giãn theo màn hình */
        width: 800px;
        height: 600px;
        max-width: 90vw;
        max-height: 90vh;

        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .modal-cover-photo {
        width: 150px;
        position: relative;
    }

    #previewCover {
        border-radius: 50%;
    }

    #previewCover img {
        border-radius: 50%;
        width: 150px !important;
        height: 150px;
        border: 5px solid #fff;
    }

    /* Khu vực cropper */
    .modal-edit-image .cropper-container {
        flex-grow: 1;
        width: 100%;
        overflow: hidden;
        margin-top: 16px;
        height: 100%;
    }

    /* Đảm bảo ảnh trong cropper luôn vừa khung */
    .modal-edit-image .cropper-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* Nút cắt ảnh */
    .modal-edit-image .crop-button {
        margin-top: 10px;
    }

    /* Footer nút đóng / cắt */
    .modal-edit-image .modal-content-edit .py-2 {
        margin-top: 12px;
        text-align: right;
    }
</style>


<div id="myModal1" class="modal modal-edit-image">
    <div class="modal-content-edit">
        <div class="cropper-container">
            <img src="" id="modal-image-preview1" alt="Preview">
        </div>
        <div class="py-2 text-end">
            <button style="background-color: #ff7d7d;" type="button" class="close1 btn btn-danger">Đóng</button>
            <button style="background-color: #3d8bf7" id="crop-button1" type="button" class="btn btn-primary">Cắt
                ảnh</button>
        </div>
    </div>
</div>

<!-- Div for cropped image preview -->
<script>
    const imageInput1 = document.getElementById('coverInp');
    const modal1 = document.getElementById('myModal1');
    modal1.style.display = 'none';
    const modalImagePreview1 = document.getElementById('modal-image-preview1');
    const cropButton1 = document.getElementById('crop-button1');
    const closeButton1 = document.getElementsByClassName('close1')[0];
    const croppedPreview1 = document.getElementById('previewCover');
    let cropper1;
    let lastImageDataURL = ""; // lưu ảnh cuối cùng để có thể mở lại cropper

    // Khi click vào ảnh:
    croppedPreview1.addEventListener('click', () => {
        if (lastImageDataURL) {
            // Nếu đã có ảnh trước đó, mở modal crop lại
            openCropper(lastImageDataURL);
        } else {
            // Nếu chưa có ảnh, mở chọn file
            imageInput1.click();
        }
    });

    function openModal1() {
        modal1.style.display = 'flex';
    }

    function closeModal1() {
        modal1.style.display = 'none';
    }

    function openCropper(imageSrc) {
        modalImagePreview1.src = imageSrc;
        if (cropper1) cropper1.destroy();

        cropper1 = new Cropper(modalImagePreview1, {
            aspectRatio: 1,
            viewMode: 1,
        });
        openModal1();
    }

    cropButton1.addEventListener('click', () => {
        const croppedCanvas1 = cropper1.getCroppedCanvas();
        const croppedImage1 = new Image();
        croppedImage1.src = croppedCanvas1.toDataURL();
        croppedPreview1.innerHTML = '';
        croppedPreview1.appendChild(croppedImage1);

        lastImageDataURL = croppedImage1.src; // lưu ảnh để có thể crop lại sau này

        croppedCanvas1.toBlob((blob) => {
            let file = new File([blob], "cover.png", {
                type: "image/png",
                lastModified: new Date().getTime()
            });
            let container = new DataTransfer();
            container.items.add(file);
            imageInput1.files = container.files;
            closeModal1();
        });
    });

    closeButton1.addEventListener('click', closeModal1);

    imageInput1.addEventListener('change', (e) => {
        const file1 = e.target.files[0];
        if (!file1) return;

        const reader1 = new FileReader();
        reader1.onload = (event) => {
            lastImageDataURL = event.target.result; // lưu để mở lại
            openCropper(event.target.result);
        };
        reader1.readAsDataURL(file1);
    });
</script>
