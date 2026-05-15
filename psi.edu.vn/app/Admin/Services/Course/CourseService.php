<?php

namespace App\Admin\Services\Course;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Services\Course\CourseServiceInterface;
use App\Admin\Repositories\Course\CourseRepositoryInterface;
use App\Admin\Repositories\Lesson\LessonRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\Setup;
use App\Enums\Booking\BookingStatus;
use App\Enums\Notification\NotificationStatus;
use App\Traits\UseLog;
use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Carbon\Carbon;

class CourseService implements CourseServiceInterface
{
    use UseLog, Setup;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected CourseRepositoryInterface $repository;
    protected AdminRepositoryInterface $adminRepository;
    protected CategoryRepositoryInterface $courseCategoryRepository;
    protected NotificationRepositoryInterface $notificationRepository;
    protected LessonRepositoryInterface $lessonRepository;
    protected FileService $fileService;

    public function __construct(
        CourseRepositoryInterface $repository,
        CategoryRepositoryInterface $courseCategoryRepository,
        NotificationRepositoryInterface $notificationRepository,
        AdminRepositoryInterface $adminRepository,
        FileService $fileService,
        LessonRepositoryInterface $lessonRepository,
    ) {
        $this->repository = $repository;
        $this->adminRepository = $adminRepository;
        $this->courseCategoryRepository = $courseCategoryRepository;
        $this->notificationRepository = $notificationRepository;
        $this->fileService = $fileService;
        $this->lessonRepository = $lessonRepository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();

        if (isset($data['avatar'])) {
            $data['avatar'] = $this->fileService->uploadAvatar('images', $data['avatar'], null);
        }

        $categoriesId = $data['categories_id'] ?? [];

        DB::beginTransaction();
        try {

            $course = $this->repository->create($data);

            if ($categoriesId) {
                $this->repository->attachCategories($course, $categoriesId);
            }

            DB::commit();
            return $course;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->logError('Failed to process create course CMS', $e);
            return false;
        }
    }

    public function storeRegistedLessons(Request $request)
    {
        $course = $this->repository->findOrFail($request['id']);
        $teacher_id = $request['teacher_id'];
        $lessonIds = $request['lesson_id'] ?? [];

        $admin = $this->adminRepository->findOrFail($teacher_id);

        // Lấy danh sách các lesson giáo viên này đã đăng ký từ trước
        $existingLessonIds = $admin->lessons()->pluck('lessons.id')->toArray();

        foreach ($lessonIds as $lessonId) {
            $lesson = $this->lessonRepository->findOrFail($lessonId);

            $lessonDate = Carbon::parse($lesson->date)->toDateString();
            $lessonTime = Carbon::parse($lesson->start_time)->format('H:i:s');

            //Bỏ qua kiểm tra nếu giáo viên này đã dạy buổi này
            if (in_array($lessonId, $existingLessonIds)) {
                continue;
            }

            $conflict = DB::table('lessons')
                ->join('teacher_lessons', 'lessons.id', '=', 'teacher_lessons.lesson_id')
                ->where('lessons.date', $lessonDate)
                ->where('lessons.start_time', $lessonTime)
                ->where('teacher_lessons.admin_id', $teacher_id) // ✅ kiểm tra chính giáo viên đó
                ->exists();

            if ($conflict) {
                return "Giáo viên đã có buổi học trùng lịch vào {$lessonDate} lúc {$lessonTime}";
            }
        }

        // Gán giáo viên cho các lesson mới (loại bỏ những lesson đã đăng ký trước đó)
        $newLessonIds = array_diff($lessonIds, $existingLessonIds);
        if (!empty($newLessonIds)) {
            $admin->lessons()->attach($newLessonIds);
        }

        return true;
    }

    public function update(Request $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        if (isset($data['avatar'])) {
            $data['avatar'] = $this->fileService->uploadAvatar('images', $data['avatar'], null);
        }

        $categoriesId = $data['categories_id'] ?? [];
        try {
            $course = $this->repository->update($data['id'], $data);
            $this->repository->syncCategories($course, $categoriesId);
            DB::commit();
            return $course;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->logError('Failed to process update course CMS', $e);
            return false;
        }
    }



    /**
     * @throws Exception
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }


    public function getTeacherNames($id)
    {
        $teachers = Course::join('lessons', 'lessons.course_id', '=', 'courses.id')
            ->join('teacher_lessons', 'teacher_lessons.lesson_id', '=', 'lessons.id')
            ->join('admins', 'admins.id', '=', 'teacher_lessons.admin_id')
            ->where('courses.id', $id)
            ->select('admins.fullname', 'admins.id')
            ->get();

        if ($teachers->isEmpty()) {
            return 'Chưa có giáo viên';
        }

        return $teachers;
    }
}
