<?php

namespace App\Admin\Services\Lesson;

use Illuminate\Http\Request;

interface LessonServiceInterface
{
    /**
     * Tạo mới
     *
     * @var Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request);
    /**
     * Cập nhật
     *
     * @var Illuminate\Http\Request $request
     *
     * @return boolean
     */
    public function update(Request $request);

    /**
     * Cập nhật ngày học bù
     *
     * @var Illuminate\Http\Request $request
     *
     * @return boolean
     */
    public function updateMakeUpLesson($data);
    /**
     * Xóa
     *
     * @param int $id
     *
     * @return boolean
     */
    public function delete($id);

    /**
     * Tạo ra các khoảng thời gian
     *
     * @param string $startTime
     * @param string $endTime
     * @param int $period
     *
     * @return array
     */
    public function generateTimeIntervals($startTime, $endTime, $period);

}
