<?php

namespace App\Admin\Services\Lesson;

use App\Admin\Services\Lesson\LessonServiceInterface;
use App\Admin\Repositories\Lesson\LessonRepositoryInterface;
use App\Admin\Services\File\FileService;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Enums\Lesson\DayOffType;
use Illuminate\Support\Carbon;

class LessonService implements LessonServiceInterface
{
    use Setup;

    protected $data;
    protected $repository;
    protected $fileService;

    public function __construct(
        LessonRepositoryInterface $repository,
        FileService $fileService
    ) {
        $this->repository = $repository;
        $this->fileService = $fileService;
    }

    /**
     * Tạo mới buổi học, kèm kiểm tra ngày không được là quá khứ
     */
    public function store(Request $request)
    {
        $this->data = $request->all();

        if (isset($this->data['date'])) {
            $lessonDate = Carbon::parse($this->data['date'])->startOfDay();
            $today = Carbon::now()->startOfDay();

            if ($lessonDate->lt($today)) {
                throw new \Exception('Không thể tạo buổi học ở ngày đã qua.');
            }
        }

        return $this->repository->create($this->data);
    }

    /**
     * Cập nhật buổi học
     */
    public function update(Request $request)
    {
        $this->data = $request->validated();

        if (isset($this->data['file'])) {
            $this->data['file'] = $this->fileService->uploadAvatar('files', $this->data['file'], null);
            $this->data['file_link'] = asset($this->data['file']);
        }

        return $this->repository->update($this->data['id'], $this->data);
    }

    /**
     * Cập nhật buổi học bù
     */
    public function updateMakeUpLesson($data)
    {
        return $this->repository->update($data['id'], $data);
    }

    /**
     * Xoá buổi học
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Sinh các khoảng thời gian trong ngày theo chu kỳ
     */
    public function generateTimeIntervals($startTime, $endTime, $period)
    {
        $intervals = [];
        $current = strtotime($startTime);
        $end = strtotime($endTime);
        $periodInSeconds = $period * 60;

        while ($current <= $end) {
            $intervals[] = date('H:i', $current);
            $current += $periodInSeconds;
        }

        return $intervals;
    }
}
