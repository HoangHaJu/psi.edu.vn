<script>
				let currentHiddenAttributeValues = [];
				$(document).ready(function() {
								$('.category-checkbox:checked, input[name="color_slugs[]"]:checked, input[name="size_slugs[]"]:checked')
												.each(function() {
																let slug = $(this).val();
																let name = $(this).next('label').text() || $(this).closest('label').find('.checkmark').attr(
																				'title');
																let type = $(this).attr('name').split('_')[0];

																addChip(slug, name, type);
												});

								$('input[name="category_slugs[]"], input[name="color_slugs[]"], input[name="size_slugs[]"]').on(
												'change',
												function() {
																let slug = $(this).val();
																let name = $(this).next('label').text() || $(this).closest('label').find('.checkmark').attr(
																				'title');
																let type = $(this).attr('name').split('_')[0];

																if ($(this).is(':checked')) {
																				addChip(slug, name, type);
																} else {
																				removeChip(slug, type);
																}
												});

								$(document).on('click', '.remove-chip', function() {
												let slug = $(this).data('slug');
												let type = $(this).data('type');
												$(`input[name="${type}_slugs[]"][value="${slug}"]`).prop('checked',
																false);
												removeChip(slug, type);
								});

								function updateCountdown() {
												const startTime = new Date();
												const endTime = new Date('{{ $product->on_flash_sale->end_time ?? 0 }}');
												const diffInMs = endTime - startTime;
												const diffInHours = Math.floor(diffInMs / 3600000);
												const diffInMinutes = Math.floor((diffInMs % 3600000) / 60000);
												const diffInSeconds = Math.floor((diffInMs % 60000) / 1000);
												const diffInMilliseconds = diffInMs % 1000;
												const formattedTime =
																`${diffInHours.toString().padStart(2, '0')} Giờ : ${diffInMinutes.toString().padStart(2, '0')} Phút : ${diffInSeconds.toString().padStart(2, '0')} Giây`;
												document.getElementById('countdown-flashsale-product').textContent = formattedTime;
								}
								const endTime = '{{ $product->on_flash_sale->end_time ?? 0 }}';
								if (endTime != 0) {
												updateCountdown();
												const countdownInterval = setInterval(updateCountdown, 1000);
								}

								$('.color-btn, .capacity-btn').click(function() {
												// Prevent click if the button is "disabled"
												if ($(this).hasClass('disabled')) {
																return; // Exit the function, preventing AJAX call
												}

												var attributeName = $(this).data('attribute-name');
												var attributeId = $(this).data('attribute-id');
												var attributeVariationId = $(this).data('attribute-variation-id');
												let hiddenAttributeValues = [];
												const elements = document.querySelectorAll("#hiddenAttribute");

												$('#attribute_variation_name' + attributeId).text(attributeName);
												$('input[name="attribute_variation_ids[' + attributeId + ']"]').val(attributeVariationId);

												// Add "disabled" class to temporarily disable the buttons
												$('.color-btn, .capacity-btn').addClass('disabled').css({
																'pointer-events': 'none',
																'opacity': '0.5'
												});

												elements.forEach(element => {
																hiddenAttributeValues.push(element.value);
												});

												const hasEmpty = hiddenAttributeValues.some(value => value === '');
												if (!hasEmpty && !arraysEqual(currentHiddenAttributeValues, hiddenAttributeValues)) {
																currentHiddenAttributeValues = hiddenAttributeValues;
																$.ajax({
																				type: "GET",
																				url: '{{ route('user.product.findVariationByAttributeVariationIds') }}',
																				data: {
																								attribute_variation_ids: hiddenAttributeValues,
																								product_id: $('input[name="hidden_product_id"]').val()
																				},
																				success: function(response) {
																								$('#productVariationPrice').text(response.data.price);
																								$('#productVariationPromotionPrice').text(response.data
																												.promotion_price);
																								if (response.data.qty == 0) {
																												$('#instock').text(`Hết hàng`);
																								} else {
																												$('#instock').text(`còn ${response.data.qty} hàng`);
																												$('input[name="hidden_quantity"]').val(response.data.qty);
																												$('input[name="hidden_product_variation_id"]').val(response.data
																																.id);
																												$('#filter-input-detail').removeAttr('readonly');
																												$('#btnAddToCart').removeAttr('disabled');
																												$('#btnBuyNow').removeAttr('disabled');
																												$('#btnIncrement').removeAttr('disabled');
																												$('#btnDecrement').removeAttr('disabled');
																								}
																				},
																				error: function(response) {
																								Swal.fire({
																												icon: 'warning',
																												title: 'Lưu ý',
																												text: `${response.responseJSON.message}`,
																												showConfirmButton: true,
																												confirmButtonColor: "#1c5639",
																								});
																				},
																				complete: function() {
																								// Remove "disabled" class and reset CSS to enable the buttons after AJAX completes
																								$('.color-btn, .capacity-btn').removeClass('disabled').css({
																												'pointer-events': 'auto',
																												'opacity': '1'
																								});
																				}
																});
												} else {
																// Enable buttons if no AJAX call is made
																$('.color-btn, .capacity-btn').removeClass('disabled').css({
																				'pointer-events': 'auto',
																				'opacity': '1'
																});
												}
								});



								$('#btnAddToCart').click(function(e) {
												$('#btnAddToCart').prop('disabled', true);
												var productId = $('input[name="hidden_product_id"]').val();
												var productImageUrl = $('input[name="hidden_avatar"]').val();
												var productVariationId = $('input[name="hidden_product_variation_id"]').val();
												var qty = $('#filter-input-detail').val();
												$.ajax({
																type: "POST",
																url: '{{ route('user.cart.store') }}',
																data: {
																				product_id: productId,
																				product_variation_id: productVariationId,
																				qty: qty,
																				_token: '{{ csrf_token() }}'
																},
																success: function(response) {
																				$('#cart-count-mobile').text(response.data.count);
																				$('#cart-count').text(response.data.count);
																				handleAddToCartAnimation(productImageUrl);
																},
																error: function(response) {
																				Swal.fire({
																								icon: 'warning',
																								title: 'Lưu ý',
																								text: `${response.responseJSON.message}`,
																								showConfirmButton: true,
																								confirmButtonColor: "#1c5639",
																				});

																},
																complete: function() {
																				loadCartItems();
																				$('#btnAddToCart').removeAttr('disabled');
																}
												});
								});
								$('#btnBuyNow').click(function(e) {
												var productId = $('input[name="hidden_product_id"]').val();
												var productVariationId = $('input[name="hidden_product_variation_id"]').val();
												var qty = $('#filter-input-detail').val();
												$.ajax({
																type: "POST",
																url: '{{ route('user.cart.buyNow') }}',
																data: {
																				product_id: productId,
																				product_variation_id: productVariationId,
																				qty: qty,
																				_token: '{{ csrf_token() }}'
																},
																success: function(response) {
																				if (response.status) {
																								window.location.href =
																												`{{ route('user.cart.checkout') }}?cart_id=${response.data.id}&qty=${response.data.qty}`;
																				} else {
																								Swal.fire({
																												icon: 'warning',
																												title: 'Lưu ý',
																												text: 'Không thể xử lý đơn hàng của bạn!',
																												showConfirmButton: true,
																												confirmButtonColor: "#1c5639",
																								});
																				}
																},
																error: function(response) {
																				Swal.fire({
																								icon: 'warning',
																								title: 'Lưu ý',
																								text: `${response.responseJSON.message}`,
																								showConfirmButton: true,
																								confirmButtonColor: "#1c5639",
																				});
																}
												});
								})
				});

				function incrementDetail() {
								var input = document.getElementById('filter-input-detail');
								var hiddenQuantity = parseInt($('input[name="hidden_quantity"]').val());
								if (parseInt(input.value) + 1 > hiddenQuantity) {
												Swal.fire({
																icon: 'warning',
																title: 'Lưu ý',
																text: 'Số lượng vượt quá hàng trong kho!',
																showConfirmButton: true,
																confirmButtonColor: "#1c5639",
												});
												input.value = hiddenQuantity;
								} else {
												input.value = parseInt(input.value) + 1;
								}
				}

				function isEnoughQuantity(input) {
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
								var hiddenQuantity = parseInt($('input[name="hidden_quantity"]').val());
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
				}

				function decrementDetail() {
								var input = document.getElementById('filter-input-detail');
								if (input.value > 1) {
												input.value = parseInt(input.value) - 1;
								}
				}

				function updatePrice() {
								var minPrice = document.getElementById('min-price').value;
								var maxPrice = document.getElementById('max-price').value;
								document.getElementById('min-price-value').textContent = formatPrice(minPrice);
								document.getElementById('max-price-value').textContent = formatPrice(maxPrice);
				}

				const sort = document.getElementById('sort');
				sort.addEventListener('change', function() {
								const currentUrl = window.location.href;
								const urlWithoutSort = currentUrl.replace(/(\?|&)sort=[^&]+/g, '');
								if (this.value === 'default') {
												window.location = `${urlWithoutSort}`;
								} else if (this.value === 'price-asc') {
												if (urlWithoutSort == '{{ route('user.product.indexUser') }}') {
																window.location = `${urlWithoutSort}?sort=asc`;
												} else {
																window.location = `${urlWithoutSort}&sort=asc`;
												}
								} else if (this.value === 'price-desc') {
												if (urlWithoutSort == '{{ route('user.product.indexUser') }}') {
																window.location = `${urlWithoutSort}?sort=desc`;
												} else {
																window.location = `${urlWithoutSort}&sort=desc`;
												}
								}
				});

				const filterByPriceCheckbox = document.getElementById('filter-by-price');
				const minPriceInput = document.getElementById('min-price');
				const maxPriceInput = document.getElementById('max-price');

				filterByPriceCheckbox.addEventListener('change', () => {
								if (filterByPriceCheckbox.checked) {
												// Kích hoạt input range
												minPriceInput.disabled = false;
												maxPriceInput.disabled = false;
								} else {
												// Vô hiệu hóa input range
												minPriceInput.disabled = true;
												maxPriceInput.disabled = true;
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
																				Swal.fire({
																								icon: 'warning',
																								title: 'Lưu ý',
																								text: `${response.responseJSON.message}`,
																								showConfirmButton: true,
																								confirmButtonColor: "#1c5639",
																				});
																}
												});
								}
				}
</script>
