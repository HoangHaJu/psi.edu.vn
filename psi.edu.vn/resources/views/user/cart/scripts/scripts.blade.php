<script>
				function updateProgress(total, object) {
								let percentage = (total / object) * 100;
								percentage = percentage >= 100 ? 100 : Math.round(percentage);

								const progressBar = document.getElementById('progressBar');
								const progressText = document.getElementById('progressText');

								progressBar.style.width = `${percentage}%`;

								progressText.textContent = `${percentage}%`;
								progressText.style.color = percentage >= 50 ? '#ffffff' : '#000000';
				}

				function updateText(response) {
								$('#cart-count-mobile').text(response.data.count);
								$('#cart-count').text(response.data.count);
								$('#total-spend').text(formatPrice(response.data.total))
								$('#totalOrder').text(formatPrice(response.data.total));
								$('#totalAfterDiscount').text(formatPrice(response.data.total));
								updateProgress(response.data.total, {{ $object }})
				}


				function updateProductTotal(id) {
								const quantityInput = document.getElementById('quantity-input' + id);
								const quantity = parseInt(quantityInput.value);
								const priceElement = quantityInput.closest('tr').querySelector('[data-label="Giá"]');
								const totalElement = quantityInput.closest('tr').querySelector('[data-label="Tổng"]');

								if (priceElement && totalElement) {
												const price = parseFloat(priceElement.textContent.replace(/[^0-9.-]+/g,
																""));
												const newTotal = price * quantity;
												const formattedPrice = formatPrice(newTotal);
												totalElement.textContent = formattedPrice;
								}
				}

				function incrementCart(button) {
								$(button).prop('disabled', true);
								var id = $(button).data('id');
								var input = $(`#quantity-input` + id);
								var hiddenValue = $(`input[name="hidden_product_qty${id}"]`);

								if (input.val() == hiddenValue.val()) {
												Swal.fire({
																icon: 'warning',
																title: 'Lưu ý',
																text: 'Số lượng vượt quá hàng trong kho!',
																showConfirmButton: true,
																confirmButtonColor: "#1c5639",
												});
												input.val(parseInt(hiddenValue.val()));
												$(button).prop('disabled', false);
								} else {
												input.val(parseInt(input.val()) + 1);
												$.ajax({
																type: "POST",
																url: '{{ route('user.cart.increament') }}',
																data: {
																				id: id,
																				_token: '{{ csrf_token() }}'
																},
																success: function(response) {
																				updateText(response);
																},
																error: function(response) {
																				Swal.fire({
																								icon: 'warning',
																								title: 'Lưu ý',
																								text: `${response.responseJSON.message}`,
																								showConfirmButton: false
																				});
																},
																complete: function() {
																				$(button).prop('disabled', false);
																}
												});
												updateProductTotal(id);
								}
				}

				function decrementCart(button) {
								$(button).prop('disabled', true);
								var id = $(button).data('id');
								var input = $(`#quantity-input` + id);
								var currentValue = parseInt(input.val());
								if (currentValue == 1) {
												const row = button.closest('tr');
												if (row) {
																row.remove();
												}
								}
								input.val(currentValue - 1);
								$.ajax({
												type: "POST",
												url: '{{ route('user.cart.decreament') }}',
												data: {
																id: id,
																_token: '{{ csrf_token() }}'
												},
												success: function(response) {
																updateText(response);
												},
												error: function(response) {
																Swal.fire({
																				icon: 'warning',
																				title: 'Lưu ý',
																				text: `${response.responseJSON.message}`,
																				showConfirmButton: true,
																				confirmButtonColor: "#1c5639",
																});
																updateText(response.responseJSON);
												},
												complete: function() {
																$(button).prop('disabled', false);
												}
								});
								updateProductTotal(id);
				}

				function removeCart(button) {
								var id = $(button).data('id');
								const row = button.closest('tr');
								if (row) {
												Swal.fire({
																title: "Bạn có chắc chắn muốn thực hiện?",
																icon: "info",
																showCancelButton: true,
																confirmButtonColor: "#1c5639",
																cancelButtonColor: "#d33",
																confirmButtonText: "Chắc chắn!",
																cancelButtonText: "Quay lại!"
												}).then((result) => {
																if (result.isConfirmed) {
																				row.remove();
																				$.ajax({
																								type: "DELETE",
																								url: '{{ route('user.cart.remove') }}' + `/${id}`,
																								data: {
																												_token: '{{ csrf_token() }}'
																								},
																								success: function(response) {
																												updateText(response);
																								},
																								error: function(response) {
																												Swal.fire({
																																icon: 'warning',
																																title: 'Lưu ý',
																																text: `${response.responseJSON.message}`,
																																showConfirmButton: true,
																																confirmButtonColor: "#1c5639",
																												});
																												updateText(response.responseJSON);
																								}
																				});
																				updateProductTotal(id);
																}
												});
								}
				}

				function isEnoughQuantityCart(input) {
								var id = $(input).data('id');
								if (!/^\d+$/.test(input.value)) {
												Swal.fire({
																icon: 'warning',
																title: 'Lưu ý',
																text: 'Vui lòng chỉ nhập số!',
																showConfirmButton: true,
																confirmButtonColor: "#1c5639",
												});
												input.value = 1;
								}
								if (input.value <= 0) {
												Swal.fire({
																icon: 'warning',
																title: 'Lưu ý',
																text: 'Số lượng phải lớn hơn 0!',
																showConfirmButton: true,
																confirmButtonColor: "#1c5639",
												});
												input.value = 1;
								}
								var hiddenQuantity = parseInt($(`input[name="hidden_product_qty${id}"]`).val());
								if (input.value > hiddenQuantity) {
												Swal.fire({
																icon: 'warning',
																title: 'Lưu ý',
																text: `Số lượng vượt quá hàng trong kho, còn lại ${hiddenQuantity} sản phẩm!`,
																showConfirmButton: true,
																confirmButtonColor: "#1c5639",
												});
												input.value = 1;
								}
								var qty = parseInt($(input).val());
								$.ajax({
												type: "PUT",
												url: '{{ route('user.cart.update') }}',
												data: {
																id: id,
																qty: qty,
																_token: '{{ csrf_token() }}',
												},
												success: function(response) {
																updateText(response);
												},
												error: function(response) {
																Swal.fire({
																				icon: 'warning',
																				title: 'Lưu ý',
																				text: `${response.responseJSON.message}`,
																				showConfirmButton: true,
																				confirmButtonColor: "#1c5639",
																});
																input.value = 1;
												}
								});
								updateProductTotal(id);
				}
</script>
