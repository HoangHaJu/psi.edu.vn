<script>
				$(document).ready(function() {
								select2LoadData($('#admin_id').data('url'), '#admin_id');
								let selectedValue = null;
								$('.notification-type').change(function() {
												selectedValue = $(this).val();
												$('#notification-customer-select').hide();
												if (selectedValue == {{ \App\Enums\Notification\NotificationType::Customer }}) {
																$('#notification-customer-select').show();
																let url = "{{ route('admin.search.select.admin') }}";
																if ($('select[name="option"]').val() == 1) {
																				select2LoadData(url + `?role=teacher`, '#admin_id');
																} else {
																				select2LoadData(url + `?role=student`, '#admin_id');
																}
												}
								});

								$('.notification-option').change(function() {
												selectedValue = $(this).val();
												let url = "{{ route('admin.search.select.admin') }}";
												if (selectedValue == 1) {
																select2LoadData(url + `?role=teacher`, '#admin_id');
												} else {
																select2LoadData(url + `?role=student`, '#admin_id');
												}
								});
				});
</script>
