<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin buổi học') }}</h2>
        </div>
        <div class="card-body row">
            <strong class="fs-3 mb-2">Thông tin cơ bản</strong>
            @if (auth('admin')->user()->isStudent)
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-user"></i> {{ __('Đánh giá của học viên') }}:</label>
                    <textarea class="form-control" name="student_review" rows="5" placeholder="Đánh giá của học viên">{{ $instance->student_review }}</textarea>
                </div>
            @else
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-note"></i> {{ __('Ghi chú buổi học') }}:</label>
                    <x-input name="note" :value="$instance->note" :placeholder="__('Ghi chú buổi học')" />
                </div>
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-file"></i> {{ __('Link chứa tài liệu') }}:</label>
                    <x-input name="file_link" :value="$instance->file_link" :placeholder="__('Link chứa tài liệu')" />
                </div>
                <div class="mb-3">
                    <label class="control-label"><i class="ti ti-user"></i>
                        {{ __('Đánh giá của giáo viên') }}:</label>
                    <textarea class="form-control" name="teacher_review" rows="5" placeholder="Đánh giá của giáo viên">{{ $instance->teacher_review }}</textarea>
                </div>
                @if (auth('admin')->user()->isSuperAdmin)
                    <div class="mb-3">
                        <label class="control-label"><i class="ti ti-user"></i>
                            {{ __('Đánh giá của học viên') }}:</label>
                        <textarea class="form-control" name="student_review" rows="5" placeholder="Đánh giá của học viên">{{ $instance->student_review }}</textarea>
                    </div>
                @endif
            @endif
            <strong class="fs-3 mb-2">Thông tin chi tiết</strong>
            <label class="control-label"><i class="ti ti-user"></i> {{ __('Học viên') }}:
                <strong class="text-black">{{ $instance->student->fullname }}</strong></label>
            <label class="control-label"><i class="ti ti-school"></i> {{ __('Giáo viên') }}:
                <strong class="text-black">{{ $instance->teacher_lesson->teacher->fullname }}</strong></label>
            <label class="control-label"><i class="ti ti-calendar"></i> {{ __('Ngày học') }}:
                <strong class="text-black">{{ format_date($instance->date, 'd-m-Y') }}</strong></label>
            <label class="control-label"><i class="ti ti-brand-skype"></i> {{ __('Link Jitsi') }}:
                {{-- <strong> --}}
                <a class="fw-bold btn btn-success"
                    href="{{ route('admin.student_lesson.jitsi', 'room_' . $instance->teacher_lesson->lesson_id) }}"
                    target="_blank">
                    Vào lớp học
                </a>
                {{-- </strong> --}}

            </label>
            <label class="control-label"><i class="ti ti-clock"></i> {{ __('Giờ học') }}:
                <strong class="text-black">{{ $instance->start_time }}</strong></label>
            <label class="control-label"><i class="ti ti-note"></i> {{ __('Ghi chú') }}:
                <strong class="text-black">{{ $instance->note }}</strong></label>
            <label class="control-label"><i class="ti ti-file"></i> {{ __('Đường dẫn tài liệu') }}:
                <strong class="text-black"><a target="_blank" href="{{ $instance->file_link }}">Bấm vào
                        đây</a></strong></label>
            <label class="control-label"><i class="ti ti-viewfinder"></i> {{ __('Đánh giá của học viên') }}:
                <strong class="text-black">{{ $instance->student_review }}</strong></label>
            <label class="control-label"><i class="ti ti-file-isr"></i> {{ __('Đánh giá của giáo viên') }}:
                <strong class="text-black">{{ $instance->teacher_review }}</strong></label>

            @if (auth()->user()->isTeacher)
                <label class="control-label"><i class="ti ti-star"></i>
                    {{ __('Khả năng tương tác và tham gia bài học') }}:
                    <div class="review_rating text-start">
                        <input type="radio" value="0" id="star-interaction-0" name="interaction"
                            ${instance.rating===0 ? 'checked' : '' } />
                        <label for="star-interaction-1">★</label>
                        <input type="radio" value="1" id="star-interaction-1" name="interaction"
                            ${instance.rating===1 ? 'checked' : '' } />
                        <label for="star-interaction-2">★</label>
                        <input type="radio" value="2" id="star-interaction-2" name="interaction"
                            ${instance.rating===2 ? 'checked' : '' } />
                        <label for="star-interaction-3">★</label>
                        <input type="radio" value="3" id="star-interaction-3" name="interaction"
                            ${instance.rating===3 ? 'checked' : '' } />
                        <label for="star-interaction-4">★</label>
                        <input type="radio" value="4" id="star-interaction-4" name="interaction"
                            ${instance.rating===4 ? 'checked' : '' } />
                        <label for="star-interaction-5">★</label>
                        <input type="radio" value="5" id="star-interaction-5" name="interaction"
                            ${instance.rating===5 ? 'checked' : '' } />
                    </div>
                    <strong class="text-black">{{ $instance->interaction }}</strong>
                </label>
                <label class="control-label"><i class="ti ti-star"></i> {{ __('Kỹ năng nghe') }}:
                    <div class="review_rating text-start">
                        <input type="radio" value="0" id="star-listening-0" name="listening"
                            ${instance.rating===0 ? 'checked' : '' } />
                        <label for="star-listening-1">★</label>
                        <input type="radio" value="1" id="star-listening-1" name="listening"
                            ${instance.rating===1 ? 'checked' : '' } />
                        <label for="star-listening-2">★</label>
                        <input type="radio" value="2" id="star-listening-2" name="listening"
                            ${instance.rating===2 ? 'checked' : '' } />
                        <label for="star-listening-3">★</label>
                        <input type="radio" value="3" id="star-listening-3" name="listening"
                            ${instance.rating===3 ? 'checked' : '' } />
                        <label for="star-listening-4">★</label>
                        <input type="radio" value="4" id="star-listening-4" name="listening"
                            ${instance.rating===4 ? 'checked' : '' } />
                        <label for="star-listening-5">★</label>
                        <input type="radio" value="5" id="star-listening-5" name="listening"
                            ${instance.rating===5 ? 'checked' : '' } />
                    </div>
                    <strong class="text-black">{{ $instance->listening }}</strong>
                </label>
                <label class="control-label"><i class="ti ti-star"></i> {{ __('Kỹ năng giao tiếp') }}:
                    <div class="review_rating text-start">
                        <input type="radio" value="0" id="star-communication-0" name="communication"
                            ${instance.rating===0 ? 'checked' : '' } />
                        <label for="star-communication-1">★</label>
                        <input type="radio" value="1" id="star-communication-1" name="communication"
                            ${instance.rating===1 ? 'checked' : '' } />
                        <label for="star-communication-2">★</label>
                        <input type="radio" value="2" id="star-communication-2" name="communication"
                            ${instance.rating===2 ? 'checked' : '' } />
                        <label for="star-communication-3">★</label>
                        <input type="radio" value="3" id="star-communication-3" name="communication"
                            ${instance.rating===3 ? 'checked' : '' } />
                        <label for="star-communication-4">★</label>
                        <input type="radio" value="4" id="star-communication-4" name="communication"
                            ${instance.rating===4 ? 'checked' : '' } />
                        <label for="star-communication-5">★</label>
                        <input type="radio" value="5" id="star-communication-5" name="communication"
                            ${instance.rating===5 ? 'checked' : '' } />
                    </div>
                    <strong class="text-black">{{ $instance->communication }}</strong>
                </label>
                <label class="control-label"><i class="ti ti-star"></i> {{ __('Khả năng phát âm và trôi chảy') }}:
                    <div class="review_rating text-start">
                        <input type="radio" value="0" id="star-pronunciation-0" name="pronunciation"
                            ${instance.rating===0 ? 'checked' : '' } />
                        <label for="star-pronunciation-1">★</label>
                        <input type="radio" value="1" id="star-pronunciation-1" name="pronunciation"
                            ${instance.rating===1 ? 'checked' : '' } />
                        <label for="star-pronunciation-2">★</label>
                        <input type="radio" value="2" id="star-pronunciation-2" name="pronunciation"
                            ${instance.rating===2 ? 'checked' : '' } />
                        <label for="star-pronunciation-3">★</label>
                        <input type="radio" value="3" id="star-pronunciation-3" name="pronunciation"
                            ${instance.rating===3 ? 'checked' : '' } />
                        <label for="star-pronunciation-4">★</label>
                        <input type="radio" value="4" id="star-pronunciation-4" name="pronunciation"
                            ${instance.rating===4 ? 'checked' : '' } />
                        <label for="star-pronunciation-5">★</label>
                        <input type="radio" value="5" id="star-pronunciation-5" name="pronunciation"
                            ${instance.rating===5 ? 'checked' : '' } />
                    </div>
                    <strong class="text-black">{{ $instance->pronunciation }}</strong>
                </label>
                <label class="control-label"><i class="ti ti-star"></i> {{ __('Từ vựng và ngữ pháp') }}:
                    <div class="review_rating text-start">
                        <input type="radio" value="0" id="star-vocab_grammar-0" name="vocab_grammar"
                            ${instance.rating===0 ? 'checked' : '' } />
                        <label for="star-vocab_grammar-1">★</label>
                        <input type="radio" value="1" id="star-vocab_grammar-1" name="vocab_grammar"
                            ${instance.rating===1 ? 'checked' : '' } />
                        <label for="star-vocab_grammar-2">★</label>
                        <input type="radio" value="2" id="star-vocab_grammar-2" name="vocab_grammar"
                            ${instance.rating===2 ? 'checked' : '' } />
                        <label for="star-vocab_grammar-3">★</label>
                        <input type="radio" value="3" id="star-vocab_grammar-3" name="vocab_grammar"
                            ${instance.rating===3 ? 'checked' : '' } />
                        <label for="star-vocab_grammar-4">★</label>
                        <input type="radio" value="4" id="star-vocab_grammar-4" name="vocab_grammar"
                            ${instance.rating===4 ? 'checked' : '' } />
                        <label for="star-vocab_grammar-5">★</label>
                        <input type="radio" value="5" id="star-vocab_grammar-5" name="vocab_grammar"
                            ${instance.rating===5 ? 'checked' : '' } />
                    </div>
                    <strong class="text-black">{{ $instance->vocab_grammar }}</strong>
                </label>
            @elseif (auth()->user()->isStudent)
                <label class="control-label"><i class="ti ti-star"></i> {{ __('Đánh giá sao của học viên') }}:
                    <div class="review_rating text-start">
                        <input type="radio" value="0" id="star-rating-0" name="rate" ${instance.rating===0
                            ? 'checked' : '' } />
                        <label for="star-rating-1">★</label>
                        <input type="radio" value="1" id="star-rating-1" name="rate" ${instance.rating===1
                            ? 'checked' : '' } />
                        <label for="star-rating-2">★</label>
                        <input type="radio" value="2" id="star-rating-2" name="rate" ${instance.rating===2
                            ? 'checked' : '' } />
                        <label for="star-rating-3">★</label>
                        <input type="radio" value="3" id="star-rating-3" name="rate" ${instance.rating===3
                            ? 'checked' : '' } />
                        <label for="star-rating-4">★</label>
                        <input type="radio" value="4" id="star-rating-4" name="rate" ${instance.rating===4
                            ? 'checked' : '' } />
                        <label for="star-rating-5">★</label>
                        <input type="radio" value="5" id="star-rating-5" name="rate" ${instance.rating===5
                            ? 'checked' : '' } />
                    </div>
                    <strong class="text-black">{{ $instance->rating }}</strong>
                </label>
            @endif
            @if (auth()->user()->isSuperAdmin)
                <p>Thời gian giáo viên vào lớp học: {{ $instance->teacherLesson->teacher_joined_at }}</p>
                <p>Thời gian học viên vào lớp học: {{ $instance->student_joined_at }}</p>
            @endif
        </div>
    </div>
</div>
