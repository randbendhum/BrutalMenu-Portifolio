<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Seed initial portfolio projects.
     * You can edit these directly or manage projects live at /admin!
     */
    public function run(): void
    {
        // Remove placeholder projects if present
        Project::whereIn('slug', [
            'pulseboard-realtime-telemetry',
            'cartcraft-headless-commerce',
            'dockflow-arm64-toolkit',
        ])->delete();

        $projects = [
            [
                'title' => 'BrutalMenu // Self-Hosted Portfolio OS',
                'slug' => 'brutalmenu-portfolio-os',
                'summary' => 'Neobrutalist portfolio hub & CMS built with PHP 8.3, Laravel 11, MySQL 8, pure CSS Grid/Flexbox, and Docker on Oracle Cloud ARM64.',
                'description' => "BrutalMenu is the interactive main menu and project hub you are browsing right now.\n\nDesigned from scratch using pure CSS Grid and Flexbox (zero CSS framework bloat), it features a tactile Bento-grid command center, custom neobrutalist design tokens, a built-in admin panel for live project publishing, and a multi-architecture Docker stack running on an Oracle Cloud Ampere A1 ARM64 server with automatic HTTPS via Caddy.",
                'tags' => ['PHP 8.3', 'Laravel 11', 'MySQL 8', 'CSS Grid', 'Docker ARM64'],
                'color' => 'yellow',
                'role' => 'Creator & Full-Stack Dev',
                'year' => '2026',
                'image_url' => null,
                'repo_url' => 'https://github.com/randbendhum/BrutalMenu-Portifolio',
                'live_url' => 'https://humbertorandon.com',
                'is_featured' => true,
                'sort_order' => 1,
            ],
        ];

        foreach ($projects as $data) {
            Project::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
