@extends('admin.layouts.master')

@push('custom-css')
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <x-form :action="route('admin.profile.update')" type="put" enctype="multipart/form-data" :validate="true">
                    <div class="card">
                        <section class="modal-profile-header position-relative d-flex ps-5 pt-5">
                            <div class="modal-cover-photo">
                                <div id="previewCover">
                                    <img id="myImg"
                                        src="{{ asset($auth->avatar ?? 'public/assets/images/default-avatar.png') }}"
                                        class="w-100" alt="">
                                </div>
                                <label for="coverInp">
                                    <div class="tool-edit-cover mt-3"><i class="ti ti-camera"></i></div>
                                </label>
                                <input accept="image/*" style="display: none" type='file' id="coverInp"
                                    name="avatar" />
                            </div>
                            <div class="align-items-center ms-5">
                                <h2 class="default-color-2 mt-4">{{ $auth->fullname }}</h2>
                                <h3 class="default-color">{{ $auth->roles[0]->title }}</h3>
                            </div>
                        </section>
                        @include('user.scripts.upload-image')
                        <div class="card-body row">
                            <div class="divider-100 justify-content-center mb-3"></div>
                            <div class="col-md-6 mb-3">
                                <label class="control-label"><i class="ti ti-user-edit"></i> {{ __('Họ và tên') }}:
                                </label>
                                <x-input name="fullname" :value="$auth->fullname" :required="true"
                                    placeholder="{{ __('Họ và tên') }}" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="control-label"><i class="ti ti-calendar"></i> {{ __('Ngày sinh') }}:
                                </label>
                                <x-input type="date" name="birthday" :value="format_date($auth->birthday ? $auth->birthday : '')" :required="true" />
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="control-label"><i class="ti ti-phone"></i> {{ __('Số điện thoại') }}:
                                </label>
                                <x-input-phone name="phone" :value="$auth->phone" :required="true" />
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="control-label"><i class="ti ti-gender-agender"></i> {{ __('Giới tính') }}:
                                </label>
                                <x-select name="gender" :required="true">
                                    <x-select-option value="" :title="__('Chọn Giới tính')" />
                                    @foreach ($gender as $key => $value)
                                        <x-select-option :option="$auth->gender" :value="$key" :title="__($value)" />
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="control-label"><i class="ti ti-location"></i>
                                    {{ __('Địa chỉ') }}:
                                </label>
                                <x-input name="address" :value="$auth->address" placeholder="{{ __('Địa chỉ') }}" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="control-label"><i class="ti ti-mail"></i> {{ __('Email') }}:
                                </label>
                                <x-input-email name="email" :value="$auth->email" :required="true" />
                            </div>
                            @if (auth('admin')->user()->isTeacher)
                                <div class="col-md-6 mb-3">
                                    <label class="control-label"><i class="ti ti-volume"></i> {{ __('Giọng nói') }}:
                                    </label>
                                    <x-input type="file" class="form-control" name="audio" accept="audio/*" />
                                    <audio class="w-100 my-2" controls>
                                        <source src="{{ asset($auth->audio) }}" type="audio/mp3">
                                        <source src="{{ asset($auth->audio) }}" type="audio/wav">
                                        Trình duyệt của bạn không hỗ trợ phát audio này
                                    </audio>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="control-label"><i class="ti ti-link"></i> {{ __('Đường dẫn video') }}:
                                    </label>
                                    <x-input name="link" :value="$auth->link" :required="true" />
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="control-label"><i class="ti ti-note"></i>
                                        {{ __('Ghi chú') }}:
                                    </label>
                                    <x-input readonly :value="$auth->note" />
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="card mb-3 custom-shadow">
                                        <div class="card-header">
                                            <span class="ti ti-photo me-1"></span>
                                            @lang('Hình ảnh cờ quốc gia')
                                        </div>
                                        <div class="card-body p-2">
                                            <x-input-image-ckfinder name="national_flag" :value="old('national_flag')"
                                                showImage="national_flag" :value="$auth->national_flag" />
                                        </div>
                                    </div>
                                </div>
                            @elseif(auth('admin')->user()->isStudent)
                                <div class="col-md-6 mb-3">
                                    <label class="control-label"><i class="ti ti-logout"></i>
                                        {{ __('Số lần xin nghỉ còn lại') }}:
                                    </label>
                                    <x-input disabled :value="$auth->remaining_leave_requests" />
                                </div>
                            @endif

                        </div>
                        <div class="btn-list justify-content-center mb-3">
                            <x-button.submit :title="__('Cập nhật')" />
                            <button type="button" onclick="location.href='{{ route('admin.password.index') }}'"
                                class="btn btn-primary"><i class="ti ti-key me-2"></i>Đổi mật
                                khẩu</button>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    @include('ckfinder::setup')
@endpush
