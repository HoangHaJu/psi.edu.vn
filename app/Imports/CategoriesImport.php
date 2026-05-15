<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Category([
            'id'         => $row['id'] ?? null,
            '_lft'       => $row['_lft'] ?? null,
            '_rgt'       => $row['_rgt'] ?? null,
            'parent_id'  => $row['parent_id'] ?? null,
            'name'       => $row['name'] ?? 'Default Name',
            'slug'       => $row['slug'] ?? 'default-slug',
            'avatar'     => $row['avatar'] ?? null,
            'icon'       => $row['icon'] ?? null,
            'position'   => $row['position'] ?? 0,
            'is_active'  => $row['is_active'] ?? 1,
            'is_menu'    => $row['is_menu'] ?? 0,
            'created_at' => $row['created_at'] ?? now(),
            'updated_at' => $row['updated_at'] ?? now(),
        ]);
    }
}
