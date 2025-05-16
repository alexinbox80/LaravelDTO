<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Enums\BlogPostSource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BlogPost extends Model
{
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
}
