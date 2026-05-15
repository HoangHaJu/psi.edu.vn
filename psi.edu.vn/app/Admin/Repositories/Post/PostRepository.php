<?php

namespace App\Admin\Repositories\Post;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Post\PostRepositoryInterface;
use App\Models\Post;

class PostRepository extends EloquentRepository implements PostRepositoryInterface
{

    protected $select = [];

    public function getModel()
    {
        return Post::class;
    }
    public function findOrFailWithRelations($id, array $relations = ['categories'])
    {
        $this->findOrFail($id);
        $this->instance = $this->instance->load($relations);
        return $this->instance;
    }

    public function attachCategories(Post $post, array $categoriesId)
    {
        return $post->categories()->attach($categoriesId);
    }

    public function syncCategories(Post $post, array $categoriesId)
    {
        return $post->categories()->sync($categoriesId);
    }

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC')
    {
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    public function getLatestPosts($limit = 3)
    {
        $this->getQueryBuilderOrderBy('created_at', 'DESC');

        $this->instance = $this->instance->limit($limit);

        return $this->instance->get();
    }

    public function getAllPostsOrderedByFeatured()
    {
        return $this->model
            ->orderByDesc('is_featured') // Sắp xếp giảm dần theo cột nổi bật (true/1 sẽ lên trước)
            ->orderBy('created_at', 'DESC') // Sau đó sắp xếp theo ngày tạo hoặc một cột khác nếu cần
            ->get();
    }
}
