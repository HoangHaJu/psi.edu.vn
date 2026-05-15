<?php

namespace App\Admin\Http\Controllers\Setting;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\Setting\SettingGroup;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        SettingRepositoryInterface $repository
    ) {
        parent::__construct();
        $this->repository = $repository;
    }
    public function getView()
    {
        return [
            'general' => 'admin.settings.general',
            'footer' => 'admin.settings.footer',
            'contact' => 'admin.settings.contact',
            'intro' => 'admin.settings.intro',
            'user_shopping' => 'admin.settings.user-shopping',
        ];
    }

    public function general()
    {
        $settings = $this->repository->getByGroup([SettingGroup::General]);
        return view($this->view['general'], compact('settings'));
    }

    public function footer()
    {
        $settings = $this->repository->getByGroup([SettingGroup::Footer]);
        return view($this->view['general'], compact('settings'));
    }

    public function contact()
    {
        $settings = $this->repository->getByGroup([SettingGroup::Contact]);
        return view($this->view['general'], compact('settings'));
    }

    public function information()
    {
        $settings = $this->repository->getByGroup([SettingGroup::Information]);
        return view($this->view['general'], compact('settings'));
    }

    public function userShopping()
    {
        $setting_groups = $this->repository->getByGroup([SettingGroup::UserDiscount, SettingGroup::UserUpgrade])
            ->groupBy('group');
        return view($this->view['user_shopping'], compact('setting_groups'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method');
        $this->repository->updateMultipleRecord($data);
        return back()->with('success', __('notifySuccess'));
    }
}