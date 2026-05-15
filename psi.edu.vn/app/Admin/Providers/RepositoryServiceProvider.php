<?php

namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'App\Admin\Repositories\Module\ModuleRepositoryInterface' => 'App\Admin\Repositories\Module\ModuleRepository',
        'App\Admin\Repositories\Permission\PermissionRepositoryInterface' => 'App\Admin\Repositories\Permission\PermissionRepository',
        'App\Admin\Repositories\Role\RoleRepositoryInterface' => 'App\Admin\Repositories\Role\RoleRepository',
        'App\Admin\Repositories\Admin\AdminRepositoryInterface' => 'App\Admin\Repositories\Admin\AdminRepository',
        'App\Admin\Repositories\Category\CategoryRepositoryInterface' => 'App\Admin\Repositories\Category\CategoryRepository',
        'App\Admin\Repositories\Slider\SliderRepositoryInterface' => 'App\Admin\Repositories\Slider\SliderRepository',
        'App\Admin\Repositories\Slider\SliderItemRepositoryInterface' => 'App\Admin\Repositories\Slider\SliderItemRepository',
        'App\Admin\Repositories\Setting\SettingRepositoryInterface' => 'App\Admin\Repositories\Setting\SettingRepository',
        'App\Admin\Repositories\Post\PostRepositoryInterface' => 'App\Admin\Repositories\Post\PostRepository',
        'App\Admin\Repositories\PostCategory\PostCategoryRepositoryInterface' => 'App\Admin\Repositories\PostCategory\PostCategoryRepository',
        'App\Admin\Repositories\Review\ReviewRepositoryInterface' => 'App\Admin\Repositories\Review\ReviewRepository',
        'App\Admin\Repositories\Icon\IconRepositoryInterface' => 'App\Admin\Repositories\Icon\IconRepository',
        'App\Admin\Repositories\Notification\NotificationRepositoryInterface' => 'App\Admin\Repositories\Notification\NotificationRepository',
        'App\Admin\Repositories\Course\CourseRepositoryInterface' => 'App\Admin\Repositories\Course\CourseRepository',
        'App\Admin\Repositories\Lesson\LessonRepositoryInterface' => 'App\Admin\Repositories\Lesson\LessonRepository',
        'App\Admin\Repositories\Booking\BookingRepositoryInterface' => 'App\Admin\Repositories\Booking\BookingRepository',
        'App\Admin\Repositories\ScheduleOff\ScheduleOffRepositoryInterface' => 'App\Admin\Repositories\ScheduleOff\ScheduleOffRepository',
        'App\Admin\Repositories\Ticket\TicketRepositoryInterface' => 'App\Admin\Repositories\Ticket\TicketRepository',
        'App\Admin\Repositories\TicketStudent\TicketStudentRepositoryInterface' => 'App\Admin\Repositories\TicketStudent\TicketStudentRepository',
        'App\Admin\Repositories\Transaction\TransactionRepositoryInterface' => 'App\Admin\Repositories\Transaction\TransactionRepository',
        'App\Admin\Repositories\StudentLesson\StudentLessonRepositoryInterface' => 'App\Admin\Repositories\StudentLesson\StudentLessonRepository',
        'App\Admin\Repositories\TeacherLesson\TeacherLessonRepositoryInterface' => 'App\Admin\Repositories\TeacherLesson\TeacherLessonRepository',
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        foreach ($this->repositories as $interface => $implement) {
            $this->app->singleton($interface, $implement);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
