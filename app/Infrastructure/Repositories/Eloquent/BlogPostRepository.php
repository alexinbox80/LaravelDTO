<?php

namespace App\Infrastructure\Repositories\Eloquent;

use App\Domain\Entity\BlogPost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogPostRepository extends BaseRepository
{
    protected function getModelName(): string
    {
        return BlogPost::class;
    }

    public function getPaginated(int $perPage): LengthAwarePaginator
    {
        return $this->findBy(['isPublished' => true], [], true , $perPage);
    }

    public function getAll(): Collection
    {
        return $this->findBy(['isPublished' => true], [], false , 0);
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
