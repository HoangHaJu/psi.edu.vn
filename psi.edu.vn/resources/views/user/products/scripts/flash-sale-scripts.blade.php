<script>
				$(document).ready(function() {
								function updateCountdown() {
												const startTime = new Date();
												const endTime = new Date('{{ $flashSale->end_time ?? 0 }}');

												const diffInMs = endTime - startTime;
												const diffInHours = Math.floor(diffInMs / 3600000);
												const diffInMinutes = Math.floor((diffInMs % 3600000) / 60000);
												const diffInSeconds = Math.floor((diffInMs % 60000) / 1000);
												const diffInMilliseconds = diffInMs % 1000;
												const formattedTime =
																`${diffInHours.toString().padStart(2, '0')} Giờ : ${diffInMinutes.toString().padStart(2, '0')} Phút : ${diffInSeconds.toString().padStart(2, '0')} Giây`;
												document.getElementById('countdown-flashsale-product').textContent = formattedTime;
								}
								const endTime = '{{ $flashSale->end_time ?? 0 }}';
								if (endTime != 0) {
												updateCountdown();
												const countdownInterval = setInterval(updateCountdown, 1000);
								}
				});

				function showDetailProductModal(modal, product_id) {
								if (product_id) {
												$.ajax({
																type: "GET",
																url: '{{ route('user.product.render') }}' + `/${product_id}`,
																success: function(response) {
																				$("#resultQuickViewRequest").html(response);
																				openModal(modal);
																},
																error: function(response) {
																				handleAjaxError(response);
																}
												});
								}
				}
</script>
