<?php

use Illuminate\Support\Facades\Route;
use App\Admin\Http\Controllers\Game\GamePsiController;
// Login
Route::controller(App\Admin\Http\Controllers\Auth\AuthController::class)
    ->middleware('guest:admin')
    ->prefix('/')
    ->as('auth.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/login', 'login')->name('post');
        Route::post('/register', 'register')->name('register');
        Route::post('/forgot', 'forgotPassword')->name('forgot');
    });
Route::prefix('ebook')->as('ebook.')->group(function () {
    Route::get('/dethi', function () {
        return view('admin.auth.ebook.dethi');
    })->name('dethi');

    Route::get('/main', function () {
        return view('admin.auth.ebook.ebook');
    })->name('main');

    Route::get('/ielts', function () {
        return view('admin.auth.ebook.ielts');
    })->name('ielts');

    Route::get('/sat', function () {
        return view('admin.auth.ebook.sat');
    })->name('sat');

    Route::get('/toefl', function () {
        return view('admin.auth.ebook.toefl');
    })->name('toefl');

    Route::get('/toeic', function () {
        return view('admin.auth.ebook.toeic');
    })->name('toeic');
});
Route::prefix('game-psi')->as('game_psi.')->group(function () {
    Route::view('/', 'admin.auth.game_psi.index')->name('index');
    Route::get('/game-{game}', [GamePsiController::class, 'showGame'])->name('game.show');
    Route::get('/game-{game}/unit-{unit}', [GamePsiController::class, 'showUnit'])->name('unit.show');
});


Route::group(['middleware' => 'admin.auth.admin:admin'], function () {
    Route::prefix('/posts')->as('post.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Post\PostController::class)->group(function () {

            Route::group(['middleware' => ['permission:createAdmin', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewAdmin', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateAdmin', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteAdmin', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    Route::prefix('/posts-categories')->as('post_category.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\PostCategory\PostCategoryController::class)->group(function () {
            Route::group(['middleware' => ['permission:createAdmin', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewAdmin', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateAdmin', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteAdmin', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });
    //ScheduleOff
    Route::prefix('/schedule-off')->as('schedule_off.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\ScheduleOff\ScheduleOffController::class)->group(function () {
            Route::group(['middleware' => ['permission:viewNotification', 'auth:admin']], function () {
                Route::get('/sua/{id}', 'edit')->name('edit');
            });
            Route::group(['middleware' => ['permission:updateNotification', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });
            Route::post('/them', 'store')->name('store');
            Route::get('/', 'index')->name('index');
            Route::delete('/xoa/{id}', 'delete')->name('delete');
        });
    });
    //Booking
    Route::prefix('/bookings')->as('booking.')->group(function () {

        // BookingController
        Route::controller(App\Admin\Http\Controllers\Booking\BookingController::class)->group(function () {
            Route::group(['middleware' => ['permission:createBooking', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/admin-register', 'adminRegister')->name('adminRegister');
                Route::post('/student-register', 'studentRegister')->name('studentRegister');
                Route::post('/create-with-teacher-lesson', 'createWithTeacherLesson')->name('createWithTeacherLesson');
            });

            Route::group(['middleware' => ['permission:viewBooking', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateBooking', 'auth:admin']], function () {
                Route::get('/confirm/{id?}', 'confirm')->name('confirm');
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteBooking', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });

            Route::get('/cancel/{id?}', 'cancel')->name('cancel');
        });

        // BookingApiController
        Route::controller(App\Admin\Http\Controllers\Booking\BookingApiController::class)
            ->middleware(['auth:admin'])
            ->group(function () {
                Route::get('/api/courses', 'apiCourse')->name('apiCourse');
                Route::get('/api/courses-modal', 'apiCourseModal')->name('apiCourseModal');
                Route::get('/api/teachers', 'apiTeacher')->name('apiTeacher');
                Route::get('/api/students', 'apiStudent')->name('apiStudent');
                Route::get('/api/courses/categories', 'apiCategories')->name('apiCategories');
                Route::get('/api/courses/levels', 'apiLevels')->name('apiLevels');
                Route::get('/api/lessons', 'apiLessons')->name('apiLessons');
                Route::get('/api/type-tickets', 'apiTypeTickets')->name('apiTypeTickets');
                Route::get('/api/students/{id}/ticket-options', 'apiTicketOptions')->name('apiTicketOptions');
                Route::get('/api/teachers/available-times', 'apiTeacherAvailableTimes')->name('apiTeacherAvailableTimes');
            });
    });


    //TicketStudents
    Route::prefix('/ticket-students')->as('ticket_students.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\TicketStudent\TicketStudentController::class)->group(function () {
            Route::group(['middleware' => ['permission:viewBooking', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/tickets', 'getTicketsApi')->name('getFilteredTickets');
            });
        });
    });
    Route::prefix('/student-lessons')->as('student_lesson.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\StudentLesson\StudentLessonController::class)->group(function () {
            Route::group(['middleware' => ['permission:updateStudentLesson', 'auth:admin']], function () {
                Route::get('/sua/{id}', 'edit')->name('edit');
                Route::put('/sua', 'update')->name('update');
                Route::post('/refund-ticket/{id}', 'refundTicket')->name('refund');
                Route::get('/jitsi/{teacher_id}', 'jitsi')->name('jitsi');
                Route::post('/track-join-class', 'trackJoinClass')->name('trackJoinClass');
            });
        });
    });

    Route::prefix('/teacher-lessons')->as('teacher_lesson.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\TeacherLesson\TeacherLessonController::class)->group(function () {
            Route::group(['middleware' => ['permission:viewAdmin|viewLesson', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::post('/track-join-class', 'trackJoinClass')->name('trackJoinClass');
            });

            Route::group(['middleware' => ['permission:deleteAdmin|deleteLesson', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //Transaction
    Route::prefix('/transactions')->as('transaction.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Transaction\TransactionController::class)->group(function () {
            Route::group(['middleware' => ['permission:createTransaction', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::get('/render/{id?}', 'renderModalProduct')->name('render');
                Route::post('/them', 'store')->name('store');
                Route::get('/payment/{id}', 'payment')->name('payment');
                Route::put('/payment', 'paymentUpdate')->name('paymentUpdate');
            });
            Route::group(['middleware' => ['permission:viewTransaction', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateTransaction', 'auth:admin']], function () {
                Route::get('/confirm/{id?}', 'confirm')->name('confirm');
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteTransaction', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
            Route::get('/cancel/{id?}', 'cancel')->name('cancel');
        });
    });

    //Lesson
    Route::prefix('/lessons')->as('lesson.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Lesson\LessonController::class)->group(function () {
            Route::group(['middleware' => ['permission:viewLesson', 'auth:admin']], function () {
                Route::get('/course/{id}', 'index')->name('index');
                Route::get('/sua/{id?}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateLesson', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
                Route::post('/huy', 'cancel')->name('cancel');
            });

            Route::group(['middleware' => ['permission:deleteLesson', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });

            Route::group(['middleware' => ['permission:createLesson', 'auth:admin']], function () {
                Route::get('/them/{id}', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
        });
    });


    //Notification
    Route::prefix('/notifications')->as('notification.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Notification\NotificationController::class)->group(function () {
            Route::group(['middleware' => ['permission:createNotification', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewNotification', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/admin', 'getAllNotificationAdmin')->name('getAllNotificationAdmin');
                Route::get('/read-all', 'readAllNotification')->name('readAllNotification');
                Route::get('/sua/{id}', 'edit')->name('edit');
                Route::get('/chi-tiet/{id}', 'show')->name('show');
            });

            Route::group(['middleware' => ['permission:updateNotification', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteNotification', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //Ticket
    Route::prefix('/tickets')->as('ticket.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Ticket\TicketController::class)->group(function () {
            Route::group(['middleware' => ['permission:createTicket', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
                Route::get('/giahan', 'extend')->name('extend');
                Route::post('/giahan', 'extendStore')->name('extendStore');
            });
            Route::group(['middleware' => ['permission:viewTicket', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });
            Route::get('/chi-tiet/{id?}', 'detail')->name('detail');

            Route::group(['middleware' => ['permission:updateTicket', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteTicket', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    // Excel
    Route::controller(App\Admin\Http\Controllers\Excel\ExcelController::class)
        ->prefix('/excel')
        ->as('excel.')
        ->group(function () {
            Route::get('/export', 'export')->name('export');
            Route::post('/import', 'import')->name('import');
        });
    //Review
    Route::controller(App\Admin\Http\Controllers\Review\ReviewController::class)
        ->prefix('/reviews')
        ->as('review.')
        ->group(function () {
            Route::get('/export', 'export')->name('export');
            Route::group(['middleware' => ['permission:createReview', 'auth:admin']], function () {
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewReview', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
            });
        });

    //admin
    Route::prefix('/admins')->as('admin.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Admin\AdminController::class)->group(function () {
            Route::group(['middleware' => ['permission:createAdmin', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewAdmin', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateAdmin', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteAdmin', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
            Route::get('/schedule', 'schedule')->name('schedule');
        });
    });

    //student
    Route::prefix('/students')->as('student.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Student\StudentController::class)->group(function () {
            Route::group(['middleware' => ['permission:createAdmin', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewAdmin', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
                Route::get('/export', 'export')->name('export');
                Route::post('/import', 'import')->name('import');
            });
            Route::group(['middleware' => ['permission:updateAdmin', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteAdmin', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //teacher
    Route::prefix('/teachers')->as('teacher.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Teacher\TeacherController::class)->group(function () {
            Route::group(['middleware' => ['permission:createAdmin', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewAdmin', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateAdmin', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteAdmin', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });
    //role
    Route::prefix('/role')->as('role.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Role\RoleController::class)->group(function () {

            Route::group(['middleware' => ['permission:createRole', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewRole', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateRole', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteRole', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    Route::controller(App\Admin\Http\Controllers\Setting\SettingController::class)
        ->prefix('/settings')
        ->as('setting.')
        ->group(function () {
            Route::group(['middleware' => ['permission:settingGeneral', 'auth:admin']], function () {
                Route::get('/general', 'general')->name('general');
                Route::get('/footer', 'footer')->name('footer');
                Route::get('/contact', 'contact')->name('contact');
                Route::get('/information', 'information')->name('information');
            });
            Route::put('/update', 'update')->name('update');
        });
    //Course
    Route::prefix('/courses')->as('course.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Course\CourseController::class)->group(function () {
            Route::group(['middleware' => ['permission:createCourse', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
                Route::get('admin/teachers/{id}/lessons', 'lessons')->name('lessons');
            });
            Route::group(['middleware' => ['permission:viewCourse', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/review/{id}', 'showReview')->name('showReview');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateCourse', 'auth:admin']], function () {
                Route::get('/register-lessons/{id}', 'registerLessons')->name('registerLessons');
                Route::post('/register-lessons', 'storeRegistedLessons')->name('storeRegistedLessons');
            });

            Route::group(['middleware' => ['permission:updateCourse', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteCourse', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
            Route::get('/detail/{id?}', 'detail')->name('detail');
        });
    });

    //Category
    Route::prefix('/categories')->as('category.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Category\CategoryController::class)->group(function () {
            Route::group(['middleware' => ['permission:createCategory', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewCategory', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateCategory', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteCategory', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //ckfinder
    Route::prefix('/quan-ly-file')->as('ckfinder.')->group(function () {
        Route::any('/ket-noi', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
            ->name('connector');
        Route::any('/duyet', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
            ->name('browser');
    });

    Route::controller(App\Admin\Http\Controllers\Dashboard\DashboardController::class)->group(function () {
        Route::group(['middleware' => ['auth:admin']], function () {
            Route::get('/dashboard', 'index')->name('dashboard');
            Route::get('/notification', 'notificationsPage')->name('notificationsPage');
            Route::get('/dashboard/reset', 'resetAllStudentRemainingLeave')->name('dashboard.reset');
            Route::get('/posts/detail/{id}', 'postDetail')->name('post.detail');
            Route::get('/posts/all', 'post')->name('post.all');
            Route::put('/switch-type-ticket/{id}', 'switchTypeTicket')->name('dashboard.switch');
        });
    });

    //auth
    Route::controller(App\Admin\Http\Controllers\Auth\ProfileController::class)
        ->prefix('/profile')
        ->as('profile.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });
    //Course Lookup

    Route::prefix('/course-lookup')->as('course.lookup.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\CourseLookup\CourseLookupController::class)->group(function () {
            Route::group(['middleware' => ['auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/detail/{id}', 'detail')->name('detail');
                Route::get('/getCourses/{id}', 'getCourses')->name('getCourses');
            });
        });
    });

    Route::controller(App\Admin\Http\Controllers\Auth\ChangePasswordController::class)
        ->prefix('/password')
        ->as('password.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });
    Route::prefix('/search')->as('search.')->group(function () {
        Route::prefix('/select')->as('select.')->group(function () {
            // Route::get('/user', [App\Admin\Http\Controllers\User\UserSearchSelectController::class, 'selectSearch'])->name('user');
            Route::get('/admin', [App\Admin\Http\Controllers\Admin\AdminSearchSelectController::class, 'selectSearch'])->name('admin');
            Route::get('/teacher', [App\Admin\Http\Controllers\Teacher\TeacherSearchSelectController::class, 'selectSearch'])->name('teacher');
        });
    });

    Route::post('/logout', [App\Admin\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');
});

Route::controller(App\Http\Controllers\Auth\ActiveAccountController::class)
    ->prefix('/activate-account')
    ->as('activation.')
    ->group(function () {
        Route::get('/', 'index')->name('index')->middleware('signed');
    });

Route::controller(App\Http\Controllers\Auth\ResetPasswordController::class)
    ->prefix('/reset-password')
    ->as('password.reset.')
    ->group(function () {
        Route::get('/edit', 'edit')->name('edit');
        Route::get('/success', 'success')->name('success');
        Route::put('/update', 'update')->name('update');
    });
