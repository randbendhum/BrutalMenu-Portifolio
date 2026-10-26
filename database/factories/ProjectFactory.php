<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title),
            'summary' => $this->faker->sentence(12),
            'description' => implode("\n\n", $this->faker->paragraphs(3)),
            'tags' => ['Laravel 11', 'PHP 8.3', 'MySQL', 'CSS Grid'],
            'color' => $this->faker->randomElement(['yellow', 'pink', 'cyan', 'white']),
            'role' => 'Full-Stack Developer',
            'year' => '2026',
            'image_url' => null,
            'repo_url' => 'https://github.com/yourusername/sample-project',
            'live_url' => 'https://example.com',
            'is_featured' => true,
            'sort_order' => 1,
        ];
    }
}

