<?php

namespace App\Services\Auth;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use Illuminate\Support\Facades\URL;

class AuthService implements AuthServiceInterface
{
    use Setup;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    protected $instance;

    public function __construct(AdminRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function updatePassword(Request $request)
    {

        $this->data = $request->validated();

        $instance = $this->repository->getBy([
            'id' => $this->data['id'],
            'token_get_password' => $this->data['token']
        ])->first();

        $password = bcrypt($this->data['password']);

        return $this->updateObject($instance, [
            'password' => $password,
            'token_get_password' => null
        ]);
    }

    public function updateTokenPassword(Request $request)
    {
        $admin  = $this->repository->findByField('email', $request->input('email'));
        $this->data['token_get_password'] = $this->generateTokenGetPassword();
        $this->instance['admin'] = $this->updateObject($admin, $this->data);
        return $this;
    }

    public function generateRouteGetPassword($routeName)
    {
        $this->instance['url'] = URL::temporarySignedRoute(
            $routeName,
            now()->addMinutes(30),
            [
                'token' => $this->data['token_get_password'],
                'id' => $this->instance['admin']->id
            ]
        );
        return $this;
    }

    public function generateRouteActivateAccount($routeName)
    {
        $this->instance['url'] = URL::temporarySignedRoute(
            $routeName,
            now()->addMinutes(30), // Thời hạn liên kết, có thể điều chỉnh
            [
                'token' => $this->data['token_active_account'],
                'id' => $this->instance['admin']->id,
            ]
        );
        return $this;
    }

    public function getInstance()
    {
        return $this->instance;
    }

    public function updateObject($admin, $data)
    {
        $admin->update($data);
        return $admin;
    }
}
