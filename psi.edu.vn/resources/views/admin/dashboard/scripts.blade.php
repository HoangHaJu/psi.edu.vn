<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        if (!calendarEl) return console.error("❌ Không tìm thấy #calendar trong DOM.");

        // Giả định: $lessons->items() là mảng các đối tượng bài học
        const lessons = {!! json_encode($lessons->items()) !!};

        const lessonDetailsSection = document.getElementById('lessonDetailsSection');
        const lessonDetailsContent = document.getElementById('lessonDetailsContent');

        const statusMap = {
            1: 'Chờ xác nhận',
            2: 'Đã xác nhận',
            3: 'Đã hoàn thành',
            4: 'Đã hủy'
        };

        function getBadgeColor(status) {
            switch (status) {
                case 1:
                    return 'warning';
                case 2:
                    return 'success';
                case 3:
                    return 'info';
                case 4:
                    return 'danger';
                default:
                    return 'secondary';
            }
        }

        // Dots cho month view
        const style = document.createElement('style');
        style.textContent = `
        .lesson-dots { display: flex; justify-content: center; gap: 3px; margin-top: 2px; }
        .lesson-dot { width: 7px; height: 7px; border-radius: 50%; }
        .lesson-dot.status-1 { background: orange; }
        .lesson-dot.status-2 { background: green; }
        .lesson-dot.status-3 { background: cyan; }
        .lesson-dot.status-4 { background: red; }
    `;
        document.head.appendChild(style);

        // Chuyển lessons thành events
        const events = lessons.map(lesson => ({
            id: lesson.id,
            title: lesson.course_name || '(Chưa có tên)',
            start: lesson.date + 'T' + (lesson.start_time || '00:00:00'),
            // Sử dụng các class màu của Bootstrap (sẽ được tùy chỉnh bởi CSS ở trên)
            className: [`bg-${getBadgeColor(lesson.status)}`],
            extendedProps: {
                status: lesson.status,
                courseName: lesson.course_name
            }
        }));

        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'vi',
            themeSystem: 'bootstrap5',
            height: 'auto',
            contentHeight: 'auto',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hôm nay',
                month: 'Tháng',
                week: 'Tuần',
                day: 'Ngày',
                list: 'Danh sách'
            },
            events: events,

            // 💡 CALLBACK MỚI: Tùy chỉnh giao diện sự kiện sau khi được tạo
            eventDidMount: function(info) {
                // Áp dụng cho chế độ xem timeGrid (Tuần/Ngày)
                if (info.view.type.startsWith('timeGrid')) {
                    const eventEl = info.el;
                    const eventTitleEl = eventEl.querySelector('.fc-event-title');

                    // Lấy giờ bắt đầu để chèn vào tiêu đề (nếu chưa có)
                    const lesson = lessons.find(l => l.id === parseInt(info.event.id));
                    const startTime = lesson.start_time ? moment(lesson.start_time, 'HH:mm:ss')
                        .format('HH:mm') : '';

                    if (eventTitleEl) {
                        // Cập nhật tiêu đề để hiển thị giờ bắt đầu
                        eventTitleEl.textContent =
                            `[${lesson.course_name || '(Chưa có tên)'}`;
                    }

                    // Tùy chỉnh màu nền và màu chữ đã được xử lý bằng className và CSS
                    // info.event.classNames.push(`bg-${getBadgeColor(lesson.status)}`);
                }
            },

            dayCellDidMount: function(info) {
                if (!info.el.classList.contains('fc-daygrid-day')) return;

                const cellDate = moment(info.date).format('YYYY-MM-DD');
                const lessonsOnDay = lessons.filter(l => moment(l.date).format('YYYY-MM-DD') ===
                    cellDate);

                if (lessonsOnDay.length > 0) {
                    const dotsContainer = document.createElement('div');
                    dotsContainer.classList.add('lesson-dots');
                    lessonsOnDay.forEach(lesson => {
                        const dot = document.createElement('span');
                        dot.classList.add('lesson-dot', `status-${lesson.status}`);
                        dotsContainer.appendChild(dot);
                    });
                    const topEl = info.el.querySelector('.fc-daygrid-day-top');
                    if (topEl) topEl.appendChild(dotsContainer);
                }
            },
            dateClick: function(info) {
                const clickedDate = moment(info.date).format('YYYY-MM-DD');
                const lessonsOnClickedDate = lessons.filter(l => moment(l.date).format(
                    'YYYY-MM-DD') === clickedDate);
                displayLessonsForDay(clickedDate, lessonsOnClickedDate);
            },
            eventClick: function(info) {
                // Lấy lesson theo id
                const lessonId = parseInt(info.event.id);
                const lessonClicked = lessons.filter(l => l.id === lessonId);
                if (lessonClicked.length > 0) {
                    const lessonDate = moment(lessonClicked[0].date).format('YYYY-MM-DD');
                    // Chỉ hiển thị lesson đang được click
                    displayLessonsForDay(lessonDate, lessonClicked);
                }
            }
        });

        calendar.render();

        function displayLessonsForDay(date, lessonsArray) {
            if (!lessonDetailsSection || !lessonDetailsContent) return;

            const formattedClickedDate = moment(date).format('DD/MM/YYYY');
            let html = `<h2>Các buổi học ngày ${formattedClickedDate}:</h2>`;

            if (!lessonsArray || lessonsArray.length === 0) {
                html += '<p>Không có buổi học nào vào ngày này.</p>';
            } else {
                html += '<div class="row row-cols-1 g-3">';
                lessonsArray.forEach(lesson => {
                    const formattedStartTime = lesson.start_time ? moment(lesson.start_time, 'HH:mm:ss')
                        .format('HH:mm') : '--:--';
                    html += `
                    <div class="col">
                        <div class="card card-body shadow-sm">
                            <h4>${lesson.course_name || '(Chưa có tên)'}</h4>
                            <p class="mb-1"><strong>Giờ bắt đầu:</strong> ${formattedStartTime}</p>
                            <p class="mb-1"><strong>Trạng thái:</strong> 
                                <span class="badge bg-${getBadgeColor(lesson.status)}">${statusMap[lesson.status] || 'Không xác định'}</span>
                            </p>
                            <a href="/student-lessons/sua/${lesson.id}" class="btn btn-link btn-sm p-0 text-start mt-2">Xem chi tiết</a>
                        </div>
                    </div>
                `;
                });
                html += '</div>';
            }

            lessonDetailsContent.innerHTML = html;
            lessonDetailsSection.style.display = 'block';
        }
    });
</script>
