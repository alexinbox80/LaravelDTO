<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function find(int $id): ?BlogPost
    {
        return parent::find($id);
    }

    public function create(array $attributes): BlogPost
    {
        return parent::create($attributes);
    }

    public function patch(int $blogPostId, array $blogPostDetails): BlogPost
    {
        $blogPost = $this->find($blogPostId);

        if ($blogPost)
            $this->update($blogPost, $blogPostDetails);
        else
            throw new NotFoundHttpException(sprintf('The class %s does not exist.', $blogPostId));

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
