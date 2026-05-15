<?php

namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected array $services = [
        'App\Admin\Services\Module\ModuleServiceInterface' => 'App\Admin\Services\Module\ModuleService',
        'App\Admin\Services\Permission\PermissionServiceInterface' => 'App\Admin\Services\Permission\PermissionService',
        'App\Admin\Services\Role\RoleServiceInterface' => 'App\Admin\Services\Role\RoleService',
        'App\Admin\Services\Admin\AdminServiceInterface' => 'App\Admin\Services\Admin\AdminService',
        'App\Admin\Services\Slider\SliderServiceInterface' => 'App\Admin\Services\Slider\SliderService',
        'App\Admin\Services\Slider\SliderItemServiceInterface' => 'App\Admin\Services\Slider\SliderItemService',
        'App\Admin\Services\Post\PostServiceInterface' => 'App\Admin\Services\Post\PostService',
        'App\Admin\Services\PostCategory\PostCategoryServiceInterface' => 'App\Admin\Services\PostCategory\PostCategoryService',
        'App\Admin\Services\Notification\NotificationServiceInterface' => 'App\Admin\Services\Notification\NotificationService',

        'App\Admin\Services\Review\ReviewServiceInterface' => 'App\Admin\Services\Review\ReviewService',
        'App\Admin\Services\Course\CourseServiceInterface' => 'App\Admin\Services\Course\CourseService',
        'App\Admin\Services\Category\CategoryServiceInterface' => 'App\Admin\Services\Category\CategoryService',
        'App\Admin\Services\Booking\BookingServiceInterface' => 'App\Admin\Services\Booking\BookingService',
        'App\Admin\Services\Lesson\LessonServiceInterface' => 'App\Admin\Services\Lesson\LessonService',
        'App\Admin\Services\ScheduleOff\ScheduleOffServiceInterface' => 'App\Admin\Services\ScheduleOff\ScheduleOffService',
        'App\Admin\Services\Ticket\TicketServiceInterface' => 'App\Admin\Services\Ticket\TicketService',
        'App\Admin\Services\TicketStudent\TicketStudentServiceInterface' => 'App\Admin\Services\TicketStudent\TicketStudentService',
        'App\Admin\Services\TeacherLesson\TeacherLessonServiceInterface' => 'App\Admin\Services\TeacherLesson\TeacherLessonService',
        'App\Admin\Services\StudentLesson\StudentLessonServiceInterface' => 'App\Admin\Services\StudentLesson\StudentLessonService',
        'App\Admin\Services\Transaction\TransactionServiceInterface' => 'App\Admin\Services\Transaction\TransactionService',

    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
        foreach ($this->services as $interface => $implement) {
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
