@extends('admin.layouts.master')

@push('custom-css')

<link rel="stylesheet" href="{{ asset('admin/assets/css/dashboard.css') }}">

<style>
    .fc-event-title {
        white-space: normal !important;
        word-wrap: break-word;
    }
</style>
@endpush

@section('content')
    <div class="container p-4">
        <div class="row">
            @if (auth('admin')->user()->isStudent)
                @include('admin.dashboard.index-student')
            @elseif(auth('admin')->user()->isTeacher)
                @include('admin.dashboard.index-teacher')
            @else
                @include('admin.dashboard.index-default')
            @endif
        </div>
    </div>
@endsection

@push('custom-js')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    {{-- <script src='{{ asset('/public/libs/full-calendar/index.global.min.js') }}'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateTime() {
                const now = new Date();
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                document.getElementById('current-date').textContent = now.toLocaleDateString(undefined, options);
                document.getElementById('current-time').textContent = now.toLocaleTimeString();
                document.getElementById('timezone').textContent = Intl.DateTimeFormat().resolvedOptions().timeZone;
            }

            setInterval(updateTime, 1000);

            $('#datepicker').datepicker({
                showOtherMonths: false,
                selectOtherMonths: false,
            });

            updateTime();
        });
    </script> --}}
    @if (!auth('admin')->user()->isSuperAdmin)
        @include('admin.dashboard.scripts')
    @endif
@endpush
