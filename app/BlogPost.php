<?php

namespace App;

use App\Domain\ValueObject\Enums\BlogPostSource;
use Database\Factories\Domain\Entity\BlogPostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BlogPost extends Model
{
    /** @use HasFactory<BlogPostFactory> */
    use HasFactory, Notifiable;

    private int $id;

    private string $title;

    private ?string $description = null;

    private BlogPostSource $source;

    private bool $isPublished;

    protected $fillable = [
        'title',
        'description',
        'source',
        'isPublished'
    ];

    protected $casts = [
        'source' => BlogPostSource::class,
    ];

    public function toElasticsearchDocumentArray(): array
    {
        return $this->toArray();
    }

    public function getSearchableFields(): array
    {
        return [
            'title',
            'description',
        ];
    }
}
