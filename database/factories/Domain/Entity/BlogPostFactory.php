<?php

namespace Database\Factories\Domain\Entity;

use App\Domain\ValueObject\Enums\BlogPostSource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Entity\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->text(rand(200, 300)),
            'source' => (bool)rand(0, 1) ? BlogPostSource::App : BlogPostSource::Api,
            'isPublished' => (bool)rand(0, 1) ? true : false,
        ];
    }
}
