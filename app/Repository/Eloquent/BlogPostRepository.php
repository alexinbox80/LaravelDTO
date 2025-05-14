<?php

namespace App\Repository\Eloquent;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Collection;

class BlogPostRepository extends BaseRepository
{
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

    public function create(array $blogPostDetails): BlogPost
    {
        return BlogPost::create($blogPostDetails);
    }

    public function update(int $blogPostId, array $blogPostDetails): BlogPost
    {
        BlogPost::whereId($blogPostId)->update($blogPostDetails);
        return $this->getById($blogPostId);
    }

    public function getIsPublished(): Collection
    {
        return BlogPost::where('is_published', true);
    }

    public function destroy(int $blogPostId): int
    {
        return BlogPost::destroy($blogPostId);
    }
}
