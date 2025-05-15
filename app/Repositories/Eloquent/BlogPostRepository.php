<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Collection;

class BlogPostRepository extends BaseRepository
{
    protected function getModelName(): string
    {
        return BlogPost::class;
    }

    public function getPaginated(int $perPage): array
    {
        return [
            'data' => BlogPost::query()->latest('created_at')->paginate($perPage)
        ];
    }

    public function getAll(): array
    {
        return [
            'data' => BlogPost::all()->sortByDesc('created_at')
        ];
    }

    public function getById(int $blogPostId): BlogPost
    {
        return BlogPost::findOrFail($blogPostId);
    }

    public function create(array $attributes): BlogPost
    {
        return BlogPost::create($attributes);
    }

    public function patch(int $blogPostId, array $blogPostDetails): BlogPost
    {
        $blogPost = $this->getById($blogPostId);
        $this->update($blogPost, $blogPostDetails);

        return $blogPost;
    }

    public function getIsPublished(): Collection
    {
        return BlogPost::where('is_published', true);
    }

    public function destroy(array|Collection $ids): int
    {
        return BlogPost::destroy($ids);
    }
}
