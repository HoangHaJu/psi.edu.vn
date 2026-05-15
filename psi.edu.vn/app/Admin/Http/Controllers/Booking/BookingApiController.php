<?php

namespace App\Admin\Http\Controllers\Booking;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\{
    Admin\AdminRepositoryInterface,
    Category\CategoryRepositoryInterface,
    Course\CourseRepositoryInterface,
    Lesson\LessonRepositoryInterface,
    StudentLesson\StudentLessonRepositoryInterface,
    TicketStudent\TicketStudentRepositoryInterface
};
use App\Admin\Services\{
    StudentLesson\StudentLessonServiceInterface,
    TicketStudent\TicketStudentServiceInterface
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Course;
use App\Filters\CourseFilter;
use Carbon\Carbon;

class BookingApiController extends Controller
{
    protected $adminRepository, $categoryRepository, $courseRepository, $lessonRepository, $studentLessonRepository, $ticketStudentRepository;
    protected $studentlessonService, $ticketStudentService;

    public function __construct(
        AdminRepositoryInterface $adminRepository,
        CategoryRepositoryInterface $categoryRepository,
        CourseRepositoryInterface $courseRepository,
        LessonRepositoryInterface $lessonRepository,
        StudentLessonRepositoryInterface $studentLessonRepository,
        TicketStudentRepositoryInterface $ticketStudentRepository,
        StudentLessonServiceInterface $studentlessonService,
        TicketStudentServiceInterface $ticketStudentService,
    ) {
        $this->adminRepository = $adminRepository;
        $this->categoryRepository = $categoryRepository;
        $this->courseRepository = $courseRepository;
        $this->lessonRepository = $lessonRepository;
        $this->studentLessonRepository = $studentLessonRepository;
        $this->ticketStudentRepository = $ticketStudentRepository;
        $this->studentlessonService = $studentlessonService;
        $this->ticketStudentService = $ticketStudentService;
    }

    public function apiCourse(Request $request)
    {
        try {
            $courses = Course::with([
                'categories',
                'lessons.teacherLessons',
                'lessons.teacherLessons.studentLesson'
            ])
                ->filter(CourseFilter::class, $request)
                ->paginate($request->input('limit', 10));

            return response()->json($courses);
        } catch (\Exception $e) {
            Log::error('Lỗi trong apiCourse', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return response()->json(['message' => 'Đã xảy ra lỗi server nội bộ khi tải khóa học.'], 500);
        }
    }

    public function apiTeacher(Request $request)
    {
        $filters = $request->only(['fullname', 'gender', 'rating', 'date', 'category_id', 'course_id']);
        $perPage = $request->get('per_page', 10);

        // Lấy dữ liệu từ repository (đã trả về ['items', 'meta', 'links'])
        $teachersPaginated = $this->adminRepository->getTeachersForSelection($filters, $perPage);

        // Chuyển items sang Collection để filter map
        $teachers = collect($teachersPaginated['items']);

        // Nếu không có dữ liệu
        if ($teachers->isEmpty()) {
            return response()->json([
                'items' => [],
                'meta' => $teachersPaginated['meta'],
                'links' => $teachersPaginated['links'],
            ]);
        }

        $existTeacherLessonDateTime = auth()->user()->student_lessons
            ->map(fn($lesson) => $lesson->date . ' ' . $lesson->start_time)
            ->unique();

        $teachers = $teachers->map(function ($teacher) use ($existTeacherLessonDateTime, $filters) {
            $teacherLessons = collect($teacher->teacher_lessons ?? []);
            $rateForStudent = $this->studentlessonService->getAverageRatingsForStudent($teacher->id);

            $filteredLessons = $teacherLessons->filter(function ($teacherLesson) use ($existTeacherLessonDateTime, $filters) {
                if (!isset($teacherLesson->lesson)) return false;

                $lessonDateTime = $teacherLesson->lesson->date . ' ' . $teacherLesson->lesson->start_time;
                $currentDate = Carbon::now()->startOfDay();
                $lessonDate = Carbon::parse($teacherLesson->lesson->date)->startOfDay();

                if (isset($filters['date'])) {
                    $selectedDate = Carbon::parse($filters['date'])->startOfDay();
                    if (!$lessonDate->isSameDay($selectedDate)) return false;
                } else {
                    if ($lessonDate->lessThan($currentDate)) return false;
                }

                if (isset($filters['course_id']) && $teacherLesson->lesson->course_id != $filters['course_id']) {
                    return false;
                }

                if ($existTeacherLessonDateTime->contains($lessonDateTime)) return false;

                return true;
            });

            if ($filteredLessons->isEmpty()) return null;

            $teacher->teacher_lessons = $filteredLessons->values();
            $teacher->rateForStudent = $rateForStudent;
            return $teacher;
        })->filter();

        return response()->json([
            'items' => $teachers->values(),
            'meta' => $teachersPaginated['meta'],
            'links' => $teachersPaginated['links'],
        ]);
    }


    public function apiCategories(): JsonResponse
    {
        return response()->json($this->categoryRepository->getBy(['is_active' => 1]));
    }

    public function apiLevels(): JsonResponse
    {
        return response()->json($this->courseRepository->getEducationLevels());
    }

    public function apiTeacherAvailableTimes(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'teacher_id' => 'required|integer|exists:admins,id',
            'date' => 'required|date_format:Y-m-d',
            'course_id' => 'nullable|integer|exists:courses,id',
        ]);

        $teacher = $this->adminRepository->findOrFail($validated['teacher_id']);
        $allLessons = $this->lessonRepository->getLessonForTeacher($teacher->id, $validated['date'], $validated['course_id'] ?? null);

        $bookedLessonIds = DB::table('student_lessons')
            ->whereDate('date', $validated['date'])
            ->pluck('teacher_lesson_id')
            ->toArray();

        $availableTimeSlots = $allLessons->reject(fn($lesson) => in_array($lesson->teacher_lesson_id, $bookedLessonIds))->values();

        if ($availableTimeSlots->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Không có khung giờ khả dụng'], 404);
        }

        return response()->json(['success' => true, 'data' => $availableTimeSlots]);
    }

    public function apiStudent(Request $request): JsonResponse
    {
        $students = $this->adminRepository->getStudentsForSelection(
            $request->query('search'),
            (int) $request->query('per_page', 20)
        );

        return response()->json($students);
    }

    public function apiLessons(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:admins,id',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $allLessons = DB::table('teacher_lessons as tl')
            ->join('lessons as l', 'l.id', '=', 'tl.lesson_id')
            ->where('tl.admin_id', $validated['teacher_id'])
            ->whereDate('l.date', '=', $validated['date'])
            ->select('tl.id as teacher_lesson_id', 'l.id as lesson_id', 'l.start_time', 'l.date')
            ->orderBy('l.start_time')
            ->get();

        $bookedLessonIds = DB::table('student_lessons')
            ->whereDate('date', $validated['date'])
            ->pluck('teacher_lesson_id')
            ->toArray();

        $availableLessons = $allLessons->reject(fn($lesson) => in_array($lesson->teacher_lesson_id, $bookedLessonIds))->values();

        if ($availableLessons->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Không còn buổi học khả dụng'], 404);
        }

        return response()->json(['success' => true, 'data' => $availableLessons]);
    }

    public function apiTypeTicket(Request $request): JsonResponse
    {
        $student_id = $request->input('student_id');
        if (!$student_id) {
            return response()->json(['error' => true, 'message' => 'Student ID is required'], 400);
        }

        $typeTickets = $this->ticketStudentRepository->getUserTicketTypes($student_id);
        return response()->json(['error' => false, 'data' => $typeTickets]);
    }

    public function apiTicketOptions($studentId): JsonResponse
    {
        try {
            $result = $this->ticketStudentService->getTicketTypesForStudent($studentId);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function apiCourseModal(Request $request): JsonResponse
    {
        $courses = $this->courseRepository->getCoursesForSelection(
            $request->query('search'),
            (int)$request->query('per_page', 20),
            $request->query('category_id')
        );
        return response()->json($courses);
    }
}
