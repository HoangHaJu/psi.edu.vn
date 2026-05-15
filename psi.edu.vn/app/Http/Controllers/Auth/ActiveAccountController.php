<?php

namespace App\Http\Controllers\Auth;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Models\Admin;
use Illuminate\Http\Request;

class ActiveAccountController extends Controller
{
    //
    public function __construct(
        AdminRepositoryInterface $repository,
    ) {
        parent::__construct();
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $token = $request->input('token');
        $id = $request->input('id');
        $admin = Admin::where('token_active_account', $token)
            ->where('id', $id)
            ->first();

        if (!$admin) {
            return response()->json(['message' => 'Token hoặc mã không hợp lệ.'], 404);
        }

        $admin->is_active = 1;
        $admin->token_active_account = null;
        $admin->save();

        return view('admin.auth.account.success');
    }
}
