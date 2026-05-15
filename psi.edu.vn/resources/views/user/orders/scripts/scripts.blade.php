<script>
				$(document).on('click', '#review', function(e) {
								e.preventDefault();
								var url = $(this).attr('href');

								Swal.fire({
												title: "Đánh giá đơn hàng",
												html: `
                <div class="review_rating">
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
                <div class="mb-3">
                    <textarea name="content" class="form-control" placeholder="Nhập đánh giá của bạn tại đây... "></textarea>
                </div>
            `,
												showCancelButton: true,
												confirmButtonColor: "#1c5639",
												cancelButtonColor: "#d33",
												confirmButtonText: "Đánh giá!",
												cancelButtonText: "Quay lại!",
												preConfirm: () => {
																const rating = parseInt(document.querySelector('input[name="rating"]:checked').value);
																const review = document.querySelector('textarea[name="content"]').value;
																if (!review || !rating) {
																				Swal.showValidationMessage('Vui lòng nhập đánh giá và chọn số sao.');
																				return false;
																}
																return {
																				review: review,
																				rating: rating
																};
												}
								}).then((result) => {
												if (result.isConfirmed) {
																const rating = result.value.rating;
																const review = result.value.review;
																window.location.href = `${url}?rating=${rating}&review=${review}`;
												}
								});
				});

				$(document).on('click', '#review-detail', function(e) {
								e.preventDefault();
								var url = $(this).attr('href');

								$.ajax({
												url: url,
												type: 'GET',
												dataType: 'json',
												success: function(data) {
																let reviewHtml = '';
																data.response.reviewsDetail.forEach(review => {
																				reviewHtml += `
                    <div class="d-flex mb-3">
                        <img src="${data.response.user.avatar}" alt="Customer Image" class="customer-image me-3">
                        <div class="rating" style="text-align:left">
                            <strong>${data.response.user.fullname}</strong> - ${review.review_created_at}
                            <br>
                            Sản phẩm ${review.product_name}
                            <br>
                            ${'<span class="star">★</span>'.repeat(review.review_rating)}${'<span class="star" style="color: gray">★</span>'.repeat(5 - review.review_rating)}
                            <p>${review.review_content}</p>
                        </div>
                    </div>`;
																});

																Swal.fire({
																				title: "Đánh giá đơn hàng",
																				html: reviewHtml,
																				confirmButtonColor: "#1c5639"
																});
												},
												error: function(xhr, status, error) {
																console.error(xhr.responseText);
																Swal.fire('Error!', 'Could not fetch review data.', 'error');
												}
								});
				});

				$(document).on('click', '#cancel-order', function(e) {
								e.preventDefault();
								var url = $(this).attr('href');

								Swal.fire({
												title: "Bạn có chắc chắn muốn hủy đơn này?",
												icon: "warning",
												showCancelButton: true,
												confirmButtonColor: "#1c5639",
												cancelButtonColor: "#d33",
												confirmButtonText: "Chắc chắn!",
												cancelButtonText: "Quay lại!"
								}).then((result) => {
												if (result.isConfirmed) {
																window.location.href = url;
												}
								});
				});
</script>
