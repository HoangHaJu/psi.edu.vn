<?php

namespace App\Admin\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Auth\ForgotPasswordRequest;
use App\Admin\Http\Requests\Auth\LoginRequest;
use App\Admin\Http\Requests\Auth\RegisterRequest;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Services\Admin\AdminServiceInterface;
use App\Admin\Repositories\Post\PostRepositoryInterface;
use App\Mail\AccountActivation;
use App\Mail\Auth\ResetPassword;
use App\Models\Lesson;
use App\Models\Admin;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    private $login;

    protected $adminRepository;
    protected $adminService;
    protected $repositorySetting;
    protected $postRepository;

    public function __construct(
        AdminRepositoryInterface $adminRepository,
        AdminServiceInterface $adminService,
        AuthServiceInterface $service,
        SettingRepositoryInterface $repositorySetting,
        PostRepositoryInterface $postRepository
    ) {
        parent::__construct();
        $this->adminRepository = $adminRepository;
        $this->adminService = $adminService;
        $this->service = $service;
        $this->repositorySetting = $repositorySetting;
        $this->postRepository = $postRepository;
    }
    public function getView()
    {
        return [
            'index' => 'admin.auth.index',
            'indexUser' => 'user.auth.login',
            'login' => 'user.auth.login',
        ];
    }

    public function getRoute()
    {
        return [
            'edit' => 'admin.password.reset.edit',
        ];
    }

    public function index()
    {

        $today = Carbon::today(); // hoặc now()->toDateString() nếu bạn dùng chuỗi
        $teacherLessons = Lesson::getLessonsForTeachers();
        $teachers = Admin::role('teacher')->where('display', 1)->get();
        $todayLessons = $teacherLessons->filter(function ($lesson) use ($today) {
            return Carbon::parse($lesson->date)->isSameDay($today);
        });
        $teacherStartTimes = $todayLessons->groupBy('admin_id')->map(
            fn($lessons) =>
            $lessons->pluck('start_time')->sort()->values()->toArray()
        );
        $settings = $this->repositorySetting->getSocialMedia(1);
        $posts = $this->postRepository->getAllPostsOrderedByFeatured();
        return view(
            $this->view['index'],
            compact('teachers', 'settings', 'teacherLessons', 'teacherStartTimes', 'posts')
        );
    }
    public function indexUser()
    {
        return view($this->view['index']);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $instance = $this->service->updateTokenPassword($request)
            ->generateRouteGetPassword($this->route['edit'])
            ->getInstance();
        Mail::to($instance['admin'])->send(new ResetPassword($instance['admin'], $instance['url']));

        return back()->with('success', __('Thực hiện thành công. Vui lòng kiểm tra email của bạn để lấy lại mật khẩu.'));
    }

    public function login(LoginRequest $request)
    {
        // Lấy dữ liệu đã validate từ request
        $data = $request->validated();

        $loginField = filter_var($data['identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $loginField => $data['identifier'],
            'password' => $data['password'],
        ];

        // Nếu không, thử đăng nhập qua guard 'admin'
        if (Auth::guard('admin')->attempt($credentials, true)) {
            $request->session()->regenerate();
            return $this->handleAdminLogin();
        }

        return back()->with('error', __('Tên đăng nhập hoặc mật khẩu không đúng'));
    }



    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['token_active_account'] = random_int(1000000, 9999999);
        $data['password'] = bcrypt($data['password']);

        $role = $request->boolean('is_teacher') ? 'teacher' : 'student';

        $admin = $this->adminRepository->findByField('email', $data['email']);

        if ($admin) {
            if ($admin->is_active === 0) {
                // cho phép ghi đè nếu chưa active
                $admin->update($data);
                $admin->syncRoles([$role]); // hoặc assignRole nếu muốn giữ role cũ

                if (!empty($admin->email) && filter_var($admin->email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($admin->email)->send(new AccountActivation($admin));
                }

                return back()->with('success-register', __('Đăng ký thành công. Vui lòng kiểm tra email để kích hoạt tài khoản.'));
            } else {
                // đã active thì báo lỗi
                return back()->withErrors(['email' => __('Email này đã được sử dụng.')]);
            }
        }

        // Nếu chưa tồn tại thì tạo mới
        $response = $this->adminService->store($request, $role);

        if ($response) {
            $response->update(['token_active_account' => $data['token_active_account']]);

            if (!empty($response->email) && filter_var($response->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($response->email)->send(new AccountActivation($response));
            }

            return back()->with('success', __('Đăng ký thành công.') . ($response->email ? ' Vui lòng kiểm tra email để kích hoạt tài khoản.' : ''));
        }

        return back()->with('error', __('Đăng ký thất bại. Vui lòng thử lại.'));
    }


    protected function handleAdminLogin()
    {
        if (Auth::guard('admin')->check()) {
            if (auth('admin')->user()->is_active == 0) {
                Auth::guard('admin')->logout();
                return back()->with('error', __('Tài khoản của bạn chưa được kích hoạt'));
            }
            return redirect()->intended(route('admin.dashboard'))->with('success', __('Đăng nhập thành công'));
        }
    }

    protected function resolveAdmin()
    {
        return Auth::guard('admin')->attempt($this->login, true);
    }
}
