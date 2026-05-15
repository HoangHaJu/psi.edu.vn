<script>
    window.AppConfig = {
        apiEndpoints: {
            courses: "{{ route('admin.booking.apiCourse') }}",
            teachers: "{{ route('admin.booking.apiTeacher') }}",
            students: "{{ route('admin.booking.apiStudent') }}",
            bookings: "{{ route('admin.booking.store') }}",
            categories: "{{ route('admin.booking.apiCategories') }}",
            levels: "{{ route('admin.booking.apiLevels') }}",
            lessons: "{{ route('admin.booking.apiLessons') }}",
            teacherAvailableTimes: "{{ route('admin.booking.apiTeacherAvailableTimes') }}"
        }
    };

    // Biến lưu trữ trạng thái toàn cục
    let currentPage = 1;
    let currentLimit = 10;
    let totalPages = 1;
    let coursesData = [];
    let filteredCourses = [];
    let allTeachers = [];
    let selectedCourse = null;
    let selectedDate = null;
    let selectedTeachers = [];
    let selectedTimeSlots = [];
    let allFetchedTeachers = [];
    let bookingsData;
    let teacherSearchList = [];
    let timeSlotsToRegister = [];
    let allFetchedStudents = [];
    let dataRegisterModal = {
        course: null,
        date: null,
        timeSlots: [],
        teachers: [],
        studentId: null,
    };
    const studentSearchInput = document.getElementById('offcanvasStudentSearchInput');
    const studentSearchList = document.getElementById('offcanvasStudentSearchList');
    // Hàm render dropdown cho học viên
    const fetchAndDisplayStudents = async (searchTerm = '') => {
        try {
            const apiUrl = window.AppConfig.apiEndpoints.students;
            const queryParams = searchTerm ? `?search=${encodeURIComponent(searchTerm)}` : '';
            const response = await fetch(`${apiUrl}${queryParams}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            });

            if (!response.ok) {
                const errorData = await response.json();
                console.error('Lỗi khi lấy danh sách học viên:', errorData);
                allFetchedStudents = []; // Xóa danh sách nếu có lỗi
                renderStudentDropdown([], true); // Hiển thị thông báo lỗi/không tìm thấy
                return;
            }

            const students = await response.json();
            allFetchedStudents = Array.isArray(students) ? students : []; // Đảm bảo là mảng

            // Render dropdown với tất cả học viên đã tải, nhưng không hiển thị dropdown ngay
            // Chỉ hiển thị khi người dùng gõ hoặc focus
            renderStudentDropdown(allFetchedStudents, false);

            // Nếu có student_id đã chọn trước đó, set giá trị cho input
            if (currentFilters.student_id) {
                const selectedStudent = allFetchedStudents.find(s => String(s.id) === String(currentFilters
                    .student_id));
                if (selectedStudent) {
                    studentSearchInput.value = `${selectedStudent.fullname}`;
                    dataRegisterModal.studentId = selectedStudent.id;
                    dataRegisterModal.studentName = selectedStudent.fullname;
                } else {
                    studentSearchInput.value = ''; // Xóa nếu không tìm thấy học viên cũ
                    dataRegisterModal.studentId = null;
                    dataRegisterModal.studentName = null;
                    currentFilters.student_id = null;
                }
            }

        } catch (error) {
            console.error('Lỗi kết nối API khi lấy học viên:', error);
            allFetchedStudents = [];
            renderStudentDropdown([], true); // Hiển thị thông báo lỗi
        }
    };

    if (studentSearchInput && studentSearchList) {

        function renderStudentDropdown(students, showDropdown = false) {
            studentSearchList.innerHTML = '';
            studentSearchList.style.display = 'none'; // Mặc định ẩn
            if (students.length === 0 && showDropdown) {
                const li = document.createElement('li');
                li.textContent = 'Không tìm thấy học viên nào.';
                li.classList.add('dropdown-item');
                li.style.cursor = 'default';
                studentSearchList.appendChild(li);
                studentSearchList.style.display = 'block';
                return;
            }

            students.forEach(student => {
                const li = document.createElement('li');
                li.textContent = `${student.fullname}`;
                li.setAttribute('data-id', student.id);
                li.classList.add('dropdown-item');
                li.style.cursor = 'pointer';
                li.addEventListener('click', () => {
                    studentSearchInput.value = `${student.fullname}`;
                    studentSearchList.style.display = 'none'; // Ẩn khi chọn xong
                    dataRegisterModal.studentId = student.id; // Lưu studentId vào dataRegisterModal
                    dataRegisterModal.studentName = student.fullname; // Lưu studentName
                    currentFilters.student_id = student.id; // Cập nhật currentFilters
                });
                studentSearchList.appendChild(li);
            });

            if (showDropdown && students.length > 0) { // Chỉ hiển thị nếu có kết quả và showDropdown là true
                studentSearchList.style.display = 'block';
            } else {
                studentSearchList.style.display = 'none';
            }
        }

        // Hàm fetch học viên từ API

        // Event listener cho input tìm kiếm học viên
        studentSearchInput.addEventListener('input', () => {
            const keyword = studentSearchInput.value.toLowerCase();
            const filtered = allFetchedStudents.filter(s =>
                s.fullname.toLowerCase().includes(keyword) ||
                s.email.toLowerCase().includes(keyword)
            );
            renderStudentDropdown(filtered, true); // Luôn hiển thị khi gõ
        });

        // Event listener khi focus vào input học viên
        studentSearchInput.addEventListener('focus', () => {
            const keyword = studentSearchInput.value.toLowerCase();
            const filtered = allFetchedStudents.filter(s =>
                s.fullname.toLowerCase().includes(keyword) ||
                s.email.toLowerCase().includes(keyword)
            );
            renderStudentDropdown(filtered, true); // Hiển thị danh sách khi focus
        });

        // Ẩn dropdown học viên khi click ra ngoài
        document.addEventListener('click', (e) => {
            // Kiểm tra nếu click không phải vào input hoặc dropdown list của student
            if (!e.target.closest('.custom-select-wrapper') || !e.target.closest(
                    '#offcanvasStudentSearchInput')) {
                if (!e.target.closest('#offcanvasStudentSearchList')) {
                    studentSearchList.style.display = 'none';
                }
            }
        });
    }
    // Bộ hàm xử lý modal
    // Mở modal theo ID
    function openModal(id, options = {}) {
        const el = document.getElementById(id);
        return bootstrap.Modal.getOrCreateInstance(el, options);
    }

    // Đóng modal theo ID
    function closeModal(id) {
        const el = document.getElementById(id);
        const instance = bootstrap.Modal.getInstance(el);
        if (instance) instance.hide();
    }

    // Đóng tất cả modal và backdrop
    function closeAllModals() {
        document.querySelectorAll('.modal.show').forEach(modalEl => {
            bootstrap.Modal.getInstance(modalEl)?.hide();
        });
    }
    // Chuyển từ modal này sang modal khác một cách mượt
    function switchModal(fromId, toId, toOptions = {}) {
        const fromEl = document.getElementById(fromId);
        const toEl = document.getElementById(toId);
        const fromModal = bootstrap.Modal.getInstance(fromEl);
        const toModal = bootstrap.Modal.getOrCreateInstance(toEl, toOptions);

        if (!fromModal) return toModal.show();
        fromModal.hide();
        fromEl.addEventListener('hidden.bs.modal', function handler() {
            toModal.show();
            fromEl.removeEventListener('hidden.bs.modal', handler);
        });
    }


    // Các bộ lọc hiện tại
    let currentFilters = {
        search: '',
        category_ids: [],
        levels: [],
        genders: [],
        ratings: [],
        date: '',
        teacher_id: null,
        lessons: []
    };

    // --- Helper Functions ---

    /**
     * Hiển thị Toast thông báo thành công.
     * @param {string} message - Nội dung thông báo.
     */
    function showSuccessToast(message) {
        const successToastEl = document.getElementById('successToast');
        const bsToast = new bootstrap.Toast(successToastEl);
        const toastBody = successToastEl.querySelector('.toast-body');
        if (toastBody) {
            toastBody.textContent = message;
        }
        bsToast.show();
    }

    function showErrorToast(message) {
        const errorToastEl = document.getElementById('errorToast');
        const bsToast = new bootstrap.Toast(errorToastEl);
        const toastBody = errorToastEl.querySelector('.toast-body');
        if (toastBody) {
            toastBody.textContent = message;
        }
        bsToast.show();
    }

    function getTeacherNameById(teacherId) {
        const teacher = allFetchedTeachers.find(t => String(t.id) === String(teacherId));
        return teacher ? teacher.fullname : 'Tất cả giáo viên';
    }
    /**
     * Tạo một thẻ "tag" cho bộ lọc.
     * @param {string} text - Văn bản hiển thị trên thẻ.
     * @param {string} value - Giá trị của thẻ (ID, tên, etc.).
     * @param {string} type - Loại bộ lọc (category, level, gender, rating).
     * @returns {HTMLElement} - Phần tử span của thẻ.
     */
    function createFilterTag(text, value, type) {
        const tag = document.createElement('span');
        tag.dataset.value = value;
        tag.dataset.type = type;
        return tag;
    }

    /**
     * Thêm một bộ lọc vào giao diện và cập nhật trạng thái.
     * @param {string} text - Văn bản hiển thị.
     * @param {string} value - Giá trị bộ lọc.
     * @param {string} type - Loại bộ lọc.
     * @param {HTMLElement} container - Container để thêm thẻ vào.
     */
    function addFilterTag(text, value, type, container) {
        if (type === 'category' && currentFilters.category_ids.includes(value)) return;
        if (type === 'level' && currentFilters.levels.includes(value)) return;
        if (type === 'gender' && currentFilters.genders.includes(value)) return;
        if (type === 'rating' && currentFilters.ratings.includes(value)) return;

        if (type === 'category') currentFilters.category_ids.push(value);
        else if (type === 'level') currentFilters.levels.push(value);
        else if (type === 'gender') currentFilters.genders.push(value);
        else if (type === 'rating') currentFilters.ratings.push(value);

        container.appendChild(createFilterTag(text, value, type));
    }

    /**
     * Xóa một bộ lọc khỏi giao diện và cập nhật trạng thái.
     * @param {string} value - Giá trị của bộ lọc cần xóa.
     * @param {string} type - Loại bộ lọc.
     */
    function removeFilter(value, type) {
        const containerId = `${type}FilterTags`;
        const container = document.getElementById(containerId);

        // ✅ Tìm và remove tag khỏi UI
        let tagToRemove = null;
        if (container) {
            tagToRemove = container.querySelector(`[data-value="${value}"][data-type="${type}"]`);
            if (tagToRemove) {
                tagToRemove.remove();
            }
        }

        // ✅ Cập nhật currentFilters dựa trên type
        let shouldApplyFilters = false;

        switch (type) {
            case 'category':
                if (currentFilters.category_ids) {
                    currentFilters.category_ids = currentFilters.category_ids.filter(id => id !== value);
                    shouldApplyFilters = true;
                }
                break;

            case 'level':
                if (currentFilters.levels) {
                    currentFilters.levels = currentFilters.levels.filter(lvl => lvl !== value);
                    shouldApplyFilters = true;
                }
                break;

            case 'gender':
                if (currentFilters.genders) {
                    currentFilters.genders = currentFilters.genders.filter(gen => gen !== value);
                    shouldApplyFilters = true;
                }
                break;

            case 'rating':
                if (currentFilters.ratings) {
                    currentFilters.ratings = currentFilters.ratings.filter(rate => rate !== value);
                    shouldApplyFilters = true;
                }
                break;

            case 'teacher':
                // ✅ Reset teacher related filters
                currentFilters.teacher_id = null;
                if (currentFilters.lessons) {
                    currentFilters.lessons = [];
                }

                // ✅ Reset UI elements
                const teacherSearchInput = document.getElementById('offcanvasTeacherSearchInput');
                if (teacherSearchInput) {
                    teacherSearchInput.value = '';
                }

                // ✅ Clear lesson tags và reset modal data
                const lessonContainer = document.getElementById('lessonFilterTags');
                if (lessonContainer) {
                    lessonContainer.innerHTML = '<p>Vui lòng chọn Giáo viên.</p>';
                }

                // ✅ Reset dataRegisterModal
                if (typeof dataRegisterModal !== 'undefined') {
                    dataRegisterModal.teachers = [];
                    dataRegisterModal.timeSlots = [];
                }

                shouldApplyFilters = true;
                break;

            case 'lesson':
                // ✅ Remove lesson khỏi filters
                if (currentFilters.lessons) {
                    currentFilters.lessons = currentFilters.lessons.filter(lessonId => lessonId !== value);
                }

                // ✅ Remove khỏi dataRegisterModal.timeSlots
                if (typeof dataRegisterModal !== 'undefined' && dataRegisterModal.timeSlots) {
                    dataRegisterModal.timeSlots = dataRegisterModal.timeSlots.filter(
                        slot => String(slot.lesson.teacher_lesson_id) !== String(value)
                    );
                }

                // ✅ Remove active class khỏi lesson button
                const lessonButton = document.querySelector(`button[data-lesson-id="${value}"]`);
                if (lessonButton) {
                    lessonButton.classList.remove('active');
                }

                shouldApplyFilters = true;
                break;

            case 'date':
                // ✅ Reset date filter
                currentFilters.date = null;

                // ✅ Reset date input
                const dateInput = document.getElementById('filterDate');
                if (dateInput) {
                    dateInput.value = '';
                }

                // ✅ Reset related data
                if (typeof dataRegisterModal !== 'undefined') {
                    dataRegisterModal.date = null;
                }

                // ✅ Có thể cần reset teacher/lesson vì date ảnh hưởng đến available teachers
                currentFilters.teacher_id = null;
                currentFilters.lessons = [];

                const teacherInput = document.getElementById('offcanvasTeacherSearchInput');
                if (teacherInput) {
                    teacherInput.value = '';
                }

                const lessonTags = document.getElementById('lessonFilterTags');
                if (lessonTags) {
                    lessonTags.innerHTML = '<p>Vui lòng chọn Giáo viên.</p>';
                }

                if (typeof dataRegisterModal !== 'undefined') {
                    dataRegisterModal.teachers = [];
                    dataRegisterModal.timeSlots = [];
                }

                shouldApplyFilters = true;
                break;

            default:
                console.warn(`Unknown filter type: ${type}`);
                return;
        }

        // ✅ Chỉ apply filters nếu thực sự có thay đổi
        if (shouldApplyFilters) {
            // ✅ Đối với teacher/lesson/date, có thể cần logic khác thay vì applyFiltersAndFetchCourses
            if (type === 'teacher' || type === 'lesson' || type === 'date') {

                if (typeof handleFilterChange === 'function') {
                    handleFilterChange();
                } else {
                    // ✅ Fallback: refresh data nếu cần
                    console.log('Filter removed, data refreshed');
                }
            } else {
                // ✅ Các filter khác dùng logic cũ
                if (typeof applyFiltersAndFetchCourses === 'function') {
                    applyFiltersAndFetchCourses();
                }
            }
        }
    }

    // ✅ Helper function để remove multiple filters cùng lúc
    function removeMultipleFilters(filters) {
        // filters = [{value: 'value1', type: 'type1'}, {value: 'value2', type: 'type2'}]
        let shouldApplyFilters = false;

        filters.forEach(({
            value,
            type
        }) => {
            const containerId = `${type}FilterTags`;
            const container = document.getElementById(containerId);

            if (container) {
                const tagToRemove = container.querySelector(`[data-value="${value}"][data-type="${type}"]`);
                if (tagToRemove) {
                    tagToRemove.remove();
                }
            }

            // Update filters without calling applyFiltersAndFetchCourses each time
            switch (type) {
                case 'category':
                    if (currentFilters.category_ids) {
                        currentFilters.category_ids = currentFilters.category_ids.filter(id => id !== value);
                        shouldApplyFilters = true;
                    }
                    break;
                case 'level':
                    if (currentFilters.levels) {
                        currentFilters.levels = currentFilters.levels.filter(lvl => lvl !== value);
                        shouldApplyFilters = true;
                    }
                    break;
                    // Add other cases as needed
            }
        });

        // Apply filters once at the end
        if (shouldApplyFilters && typeof applyFiltersAndFetchCourses === 'function') {
            applyFiltersAndFetchCourses();
        }
    }

    // ✅ Helper function để clear all filters
    function clearAllFilters() {
        // Clear UI tags
        ['category', 'level', 'gender', 'rating', 'teacher', 'lesson', 'date'].forEach(type => {
            const container = document.getElementById(`${type}FilterTags`);
            if (container) {
                container.innerHTML = '';
            }
        });

        // Reset currentFilters
        currentFilters.category_ids = [];
        currentFilters.levels = [];
        currentFilters.genders = [];
        currentFilters.ratings = [];
        currentFilters.teacher_id = null;
        currentFilters.lessons = [];
        currentFilters.date = null;

        // Reset UI inputs
        const teacherInput = document.getElementById('offcanvasTeacherSearchInput');
        if (teacherInput) teacherInput.value = '';

        const dateInput = document.getElementById('filterDate');
        if (dateInput) dateInput.value = '';

        // Reset modal data
        if (typeof dataRegisterModal !== 'undefined') {
            dataRegisterModal.teachers = [];
            dataRegisterModal.timeSlots = [];
            dataRegisterModal.date = null;
        }

        // Apply changes
        if (typeof applyFiltersAndFetchCourses === 'function') {
            applyFiltersAndFetchCourses();
        }
    }
    /**
     * Xóa tất cả bộ lọc và đặt lại trạng thái.
     */
    function clearAllFilters() {
        // Clear UI tags
        ['category', 'level', 'gender', 'rating', 'teacher', 'lesson', 'date'].forEach(type => {
            const container = document.getElementById(`${type}FilterTags`);
            if (container) {
                container.innerHTML = '';
            }
        });

        // Reset currentFilters
        currentFilters.category_ids = [];
        currentFilters.levels = [];
        currentFilters.genders = [];
        currentFilters.ratings = [];
        currentFilters.teacher_id = null;
        currentFilters.lessons = [];
        currentFilters.date = null;

        // Reset UI inputs
        const teacherInput = document.getElementById('offcanvasTeacherSearchInput');
        if (teacherInput) teacherInput.value = '';

        const dateInput = document.getElementById('filterDate');
        if (dateInput) dateInput.value = '';

        // Reset modal data
        if (typeof dataRegisterModal !== 'undefined') {
            dataRegisterModal.teachers = [];
            dataRegisterModal.timeSlots = [];
            dataRegisterModal.date = null;
        }

        // Apply changes
        if (typeof applyFiltersAndFetchCourses === 'function') {
            applyFiltersAndFetchCourses();
        }
    }

    /**
     * Lấy các tham số truy vấn từ đối tượng bộ lọc.
     * @param {object} filters - Đối tượng chứa các bộ lọc.
     * @returns {string} - Chuỗi query parameters.
     */

    function getQueryParams(filters) {
        const params = new URLSearchParams();

        // --- Search ---
        if (filters.search && filters.search.trim() !== '') {
            params.append('search', filters.search.trim());
        }

        // --- Categories ---
        if (Array.isArray(filters.category_ids) && filters.category_ids.length > 0) {
            filters.category_ids.forEach(id => {
                if (id != null && id !== '') params.append('categories[]', id);
            });
        }

        // --- Levels ---
        if (Array.isArray(filters.levels) && filters.levels.length > 0) {
            filters.levels.forEach(level => {
                if (level != null && level !== '') params.append('levels[]', level);
            });
        }

        // --- Genders ---
        if (Array.isArray(filters.genders) && filters.genders.length > 0) {
            filters.genders.forEach(g => {
                if (g != null && g !== '') params.append('teacherGender[]', g);
            });
        }

        // --- Ratings ---
        if (Array.isArray(filters.ratings) && filters.ratings.length > 0) {
            filters.ratings.forEach(r => {
                if (r != null && r !== '') params.append('teacherRating[]', r);
            });
        }

        // --- Date ---
        if (filters.date) {
            params.append('date', filters.date);
        }

        // --- Teacher ID (cho phép 0 hoặc "0") ---
        if (filters.teacher_id !== undefined && filters.teacher_id !== null) {
            params.append('teacher_id', filters.teacher_id);
        }

        // --- Lessons ---
        if (Array.isArray(dataRegisterModal.timeSlots) && dataRegisterModal.timeSlots.length > 0) {
            const lessonIds = dataRegisterModal.timeSlots
                .map(ts => ts.teacher_lesson_id)
                .filter(id => id != null && id !== '')
                .join(',');
            if (lessonIds) {
                params.append('lessonId', lessonIds);
            }
        }

        // --- Pagination ---
        if (typeof currentLimit !== 'undefined') {
            params.append('limit', currentLimit);
        }
        if (typeof currentPage !== 'undefined') {
            params.append('page', currentPage);
        }

        const queryString = params.toString();

        return queryString;
    }



    // --- Fetch Data Functions ---

    /**
     * Lấy danh sách khóa học từ API.
     * @param {boolean} applyExistingFilters - Có áp dụng các bộ lọc hiện tại hay không.
     */

    async function fetchCourses() {
        try {
            const response = await fetch(
                `${window.AppConfig.apiEndpoints.courses}?${getQueryParams(currentFilters)}`);
            const data = await response.json();
            coursesData = data.data || [];
            totalPages = data.last_page || 1;
            renderCourses(coursesData);
            renderPagination();
        } catch (error) {
            console.error('Error fetching courses:', error);
            document.getElementById('courseListContainer').innerHTML =
                '<p class="text-center text-danger">Không thể tải khóa học. Vui lòng thử lại sau.</p>';
        }
    }

    async function fetchTeachers(date, courseId, teacherFilters = {}) {
        let queryParams = `date=${date}`;

        // Thêm courseId vào queryParams
        if (courseId) {
            queryParams += `&course_id=${courseId}`;
        }

        if (teacherFilters.search) {
            queryParams += `&search=${teacherFilters.search}`;
        }
        if (teacherFilters.gender) {
            queryParams += `&gender=${teacherFilters.gender}`;
        }
        if (teacherFilters.rating) {
            queryParams += `&rating=${teacherFilters.rating}`;
        }

        try {
            const response = await fetch(`${window.AppConfig.apiEndpoints.teachers}?${queryParams}`);

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP error! status: ${response.status}. Message: ${errorText}`);
            }
            const data = await response.json();

            // Đảm bảo allTeachers luôn là một mảng
            allTeachers = Array.isArray(data.data) ? data.data : (Array.isArray(data) ? data : []);

            // Giả định renderTeacherList là hàm hiển thị danh sách giáo viên
            renderTeacherList(allTeachers);
        } catch (error) {
            console.error('Error fetching teachers:', error);
            document.getElementById('teacherListContainer').innerHTML =
                '<p class="text-center text-danger">Không thể tải giáo viên. Vui lòng thử lại sau.</p>';
            document.getElementById('teacherConfirmSelectionButton').disabled = true;
            document.getElementById('teacherConfirmSelectionButton').textContent = 'Xác nhận chọn (0)';
        }
    }

    /**
     * Lấy các khung giờ có sẵn của giáo viên từ API.
     * @param {number} teacherId - ID của giáo viên.
     * @param {string} date - Ngày để lấy khung giờ.
     * @returns {Promise<Array>} - Mảng các khung giờ.
     */
    async function fetchTeacherAvailableTimes(params = {}) {
        // Build query string từ object params
        const queryString = Object.entries(params)
            .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
            .join('&');

        const apiUrl = queryString ?
            `${window.AppConfig.apiEndpoints.teacherAvailableTimes}?${queryString}` :
            window.AppConfig.apiEndpoints.teacherAvailableTimes;
        console.log(apiUrl);

        try {
            const response = await fetch(apiUrl);
            if (!response.ok) return [];

            const data = await response.json();
            // console.log(data);

            const slots = data?.data?.data ?? data?.data ?? [];

            return slots.map(slot => ({
                id: slot.id,
                start_time: slot.start_time,
                teacher_lesson_id: slot.teacher_lesson_id,
                course_id: slot.course_id,
                date: slot.date
            }));
        } catch (err) {
            console.error('Error fetching available times:', err);
            return [];
        }
    }


    /**
     * Lấy danh sách danh mục từ API.
     */
    async function fetchCategories() {
        try {
            const response = await fetch(window.AppConfig.apiEndpoints.categories);

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Failed to fetch categories. Status: ${response.status}. Message: ${errorText}`);
            }

            const data = await response.json();
            const categoryFilterTags = document.getElementById('categoryFilterTags');

            categoryFilterTags.innerHTML = '';

            data.forEach(category => {
                const div = document.createElement('div'); // Use a div as the container
                div.className = 'form-check form-check-inline p-0'; // Apply Bootstrap classes
                div.innerHTML = `
                <input class="form-check-input filter-checkbox" type="checkbox" id="category-${category.id}" data-type="category" value="${category.id}">
                <label class="form-check-label" for="category-${category.id}">${category.name}</label>
            `;
                categoryFilterTags.appendChild(div);
            });

            addFilterCheckboxListeners();
        } catch (error) {
            console.error('Error fetching categories:', error);
        }
    }

    /**
     * Lấy danh sách cấp độ từ API.
     */
    async function fetchLevels() {
        try {
            const response = await fetch(window.AppConfig.apiEndpoints.levels);

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Failed to fetch levels. Status: ${response.status}. Message: ${errorText}`);
            }

            const data = await response.json();
            const levelFilterTags = document.getElementById('levelFilterTags');

            levelFilterTags.innerHTML = '';

            data.forEach(level => {
                const div = document.createElement('div'); // Use a div as the container
                div.className = 'form-check form-check-inline p-0'; // Apply Bootstrap classes
                div.innerHTML = `
                <input class="form-check-input filter-checkbox" type="checkbox" id="level-${level}" data-type="level" value="${level}">
                <label class="form-check-label" for="level-${level}">${level}</label>
            `;
                levelFilterTags.appendChild(div);
            });

            addFilterCheckboxListeners();
        } catch (error) {
            console.error('Error fetching levels:', error);
        }
    }

    // --- Render Functions ---

    /**
     * Hiển thị danh sách khóa học lên giao diện.
     * @param {Array} courses - Mảng các đối tượng khóa học.
     */
    function renderCourses(courses) {
        const container = document.getElementById('courseListContainer');
        container.innerHTML = '';

        if (!Array.isArray(courses) || courses.length === 0) {
            container.innerHTML = '<p class="text-center w-100">Không tìm thấy khóa học nào.</p>';
            return;
        }

        courses.forEach(course => {
            container.insertAdjacentHTML('beforeend', `
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden course-card-booking"
                        data-course-id="${course.id}"
                        data-course-title="${course.name}"
                        data-course-category="${course.categories?.map(c => c.name).join(', ') || 'N/A'}"
                        data-course-level="${course.education_level || 'N/A'}">

                        <div class="course-card-image p-3 d-flex align-items-center justify-content-center bg-light">
                        ${course.avatar
                            ? `<img src="${course.avatar}" class="img-fluid rounded" alt="Course Image">`
                            : `<i class="fas fa-book-open fa-4x text-muted"></i>`}
                        </div>

                        <div class="card-body d-flex flex-column px-2">
                        <h5 class="card-title pb-2 text-primary fw-bold mb-2">${course.name}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            ${course.education_level ? `<span class="badge bg-info text-white text-uppercase me-1 py-1 px-2">Cấp độ ${course.education_level}</span>` : ''}
                            ${course.categories?.length
                                ? `<span class="badge bg-secondary text-white text-uppercase py-1 px-2">Danh mục ${course.categories.map(cat => cat.name).join(', ')}</span>`
                                : ''}
                        </h6>
                        ${course.description || 'Không có mô tả chi tiết cho khóa học này.'}
                        </div>

                        <div class="card-footer bg-white border-top-0 pt-0">
                        <button class="btn btn-primary-booking btn-lg w-100 register-course-btn" data-course-id="${course.id}">
                            <i class="fas fa-sign-in-alt me-2"></i> Đăng ký ngay
                        </button>
                        </div>
                    </div>
                    </div>
                `);
        });
        // Setup register button logic
        addRegisterButtonListeners();
    }

    /**
     * Hiển thị phân trang.
     */
    function renderPagination() {
        const paginationUl = document.getElementById('coursePagination');
        paginationUl.innerHTML = '';

        if (totalPages <= 1) return;

        // Previous button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Trước</a>`;
        paginationUl.appendChild(prevLi);

        // Page numbers
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);

        if (endPage - startPage < 4) { // Đảm bảo có ít nhất 5 trang hiển thị nếu có thể
            if (startPage === 1) {
                endPage = Math.min(totalPages, startPage + 4);
            } else if (endPage === totalPages) {
                startPage = Math.max(1, endPage - 4);
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === currentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
            paginationUl.appendChild(li);
        }

        // Next button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Tiếp</a>`;
        paginationUl.appendChild(nextLi);

        // Add event listeners for pagination links
        paginationUl.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const newPage = parseInt(e.target.dataset.page);
                if (newPage > 0 && newPage <= totalPages && newPage !== currentPage) {
                    currentPage = newPage;
                    fetchCourses(true); // Sử dụng bộ lọc khi chuyển trang
                }
            });
        });
    }

    /**
     * Hiển thị danh sách các ngày trong 7 ngày gần nhất.
     */
    function renderDateCards() {
        const container = document.getElementById('dateCardsContainer');
        container.innerHTML = '';
        const today = new Date();
        let initialSelectedDate = currentFilters.date || null;

        const calendarIcon = `
<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
    `;

        for (let i = 0; i < 7; i++) {
            const date = new Date(today);
            date.setDate(today.getDate() + i);
            const fullDate =
                `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;

            const isActive = (initialSelectedDate && initialSelectedDate === fullDate) ? 'active' : '';

            container.insertAdjacentHTML('beforeend', `
            <div class="col-md-4 mb-3 justify-content-center">
                <div class="card date-card ${isActive}" data-date="${fullDate}">
                    <div class="card-body text-center" style="display: flex
;
    position: relative;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;">
                          ${calendarIcon}
                        <h5 class="card-title m-0">${new Intl.DateTimeFormat('vi-VN', { weekday: 'long' }).format(date)}</h5>
                        <p class="card-text">
                           ${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}
                        </p>
                    </div>
                </div>
            </div>
        `);
        }

        const btn = document.getElementById('confirmDateAndShowTeacherModal');
        if (!initialSelectedDate) {
            btn.disabled = true;
        } else {
            btn.disabled = false;
            selectedDate = initialSelectedDate;
        }

        container.querySelectorAll('.date-card').forEach(card => {
            card.addEventListener('click', () => {
                container.querySelectorAll('.date-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');
                selectedDate = card.dataset.date;
                btn.disabled = false;
            });
        });
    }

    /**
     * Hiển thị danh sách giáo viên trong modal.
     * @param {Array} teachers - Mảng các đối tượng giáo viên.
     */

    async function fetchAllTeachers() {
        try {
            const response = await fetch(window.AppConfig.apiEndpoints.teachers); // Đảm bảo URL này đúng
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            allTeachers = Array.isArray(data) ? data : data.data; // Cập nhật biến allTeachers toàn cục
            renderTeacherList(allTeachers); // Render danh sách ban đầu
        } catch (error) {
            console.error("Lỗi khi tìm nạp giáo viên:", error);
            document.getElementById('teacherListContainer').innerHTML =
                '<p class="text-center w-100 text-danger">Không thể tải danh sách giáo viên.</p>';
        }
    }


    function filterTeachersInModal() {
        const searchText = document.getElementById('teacherSearchInput').value.toLowerCase();
        const genderFilterElement = document.getElementById('teacherGenderFilter');
        const genderFilter = genderFilterElement ? genderFilterElement.value : '';
        const ratingFilterElement = document.getElementById('teacherRatingFilter');
        const ratingFilter = ratingFilterElement ? parseInt(ratingFilterElement.value) : NaN;

        const filtered = allTeachers.filter(teacher => {
            const matchesName = teacher.fullname.toLowerCase().includes(searchText);
            const matchesGender = genderFilter === '' || (teacher.gender !== undefined && String(teacher
                .gender) === genderFilter);
            const teacherRating = parseFloat(teacher.rateForStudent) || 0;

            const matchesRating = isNaN(ratingFilter) || teacherRating >= ratingFilter;

            return matchesName && matchesGender && matchesRating;
        });
        renderTeacherList(filtered);
    }

    // Hàm chuyển đổi modal
    document.getElementById('teacherConfirmSelectionButton').addEventListener('click', async () => {
        if (selectedTeachers.length === 0) {
            return alert('Vui lòng chọn ít nhất một giáo viên.');
        }
        // selectedDate là biến toàn cục từ hàm renderDateCards
        if (!selectedDate) {
            return alert('Vui lòng chọn ngày học trước.');
        }

        await switchModal('teacherSelectionModal', 'timeSelectionModal');
        // Lấy và render khung giờ
        const firstSelectedTeacher = selectedTeachers[0];

        const slots = await fetchTeacherAvailableTimes({
            teacher_id: firstSelectedTeacher.id,
            date: selectedDate,
            course_id: selectedCourse?.id || null
        });

        renderTimeSlots(slots, firstSelectedTeacher.id); // Truyền teacherId vào renderTimeSlots nếu cần
    });


    function renderTeacherList(teachers) {
        const container = document.getElementById('teacherListContainer');
        container.innerHTML = '';

        if (teachers.length === 0) {
            container.innerHTML = '<p class="text-center w-100">Không tìm thấy giáo viên nào phù hợp.</p>';
            updateTeacherConfirmButton(); // Cập nhật nút ngay cả khi không có giáo viên
            return;
        }

        teachers.forEach(teacher => {
            // Sử dụng teacher.average_rating hoặc teacher.rateForStudent một cách nhất quán
            const rating = Math.max(0, Math.min(5, Math.floor(parseFloat(teacher.average_rating ||
                0)))); // Đảm bảo là số

            const filledStars = Array(rating).fill('<i class="fas fa-star"></i>').join('');
            const emptyStars = Array(5 - rating).fill('<i class="far fa-star"></i>').join('');

            const isTeacherSelected = selectedTeachers.some(sTeacher => sTeacher.id === teacher.id);
            const checkedAttribute = isTeacherSelected ? 'checked' : '';

            const teacherGenderDisplay = teacher.gender === 1 ? 'Nam' : 'Nữ';

            const teacherCard = `
            <div class="col-md-6 mb-3">
                <div class="teacher-card ${isTeacherSelected ? 'selected' : ''}" 
                     data-teacher-id="${teacher.id}"
                     data-teacher-name="${teacher.fullname || ''}"
                     data-teacher-gender="${teacher.gender || ''}"
                     data-teacher-rating="${teacher.average_rating || 0}" // Dùng average_rating cho data
                     data-teacher-avatar="${teacher.avatar || 'https://via.placeholder.com/100x100?text=Avatar'}">
                    <div class="teacher-avatar">
                        <img src="${teacher.avatar || 'https://via.placeholder.com/100x100?text=Avatar'}" alt="Teacher Avatar">
                    </div>
                    <div class="teacher-info-wrapper">
                        <h6 class="teacher-info">${teacher.fullname || 'N/A'}</h6>
                        <p class="teacher-detail">${teacherGenderDisplay}</p>
                        <div class="star-rating">
                            ${filledStars}
                            ${emptyStars}
                        </div>
                    </div>
                    <div class="form-check ms-auto">
                        <input class="form-check-input teacher-checkbox" type="checkbox" value="${teacher.id}" id="teacherCheck${teacher.id}" ${checkedAttribute}>
                        <label class="form-check-label" for="teacherCheck${teacher.id}"></label>
                    </div>
                </div>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', teacherCard);
        });

        // Sau khi tất cả các thẻ được thêm vào DOM, gắn lại các event listener
        document.querySelectorAll('.teacher-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', (event) => {
                const teacherId = parseInt(event.target.value);
                const teacherCardElement = event.target.closest('.teacher-card');

                if (event.target.checked) {
                    // Tìm giáo viên gốc từ danh sách allTeachers để đảm bảo lấy đầy đủ data
                    const teacherData = allTeachers.find(t => t.id === teacherId);
                    if (teacherData && !selectedTeachers.some(t => t.id ===
                            teacherId)) { // Tránh thêm trùng lặp
                        selectedTeachers.push(teacherData);
                        teacherCardElement.classList.add('selected');
                    }
                } else {
                    selectedTeachers = selectedTeachers.filter(t => t.id !== teacherId);
                    teacherCardElement.classList.remove('selected');
                }
                updateTeacherConfirmButton();
            });
        });

        // Cập nhật nút sau khi render xong danh sách và gắn event listeners
        updateTeacherConfirmButton();
    }

    function updateTeacherConfirmButton() {
        const button = document.getElementById('teacherConfirmSelectionButton');
        if (button) {
            button.textContent = `Xác nhận chọn (${selectedTeachers.length})`;
            button.disabled = selectedTeachers.length === 0;
        }
    }

    /**
     * Hiển thị các khung giờ của giáo viên.
     * @param {Array} timeSlots - Mảng các khung giờ.
     * @param {number} teacherId - ID của giáo viên.
     */
    function renderFinalSummary() {
        if (!selectedCourse || !selectedDate || selectedTimeSlots.length === 0) {
            return;
        }

        document.getElementById('summaryCourseTitle').textContent = `${selectedCourse.title} - ${selectedCourse.level}`;
        document.getElementById('summaryCourseCategory').textContent = selectedCourse.category;

        const dateObj = new Date(selectedDate);
        const dayOfWeek = new Intl.DateTimeFormat('vi-VN', {
            weekday: 'long'
        }).format(dateObj);
        const dayOfMonth = dateObj.getDate();
        const month = dateObj.getMonth() + 1;
        const year = dateObj.getFullYear();
        document.getElementById('summarySelectedDate').textContent =
            `Học vào ${dayOfWeek} ngày ${dayOfMonth}/${month}/${year}`;

        const summaryTeacherListContainer = document.getElementById('summaryTeacherList');
        summaryTeacherListContainer.innerHTML = '';

        // Lặp qua mảng selectedTimeSlots để hiển thị thông tin cho TỪNG khung giờ đã chọn
        selectedTimeSlots.forEach(slot => {
            const finalSelectedTeacher = selectedTeachers.find(t => t.id === slot.teacher_id);

            // Hiển thị thông tin mặc định nếu không tìm thấy giáo viên
            const teacherName = finalSelectedTeacher ? finalSelectedTeacher.fullname :
                'Giáo viên không xác định';
            const teacherAvatar = finalSelectedTeacher ? finalSelectedTeacher.avatar :
                'https://via.placeholder.com/100x100?text=Avatar';

            const teacherSummaryCard = `
            <div class="col-12 mb-3">
                <div class="card teacher-summary-card">
                    <div class="card-body d-flex align-items-center">
                        <img src="${teacherAvatar}" class="rounded-circle me-3" width="50" height="50" alt="Teacher Avatar">
                        <div>
                            <h6 class="mb-0">${teacherName}</h6>
                            <p class="mb-0 text-muted">
                                ${slot.start_time ? slot.start_time.substring(0, 5) : 'N/A'}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        `;
            summaryTeacherListContainer.insertAdjacentHTML('beforeend', teacherSummaryCard);
        });

        // Nút xác nhận cuối cùng chỉ bị vô hiệu hóa nếu không có khung giờ nào được chọn
        document.getElementById('finalConfirmBtn').disabled = selectedTimeSlots.length === 0;
    }
    // --- Event Listeners and Logic ---

    /**
     * Áp dụng các bộ lọc chính và gọi API khóa học.
     */
    function applyFiltersAndFetchCourses() {
        currentPage = 1;
        closeAllModals();

        currentFilters.search = document.getElementById('mainCourseSearchInput').value.trim();

        const teacherInput = document.getElementById('offcanvasTeacherSearchInput');
        const teacherInputValue = teacherInput.value.trim();

        // --- Chỉ update teacher_id khi tìm thấy match ---
        if (allFetchedTeachers && allFetchedTeachers.length > 0 && teacherInputValue !== '') {
            const selectedTeacher = allFetchedTeachers.find(t => t.fullname === teacherInputValue);
            if (selectedTeacher) {
                currentFilters.teacher_id = selectedTeacher.id;
            }
            // nếu không tìm thấy -> giữ nguyên teacher_id cũ
        }

        fetchCourses(true);

        const filterOffcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('filterOffcanvas'));
        if (filterOffcanvas) filterOffcanvas.hide();
    }



    /**
     * Thêm sự kiện cho các checkbox bộ lọc trong offcanvas.
     */
    function addFilterCheckboxListeners() {
        document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const value = checkbox.value;
                const type = checkbox.dataset.type;
                const labelText = checkbox.nextElementSibling.textContent;
                const containerId = `${type}FilterTags`;
                const container = document.getElementById(containerId);

                if (checkbox.checked) {
                    addFilterTag(labelText, value, type, container);
                } else {
                    removeFilter(value, type);
                }
            });
        });
    }

    /**
     * Thêm sự kiện click cho các nút đăng ký khóa học.
     */
    function populateFinalSummaryModal(data) {
        const summaryCourseTitle = document.getElementById('summaryCourseTitle');
        const summaryCourseCategory = document.getElementById('summaryCourseCategory');
        const summarySelectedDate = document.getElementById('summarySelectedDate');
        const summaryTeacherList = document.getElementById('summaryTeacherList');

        // Đảm bảo các phần tử tồn tại trước khi cố gắng cập nhật chúng
        if (!summaryCourseTitle || !summaryCourseCategory || !summarySelectedDate || !summaryTeacherList) {
            console.error("One or more summary elements not found in the modal.");
            return;
        }

        if (data.course) {
            summaryCourseTitle.textContent = `${data.course.title || 'N/A'} - ${data.course.level || 'N/A'}`;
            summaryCourseCategory.textContent = data.course.category || 'N/A';
        } else {
            summaryCourseTitle.textContent = 'Khóa học: Chưa chọn';
            summaryCourseCategory.textContent = '';
        }

        if (data.date) {
            summarySelectedDate.textContent =
                `Học vào ${new Date(data.date).toLocaleDateString('vi-VN', { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric' })}`;
        } else {
            summarySelectedDate.textContent = 'Ngày học: Chưa chọn';
        }

        summaryTeacherList.innerHTML = ''; // Xóa nội dung cũ của danh sách giáo viên

        if (data.teachers && data.teachers.length > 0) {
            let teacherContent = '';
            data.teachers.forEach(teacher => {
                teacherContent += `<div class="col-12 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="teacher-avatar me-2">
                                        <i class="fas fa-user-circle fa-2x"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0"><strong>Giáo viên:</strong> ${teacher.fullname || teacher.name}</p>
                                        <p class="mb-0"><strong>Buổi học:</strong> ${data.timeSlots.map(s => s.lesson.start_time.substring(0,5)).join(', ')}</p>
                                    </div>
                                </div>
                            </div>`;
            });
            summaryTeacherList.innerHTML = teacherContent;
        } else {
            summaryTeacherList.innerHTML = '<p><strong>Giáo viên:</strong> Chưa chọn</p>';
        }
    }

    function addRegisterButtonListeners() {
        document.addEventListener('click', (e) => {
            if (!e.target.matches('.register-course-btn')) return;
            const button = e.target;
            const courseId = parseInt(button.dataset.courseId);

            // Find selectedCourse
            selectedCourse = coursesData.find(course => course.id === courseId);
            if (!selectedCourse) return console.error('Course not found');

            // Update details from card dataset
            const card = button.closest('.course-card-booking');
            selectedCourse.title = card.dataset.courseTitle;
            selectedCourse.category = card.dataset.courseCategory;
            selectedCourse.level = card.dataset.courseLevel;

            // Populate dataRegisterModal
            dataRegisterModal.course = {
                id: courseId,
                title: selectedCourse.title,
                category: selectedCourse.category,
                level: selectedCourse.level
            };

            const hasTime = dataRegisterModal.timeSlots?.length > 0;
            const hasTeachers = dataRegisterModal.teachers?.length > 0;
            if (hasTime && hasTeachers) {
                populateFinalSummaryModal(dataRegisterModal);
                openModal('finalSummaryModal').show();
            } else {
                renderDateCards();
                openModal('dateSelectionModal').show();
            }
        });
    }

    /**
     * Hiển thị các khung giờ trống của giáo viên trong modal.
     * @param {Array} timeSlots - Mảng các khung giờ trống.
     * @param {number} currentTeacherId - ID của giáo viên hiện tại.
     */
    document.addEventListener('DOMContentLoaded', () => {
        const timeSlotsContainer = document.getElementById('timeSlotsContentWrapper');
        if (timeSlotsContainer) {
            timeSlotsContainer.addEventListener('click', function(event) {
                const btn = event.target.closest('.time-slot-btn');

                if (btn) {
                    const teacherLessonId = parseInt(btn.dataset.teacherLessonId);

                    const index = selectedTimeSlots.findIndex(s => s.teacher_lesson_id ===
                        teacherLessonId);
                    if (index > -1) {
                        selectedTimeSlots.splice(index, 1);
                        btn.classList.remove('active');
                    } else {
                        selectedTimeSlots.push({
                            course_id: selectedCourse ? parseInt(selectedCourse.id) : null,
                            teacher_id: parseInt(btn.dataset.teacherId),
                            lesson_id: parseInt(btn.dataset.lessonId),
                            teacher_lesson_id: teacherLessonId,
                            start_time: btn.dataset.start,
                        });
                        btn.classList.add('active');
                    }
                    document.getElementById('confirmTimeSelectionButton').disabled = selectedTimeSlots
                        .length === 0;
                }
            });
        }
    });

    function renderTimeSlots(timeSlots, currentTeacherId) {
        const container = document.getElementById('timeSlotsContentWrapper');
        container.innerHTML = '';
        const selectedTeacherInModal = selectedTeachers.find(t => t.id === currentTeacherId);
        if (!selectedTeacherInModal) {
            container.innerHTML =
                '<p class="text-center text-danger">Không tìm thấy thông tin giáo viên được chọn.</p>';
            document.getElementById('confirmTimeSelectionButton').disabled = true;
            return;
        }

        if (!Array.isArray(timeSlots)) {
            container.insertAdjacentHTML('beforeend',
                '<p class="text-center text-danger">Đã xảy ra lỗi khi tải thời gian trống (dữ liệu không phải mảng).</p>'
            );
            document.getElementById('confirmTimeSelectionButton').disabled = true;
            return;
        }

        if (timeSlots.length === 0) {
            container.insertAdjacentHTML('beforeend',
                '<p class="text-center w-100">Không có khung giờ trống cho giáo viên này vào ngày đã chọn.</p>');
            document.getElementById('confirmTimeSelectionButton').disabled = true;
            return;
        }

        const morningSlots = [];
        const afternoonSlots = [];
        const eveningSlots = [];

        timeSlots.forEach(slot => {
            if (slot.start_time) {
                const hour = parseInt(slot.start_time.substring(0, 2));
                if (hour < 12) { // từ 00:00 → 11:59
                    morningSlots.push(slot);
                } else if (hour >= 12 && hour < 18) {
                    afternoonSlots.push(slot);
                } else if (hour >= 18 && hour < 24) {
                    eveningSlots.push(slot);
                }
            }
        });


        function createTimeSlotSection(title, slots, currentTeacherId, selectedTimeSlots) {
            if (slots.length === 0) {
                return '';
            }

            let slotsHtml = '';
            slots.forEach(slot => {
                const displayedStartTime = slot.start_time ? slot.start_time.substring(0, 5) : 'N/A';
                const isSelected = selectedTimeSlots.some(s => s.teacher_lesson_id === slot.teacher_lesson_id);

                slotsHtml += `
                <button type="button" class="btn btn-outline-primary time-slot-btn mb-2 me-2 ${isSelected ? 'active' : ''}"
                        data-start="${slot.start_time || ''}"
                        data-teacher-id="${currentTeacherId}"
                        data-lesson-id="${slot.id || ''}"
                        data-teacher-lesson-id="${slot.teacher_lesson_id || ''}">
                    ${displayedStartTime}
                </button>
            `;
            });

            return `
            <div class="time-slot-group mb-4">
                <h5 class="time-group-title">${title}</h5>
                <div class="time-slots-grid d-flex flex-wrap">
                    ${slotsHtml}
                </div>
            </div>
        `;
        }

        container.insertAdjacentHTML('beforeend', createTimeSlotSection('Buổi Sáng', morningSlots, currentTeacherId,
            selectedTimeSlots));
        container.insertAdjacentHTML('beforeend', createTimeSlotSection('Buổi Chiều', afternoonSlots, currentTeacherId,
            selectedTimeSlots));
        container.insertAdjacentHTML('beforeend', createTimeSlotSection('Buổi Tối', eveningSlots, currentTeacherId,
            selectedTimeSlots));

        document.getElementById('confirmTimeSelectionButton').disabled = selectedTimeSlots.length === 0;
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchCourses(false);
        fetchCategories();
        fetchLevels();

        document.getElementById('mainCourseSearchInput').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                applyFiltersAndFetchCourses();
            }
        });

        document.getElementById('displayLimitSelect').addEventListener('change', (e) => {
            currentLimit = parseInt(e.target.value);
            currentPage = 1;
            fetchCourses(true);
        });

        document.getElementById('applyFiltersBtn').addEventListener('click', applyFiltersAndFetchCourses);
        document.getElementById('clearFiltersBtn').addEventListener('click', clearAllFilters);

        const genderFilterTagsContainer = document.getElementById('genderFilterTags');
        const genders = [{
                value: 1,
                text: 'Nam'
            },
            {
                value: 2,
                text: 'Nữ'
            }
        ];

        genders.forEach(gender => {
            const div = document.createElement('div');
            div.className = 'form-check form-check-inline p-0';
            div.innerHTML = `
        <input class="form-check-input filter-checkbox" type="checkbox" id="gender-${gender.value}" data-type="gender" value="${gender.value}">
        <label class="form-check-label" for="gender-${gender.value}">${gender.text}</label>
    `;
            genderFilterTagsContainer.appendChild(div);
        });


        const ratingFilterTagsContainer = document.getElementById('ratingFilterTags');
        for (let i = 5; i >= 1; i--) {
            const div = document.createElement('div');
            div.className = 'form-check form-check-inline p-0';
            div.innerHTML = `
            <input class="form-check-input filter-checkbox" type="checkbox" id="rating-${i}" data-type="rating" value="${i}">
            <label class="form-check-label" for="rating-${i}">${i} sao</label>
        `;
            ratingFilterTagsContainer.appendChild(div);
        }
        addFilterCheckboxListeners();

        document.getElementById('filterDate').addEventListener('change', (e) => {
            currentFilters.date = e.target.value;
        });
        $('#filterOffcanvas').off('show.bs.offcanvas').on('show.bs.offcanvas', async function() {
            const teacherSearchInput = document.getElementById('offcanvasTeacherSearchInput');
            const teacherSearchList = document.getElementById('offcanvasTeacherSearchList');
            const lessonFilterTagsContainer = $('#lessonFilterTags');
            const filterDateInput = document.getElementById('filterDate');

            let allFetchedLessons = [];
            let allFetchedTeachers = [];
            let isLoadingTimeSlots = false; // ✅ Thêm flag để tránh gọi API 2 lần

            // --- Khởi tạo date ---
            dataRegisterModal.date = currentFilters.date || null;

            if (studentSearchInput && studentSearchList) {
                await fetchAndDisplayStudents(studentSearchInput.value);
            }
            if (currentFilters.date) {
                filterDateInput.value = currentFilters.date;
            }

            // ================= RENDER TEACHER DROPDOWN =================
            function renderTeacherDropdown(teachers, showDropdown = false) {
                teacherSearchList.innerHTML = '';
                teacherSearchList.style.display = 'none';

                teachers.forEach(teacher => {
                    const li = document.createElement('li');
                    li.textContent = teacher.fullname;
                    li.setAttribute('data-id', teacher.id);
                    li.classList.add('dropdown-item');
                    li.style.cursor = 'pointer';

                    li.addEventListener('click', async () => {
                        // --- Cập nhật filters & modal ---
                        teacherSearchInput.value = teacher.fullname;
                        teacherSearchList.style.display = 'none';
                        currentFilters.teacher_id = teacher.id;
                        dataRegisterModal.teachers = [teacher];
                        dataRegisterModal.timeSlots = [];

                        // ✅ CHỈ GỌI fetchAndDisplayTimeSlots, bỏ phần fetch riêng lẻ
                        await fetchAndDisplayTimeSlots(teacher.id);
                    });

                    teacherSearchList.appendChild(li);
                });

                if (showDropdown) {
                    teacherSearchList.style.display = 'block';
                }
            }

            // ================== TEACHER SEARCH EVENTS ==================
            // ✅ Remove existing event listeners trước khi add mới
            teacherSearchInput.removeEventListener('input', handleTeacherInput);
            teacherSearchInput.removeEventListener('focus', handleTeacherFocus);

            function handleTeacherInput() {
                const keyword = teacherSearchInput.value.toLowerCase();
                const filtered = allFetchedTeachers.filter(t =>
                    t.fullname.toLowerCase().includes(keyword)
                );
                renderTeacherDropdown(filtered, true);
            }

            function handleTeacherFocus() {
                const keyword = teacherSearchInput.value.toLowerCase();
                const filtered = allFetchedTeachers.filter(t =>
                    t.fullname.toLowerCase().includes(keyword)
                );
                renderTeacherDropdown(filtered, true);
            }

            teacherSearchInput.addEventListener('input', handleTeacherInput);
            teacherSearchInput.addEventListener('focus', handleTeacherFocus);

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.custom-select-wrapper')) {
                    teacherSearchList.style.display = 'none';
                }
            });

            // ================== FETCH & DISPLAY TIME SLOTS ==================
            const fetchAndDisplayTimeSlots = async (teacherId) => {
                // ✅ Tránh gọi API 2 lần
                if (isLoadingTimeSlots) {
                    return;
                }

                isLoadingTimeSlots = true;

                try {
                    currentFilters.teacher_id = teacherId;
                    const selectedTeacher = allFetchedTeachers.find(t => String(t.id) ===
                        String(teacherId));
                    dataRegisterModal.teachers = selectedTeacher ? [selectedTeacher] : [];

                    // ✅ Clear UI trước khi load
                    lessonFilterTagsContainer.empty();
                    allFetchedLessons = [];

                    if (!teacherId || teacherId === '0') {
                        lessonFilterTagsContainer.append('<p>Vui lòng chọn Giáo viên.</p>');
                        return;
                    }

                    // ✅ Thêm loading indicator
                    lessonFilterTagsContainer.append(
                        '<p class="text-muted">Đang tải buổi học...</p>');

                    const apiUrl = window.AppConfig.apiEndpoints.lessons;
                    const queryParams = getQueryParams(currentFilters);

                    const response = await fetch(`${apiUrl}?${queryParams}`);
                    const data = await response.json();

                    // ✅ Clear loading indicator
                    lessonFilterTagsContainer.empty();

                    if (!response.ok || data.success === false) {
                        lessonFilterTagsContainer.append(
                            `<p>${data.message || 'Không có buổi học khả dụng.'}</p>`
                        );
                        return;
                    }

                    allFetchedLessons = Array.isArray(data.data) ? data.data : [];

                    if (allFetchedLessons.length === 0) {
                        lessonFilterTagsContainer.append(
                            '<p>Không có buổi học khả dụng.</p>');
                        return;
                    }

                    // ✅ Render lesson buttons với check duplicate
                    const renderedLessonIds = new Set(); // Tránh render duplicate

                    allFetchedLessons.forEach(slot => {
                        if (renderedLessonIds.has(slot.teacher_lesson_id)) {
                            console.warn(
                                `Lesson ID ${slot.teacher_lesson_id} đã được render, bỏ qua`
                            );
                            return;
                        }

                        renderedLessonIds.add(slot.teacher_lesson_id);

                        const startTime = slot.start_time ? slot.start_time
                            .substring(0, 5) : 'N/A';
                        const isActive = dataRegisterModal.timeSlots.some(
                            s => String(s.lesson.teacher_lesson_id) === String(
                                slot.teacher_lesson_id)
                        ) ? 'active' : '';

                        lessonFilterTagsContainer.append(
                            `<button type="button" class="btn btn-outline-lesson btn-sm m-1 lesson-tag ${isActive}" 
                data-lesson-id="${slot.teacher_lesson_id}" 
                data-lesson-time="${startTime}">
                ${startTime}
            </button>`
                        );
                    });

                    // ✅ Gắn sự kiện click với off() trước để tránh multiple binding
                    lessonFilterTagsContainer.find('.lesson-tag').off('click').on('click',
                        function() {
                            const lessonId = $(this).data('lesson-id').toString();
                            const lessonTime = $(this).data('lesson-time');
                            const clickedLesson = allFetchedLessons.find(slot =>
                                String(slot.teacher_lesson_id) === lessonId
                            );

                            if ($(this).hasClass('active')) {
                                $(this).removeClass('active');
                                dataRegisterModal.timeSlots = dataRegisterModal
                                    .timeSlots.filter(
                                        s => String(s.lesson.teacher_lesson_id) !==
                                        lessonId
                                    );
                                if (typeof removeFilter === 'function') removeFilter(
                                    lessonId, 'lesson');
                            } else {
                                $(this).addClass('active');
                                if (clickedLesson && selectedTeacher) {
                                    const teacherLesson = selectedTeacher
                                        .teacher_lessons?.find(
                                            tl => String(tl.id) === lessonId
                                        );
                                    if (teacherLesson && !dataRegisterModal.timeSlots
                                        .some(
                                            s => String(s.lesson.teacher_lesson_id) ===
                                            lessonId
                                        )) {
                                        dataRegisterModal.timeSlots.push({
                                            lesson: clickedLesson,
                                            teacher_lesson_id: teacherLesson.id
                                        });
                                        if (typeof addFilterTag === 'function') {
                                            addFilterTag(lessonTime, lessonId, 'lesson',
                                                document.getElementById(
                                                    'lessonFilterTags'));
                                        }
                                    } else if (!teacherLesson) {
                                        console.warn(
                                            `Không tìm thấy teacher_lesson với ID ${lessonId}`
                                        );
                                        $(this).removeClass('active');
                                    }
                                }
                            }
                        });

                } catch (error) {
                    console.error('Error fetching time slots:', error);
                    lessonFilterTagsContainer.empty().append(
                        '<p class="text-danger">Đã xảy ra lỗi khi tải buổi học.</p>'
                    );
                } finally {
                    // ✅ Reset flag
                    isLoadingTimeSlots = false;
                }
            };

            // ================== FETCH TEACHERS ==================
            const fetchAndDisplayTeachers = async (date) => {
                dataRegisterModal.teachers = [];

                try {
                    let teacherApiUrl = window.AppConfig.apiEndpoints.teachers;
                    if (date) teacherApiUrl = `${teacherApiUrl}?date=${date}`;

                    const response = await fetch(teacherApiUrl);
                    if (!response.ok) throw new Error(
                        `Failed to fetch teachers. Status: ${response.status}`);

                    const data = await response.json();
                    allFetchedTeachers = Array.isArray(data) ? data : data.data;

                    if (Array.isArray(allFetchedTeachers)) {
                        renderTeacherDropdown(allFetchedTeachers);

                        const initial = currentFilters.teacher_id ?
                            allFetchedTeachers.find(t => String(t.id) === String(
                                currentFilters.teacher_id)) :
                            null;

                        if (initial) {
                            teacherSearchInput.value = initial.fullname;
                            await fetchAndDisplayTimeSlots(initial.id); // ✅ Chỉ gọi 1 lần
                        } else {
                            teacherSearchInput.value = '';
                            lessonFilterTagsContainer.html(
                                '<p>Vui lòng chọn Giáo viên.</p>');
                        }
                    } else {
                        console.error('API trả về danh sách giáo viên không hợp lệ:', data);
                    }
                } catch (error) {
                    console.error('Lỗi tải danh sách giáo viên:', error);
                    teacherSearchList.innerHTML =
                        '<li class="dropdown-item text-danger">Tải giáo viên thất bại</li>';
                }
            };

            // ================== DATE FILTER ==================
            $(filterDateInput).off('change.dateFilter').on('change.dateFilter', async (e) => {
                currentFilters.date = e.target.value;
                dataRegisterModal.date = currentFilters.date;

                currentFilters.teacher_id = null;
                currentFilters.lessons = [];
                dataRegisterModal.teachers = [];
                dataRegisterModal.timeSlots = [];

                teacherSearchInput.value = '';
                teacherSearchList.innerHTML = '';
                lessonFilterTagsContainer.empty().append(
                    '<p>Vui lòng chọn Giáo viên.</p>');

                await fetchAndDisplayTeachers(currentFilters.date);
            });

            await fetchAndDisplayTeachers(currentFilters.date);

        });
        // 4. Logic cho Modal Chọn ngày
        document.getElementById('confirmDateAndShowTeacherModal').addEventListener('click', async () => {
            if (!selectedDate) {
                return alert('Vui lòng chọn một ngày.');
            }
            // Ẩn dateSelectionModal rồi show teacherSelectionModal
            await switchModal('dateSelectionModal', 'teacherSelectionModal');
            // Lấy và render danh sách giáo viên
            await fetchTeachers(selectedDate, selectedCourse.id);
        });

        // 5. Logic cho Modal Chọn Giáo viên
        document.getElementById('teacherSearchInput').addEventListener('input', () => {
            filterTeachersInModal();
        });
        document.getElementById('teacherGenderFilter').addEventListener('change', () => {
            filterTeachersInModal();
        });
        document.getElementById('teacherRatingFilter').addEventListener('change', () => {
            filterTeachersInModal();
        });


        document.getElementById('teacherConfirmSelectionButton').addEventListener('click', async () => {
            if (selectedTeachers.length === 0) {
                return alert('Vui lòng chọn ít nhất một giáo viên.');
            }
            await switchModal('teacherSelectionModal', 'timeSelectionModal');
            // Lấy và render khung giờ
            const first = selectedTeachers[0];
            const slots = await fetchTeacherAvailableTimes({
                teacher_id: firstSelectedTeacher.id,
                date: selectedDate,
                course_id: selectedCourse?.id || null
            });

            renderTimeSlots(slots, first.id);
        });

        // 6. Logic cho Modal Chọn thời gian
        document.getElementById('confirmTimeSelectionButton').addEventListener('click', () => {
            if (!selectedTimeSlots) {
                return alert('Vui lòng chọn một khung giờ.');
            }
            switchModal('timeSelectionModal', 'finalSummaryModal');
            renderFinalSummary();
        });

        // Xử lý sự kiện click cho nút xác nhận cuối cùng
        function toggleLoadingState(isLoading) {
            const finalConfirmBtn = document.getElementById('finalConfirmBtn');
            const buttonText = finalConfirmBtn.querySelector('.button-text');
            const loadingText = finalConfirmBtn.querySelector('.loading-text');
            const spinner = finalConfirmBtn.querySelector('.spinner-border');

            if (isLoading) {
                finalConfirmBtn.disabled = true; // Vô hiệu hóa nút
                buttonText.style.display = 'none'; // Ẩn text mặc định
                loadingText.style.display = 'inline'; // Hiện text "Đang xử lý..."
                spinner.style.display = 'inline-block'; // Hiện spinner
            } else {
                finalConfirmBtn.disabled = false; // Kích hoạt lại nút
                buttonText.style.display = 'inline'; // Hiện text mặc định
                loadingText.style.display = 'none'; // Ẩn text "Đang xử lý..."
                spinner.style.display = 'none'; // Ẩn spinner
            }
        }

        // 7. Logic cho Modal đăng ký buổi học
        document.getElementById('finalConfirmBtn').addEventListener('click', async () => {
            let bookingsData = [];

            const courseIdToRegister = dataRegisterModal.course?.id || null;
            const dateToRegister = dataRegisterModal.date;
            const studentIdToRegister = dataRegisterModal.studentId || null;
            const teacherIdForBookings = dataRegisterModal.teachers?.[0]?.id || null;

            if (courseIdToRegister && dateToRegister && dataRegisterModal.timeSlots.length > 0) {
                bookingsData = dataRegisterModal.timeSlots.map(slotItem => ({
                    course_id: courseIdToRegister,
                    date: dateToRegister,
                    lesson_id: slotItem.lesson?.lesson_id || null, // fix chỗ này
                    teacher_lesson_id: slotItem.teacher_lesson_id,
                    start_time: slotItem.lesson?.start_time || null, // fix chỗ này
                    teacher_id: teacherIdForBookings,
                    student_id: studentIdToRegister,
                }));

            }
            // Trường hợp dùng selectedTimeSlots
            else {
                bookingsData = selectedTimeSlots.map(slot => ({
                    course_id: parseInt(selectedCourse.id),
                    date: selectedDate,
                    teacher_id: slot.teacher_id,
                    lesson_id: slot.lesson_id,
                    teacher_lesson_id: slot.teacher_lesson_id,
                    start_time: slot.start_time,
                    student_id: studentIdToRegister,
                }));
            }

            toggleLoadingState(true);

            try {
                const response = await fetch(window.AppConfig.apiEndpoints.bookings, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify(bookingsData)
                });

                if (response.ok) {
                    const responseData = await response.json();

                    const finalSummaryModal = bootstrap.Modal.getInstance(
                        document.getElementById('finalSummaryModal')
                    );
                    finalSummaryModal.hide();

                    // Reset lại modal data
                    dataRegisterModal = {
                        course: null,
                        date: null,
                        timeSlots: [],
                        teachers: [],
                        studentId: null,
                        studentName: null,
                    };

                    if (typeof selectedCourse !== 'undefined') selectedCourse = null;
                    if (typeof selectedTimeSlots !== 'undefined') selectedTimeSlots = [];
                    if (typeof selectedTeachers !== 'undefined') selectedTeachers = [];

                    currentFilters.date = null;
                    currentFilters.teacher_id = null;
                    currentFilters.lessons = [];
                    currentFilters.student_id = null;

                    fetchCourses(true);
                    showSuccessToast('Đăng ký khóa học thành công!');
                } else {
                    const errorData = await response.json();
                    console.error("❌ Lỗi từ server:", errorData);

                    let message = 'Có lỗi xảy ra khi đăng ký.';
                    if (errorData.message) {
                        message = errorData.message;
                    } else if (errorData.error) {
                        message = errorData.error;
                    }
                    showErrorToast(message);
                }
            } catch (error) {
                console.error('🚨 Lỗi kết nối đến máy chủ:', error);
                showErrorToast('Không thể kết nối đến máy chủ. Vui lòng thử lại.');
            } finally {
                toggleLoadingState(false);
            }
        });

    });
</script>
