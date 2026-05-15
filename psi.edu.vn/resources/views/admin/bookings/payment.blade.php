@extends('admin.layouts.master')

@php
    $settingRepository = app()->make(App\Admin\Repositories\Setting\SettingRepository::class);
    $settings = $settingRepository->getAll();
@endphp

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card p-3 text-center">
                <div class="alert alert-info mt-3" role="alert">
                    <div class="align-items-center">
                        <strong>Lưu ý: Chuyển khoản trực tiếp cho chúng tôi thông qua các số tài khoản như bên dưới theo cú
                            pháp</strong><br>
                        <strong>"PSI#{{ $booking->id }}"</strong><br>
                        <strong>để chúng tôi có thể dễ dàng kiểm tra và
                            xác nhận cho bạn nhé!</strong><br>
                        <strong>SỐ TIỀN CẦN CHUYỂN: {{ format_price($booking->total) }}</strong>
                    </div>
                </div>
                {!! $settings->firstWhere('setting_key', 'payment_info')->plain_value !!}
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush
