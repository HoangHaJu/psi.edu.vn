<?php

namespace App\Views;

use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\View\Component;
use App\Admin\Traits\GetConfig;

use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\Setting\SettingGroup;

class Footer extends Component
{
    use GetConfig;

    protected CategoryRepositoryInterface $categoryRepository;
    protected SettingRepositoryInterface $settingRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, SettingRepositoryInterface $settingRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->settingRepository = $settingRepository;
    }

    public function render()
    {
        $parentCategories = $this->categoryRepository->getParentCategory();
        $settingsFooter = $this->settingRepository->getByGroup([SettingGroup::Footer]);
        return view('components.layouts.footer', compact('parentCategories', 'settingsFooter'));
    }
}
