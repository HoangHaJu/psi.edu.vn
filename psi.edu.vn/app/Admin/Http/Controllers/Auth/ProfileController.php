<?php

namespace App\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Admin\Http\Requests\Auth\ProfileRequest;
use App\Admin\Services\File\FileService;
use App\Enums\Admin\EducationLevel;
use App\Enums\User\Gender;

class ProfileController extends Controller
{
    protected FileService $fileService;

    public function __construct(
        FileService $fileService
    ) {
        parent::__construct();
        $this->fileService = $fileService;
    }
    public function getView()
    {
        return [
            'index' => 'admin.auth.profile.index',

        ];
    }
    public function index()
    {

        $auth = auth('admin')->user();
        return view($this->view['index'], [
            'auth' => $auth,
            'gender' => Gender::asSelectArray(),
            'educationLevel' => EducationLevel::asSelectArray()
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $data = $request->validated();

        if (isset($data['avatar'])) {
            $data['avatar'] = $this->fileService->uploadAvatar('images', $data['avatar'], null);
        }
        $audioFile = $request->file('audio');
        if ($audioFile) {
            $this->fileService->uploadAudio($audioFile);
            $data['audio'] = $this->fileService->getInstance();
        }
        auth('admin')->user()->update($data);
        return back()->with('success', __('notifySuccess'));
    }
}
