@if (auth()->user())
				@if ($is_reviewed)
								<h4>Thông tin đánh giá</h4>
								<div class="card">
												<form action="{{ route('user.product.review', ['slug' => $product->slug]) }}" method="POST">
																@csrf
																<input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
																<input type="hidden" name="order_id" id="order_id" value="{{ $orderIds[0] }}">
																<input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
																<div class="row card-body">
																				<div class="review_rating">
																								<input type="radio" checked value="0" id="star-0" name="rating" />
																								<label for="star-1">★</label>
																								<input type="radio" value="1" id="star-1" name="rating" />
																								<label for="star-2">★</label>
																								<input type="radio" value="2" id="star-2" name="rating" />
																								<label for="star-3">★</label>
																								<input type="radio" value="3" id="star-3" name="rating" />
																								<label for="star-4">★</label>
																								<input type="radio" value="4" id="star-4" name="rating" />
																								<label for="star-5">★</label>
																								<input type="radio" value="5" id="star-5" name="rating" />
																				</div>
																				<div class="mb-3">
																								<label for="">{{ __('Bình luận') }}:</label>
																								<x-textarea name="content" class="form-control" :required="true"></x-textarea>
																				</div>
																				<div class="card-body d-flex justify-content-between p-2">
																								<x-button.submit style="border: none" class="btn-default" :title="__('Đăng')" />
																				</div>
																</div>
												</form>
								</div>
				@endif
@endif
