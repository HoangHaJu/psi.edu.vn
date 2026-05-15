<span @class([
				'badge-status',
				App\Enums\Order\OrderStatus::from($status)->badge(),
])>{{ \App\Enums\Order\OrderStatus::getDescription($status) }}</span>
<br>
@if ($status == App\Enums\Order\OrderStatus::Completed->value && $created_at >= now()->subDays(14))
				@if ($is_reviewed == App\Enums\Order\OrderReview::NotReviewed->value)
								<a class="text-default" id="review" href="{{ route('user.order.review', $id) }}">Đánh giá đơn hàng</a>
				@else
								<a class="text-default" id="review-detail" href="{{ route('user.order.review_detail', $id) }}">Xem đánh giá</a>
				@endif
@endif
