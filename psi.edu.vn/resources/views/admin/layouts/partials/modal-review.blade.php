<!-- Modal -->
<div class="modal fade" id="reviewCourse" tabindex="-1" aria-labelledby="reviewCourseLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body justify-content-center">
                <x-form :action="route('admin.review.store')" type="post" class="mb-3">
                    <h3 class="bold-text text-center">{{ __('Đánh giá khoá học') }}</h3>
                    <div class="p-2">
                        <div class="review_rating text-center">
                            <input type=radio checked value='0' id='star-0' name='rating' />

                            <label for='star-1'>★</label>
                            <input type=radio value='1' id='star-1' name='rating' />

                            <label for='star-2'>★</label>
                            <input type=radio value='2' id='star-2' name='rating' />

                            <label for='star-3'>★</label>
                            <input type=radio value='3' id='star-3' name='rating' />

                            <label for='star-4'>★</label>
                            <input type=radio value='4' id='star-4' name='rating' />

                            <label for='star-5'>★</label>
                            <input type=radio value='5' id='star-5' name='rating' />
                        </div>
                        <x-input name="content" placeholder="{{ __('Đánh giá') }}" />
                        <x-input type="hidden" id="bookingIdInput" name="booking_id" :required="true" />
                    </div>
                    <div class="text-center"><button type="submit" class="btn btn-default text-center">Xác nhận đánh
                            giá</button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</div>

<style>
    .review_rating {
        input {
            display: none;

            &:checked {
                &~label {
                    color: #aaa;
                }
            }
        }

        label {
            color: orange;
            font-size: 2rem;
        }
    }

    h1 {
        font-family: sans-serif;
        color: #222;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lắng nghe sự kiện khi modal hiển thị
        const modal = document.getElementById('reviewCourse');
        modal.addEventListener('show.bs.modal', function(event) {
            // Lấy nút được nhấn để mở modal
            const button = event.relatedTarget;

            // Lấy giá trị data-id từ nút
            const bookingId = button.getAttribute('data-id');

            // Tìm input trong modal và gán giá trị
            const inputBookingId = document.getElementById('bookingIdInput');
            inputBookingId.value = bookingId;
        });
    });
</script>
