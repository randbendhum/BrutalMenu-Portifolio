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
        $projects = [
            [
                'title' => 'BrutalMenu // Self-Hosted Portfolio OS',
                'slug' => 'brutalmenu-portfolio-os',
                'summary' => 'Neobrutalist portfolio hub & CMS built with PHP 8.3, Laravel 11, MySQL 8, pure CSS Grid/Flexbox, and Docker on Oracle Cloud ARM64.',
                'description' => "BrutalMenu is the interactive main menu and project hub you are browsing right now.\n\nDesigned from scratch using pure CSS Grid and Flexbox (zero CSS framework bloat), it features a tactile Bento-grid command center, custom neobrutalist design tokens, a built-in admin panel for live project publishing, and a multi-architecture Docker stack running on an Oracle Cloud Ampere A1 ARM64 server.",
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
            [
                'title' => 'PulseBoard // Real-Time Telemetry & Analytics',
                'slug' => 'pulseboard-realtime-telemetry',
                'summary' => 'High-contrast metrics dashboard tracking API latency, uptime checks, and webhook events with sub-second updates.',
                'description' => "PulseBoard is a lightweight observability and uptime monitoring web application engineered for indie developers and small teams.\n\nIt aggregates HTTP health checks, queue worker metrics, and webhook deliveries into a responsive CSS Grid dashboard backed by optimized MySQL indexing and background job workers.",
                'tags' => ['Laravel 11', 'JavaScript', 'MySQL', 'REST API', 'Flexbox'],
                'color' => 'cyan',
                'role' => 'Full-Stack Developer',
                'year' => '2026',
                'image_url' => null,
                'repo_url' => 'https://github.com/yourusername/pulseboard',
                'live_url' => 'https://example.com',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'CartCraft // Headless Commerce Engine',
                'slug' => 'cartcraft-headless-commerce',
                'summary' => 'Fast e-commerce storefront and checkout API featuring instant filtering, inventory locking, and webhook payment flows.',
                'description' => "CartCraft combines a snappy front-end catalog experience with a transactional Laravel backend.\n\nBuilt to handle flash sales without race conditions, it uses database row-level locking for stock reservation, idempotent webhook processing, and a bold, accessible checkout interface.",
                'tags' => ['PHP 8.3', 'Laravel', 'MySQL', 'CSS Grid', 'Stripe API'],
                'color' => 'pink',
                'role' => 'Full-Stack & UI Engineer',
                'year' => '2025',
                'image_url' => null,
                'repo_url' => 'https://github.com/yourusername/cartcraft',
                'live_url' => 'https://example.com',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'DockFlow // ARM64 Deployment Toolkit',
                'slug' => 'dockflow-arm64-toolkit',
                'summary' => 'Automated zero-config Docker Compose templates and firewall scripts for deploying web apps on Oracle Cloud ARM VMs.',
                'description' => "DockFlow streamlines self-hosting on ARM64 Linux instances.\n\nIt bundles hardened Nginx + PHP-FPM + MySQL 8 + Caddy HTTPS configurations with automated health checks, backup routines, and firewall provisioning.",
                'tags' => ['Docker', 'Linux ARM64', 'Nginx', 'Caddy', 'Bash'],
                'color' => 'white',
                'role' => 'DevOps & Backend',
                'year' => '2025',
                'image_url' => null,
                'repo_url' => 'https://github.com/yourusername/dockflow',
                'live_url' => null,
                'is_featured' => false,
                'sort_order' => 4,
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

