<?php

namespace App\Views;

use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\View\Component;
use App\Admin\Traits\GetConfig;

use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\Setting\SettingGroup;

class Header extends Component
{
    use GetConfig;

    protected CategoryRepositoryInterface $categoryRepository;

    protected SettingRepositoryInterface $settingRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, SettingRepositoryInterface $settingRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->settingRepository = $settingRepository;
    }

    public function getCategoriesWithChildren($categories)
    {
        foreach ($categories as $category) {
            if (!$category->relationLoaded('children')) {
                $category->load('children');
            }
            $this->getCategoriesWithChildren($category->children);
        }

        return $categories;
    }

    public function render()
    {
        $categories = $this->categoryRepository->getFlatTree();
        $parentTempCategories = $this->categoryRepository->getParentCategory();
        $parentCategories = $this->getCategoriesWithChildren($parentTempCategories);
        $settingsGeneral = $this->settingRepository->getByGroup([SettingGroup::General]);
        return view('components.layouts.header', compact('categories', 'parentCategories', 'settingsGeneral'));
    }
}
