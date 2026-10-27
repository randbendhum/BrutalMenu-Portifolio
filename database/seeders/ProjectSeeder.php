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
                'title' => 'ForgeHub // Mod Manager & XML/JSON Validator',
                'slug' => 'forgehub-mod-manager-validator',
                'summary' => 'Neo-Brutalist mod repository & manifest validator with in-memory ZIP/JAR inspection, anti-XXE/Zip-Bomb security, and line/column syntax diagnostics.',
                'description' => "ForgeHub is a Neo-Brutalist web portal built with PHP 8.3, Laravel 11, MySQL 8.4, Vanilla JS, and pure CSS3 Grid for submitting, validating structural manifests (modDesc.xml, fabric.mod.json, mcmod.info), automatically extracting metadata, and managing versioned packages for Farming Simulator (FS19/FS22/FS25) and Minecraft (Fabric & Forge).\n\nIt features a strict in-memory ZIP/JAR ArchiveInspector and SafeArchive validation pipeline that blocks Path Traversal (../), enforces entry count limits, and prevents Zip Bomb compression attacks before files are persisted.\n\nIts custom XML & JSON Parsing Engine (DOMDocument + DOMXPath with libxml internal error capture and anti-XXE entity blocking) automatically maps game version compatibility, routes packages with syntax errors into an isolated quarantine storage disk, and generates exact line/column diagnostic reports with surrounding code snippets across a full relational Eloquent schema.",
                'tags' => ['PHP 8.3', 'Laravel 11', 'MySQL 8.4', 'XML/JSON Parser', 'Security & ZIP', 'CSS3 Grid'],
                'color' => 'pink',
                'role' => 'Creator & Full-Stack Dev',
                'year' => '2026',
                'image_url' => null,
                'repo_url' => 'https://github.com/randbendhum/ForgeHub',
                'live_url' => 'https://forgehub.humbertorandon.com',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'GameSense AI // Real-Time Tactical Analysis Panel',
                'slug' => 'gamesense-ai-tactical-panel',
                'summary' => 'Real-time AI tactical analysis & gaming command panel with SHA-256 sub-10ms prompt caching, async queue workers, and pure CSS3 Grid Neo-Brutalist UI.',
                'description' => "GameSense AI is a high-contrast Neo-Brutalist / Hardcore Gaming UI web application built with PHP 8.3, Laravel 11, MySQL 8.0, and pure structured CSS3 Grid, engineered to run with an ultra-low memory footprint on Oracle Cloud infrastructure.\n\nIt integrates the Gemini AI API via Laravel's HTTP Client with automatic retry and structured JSON output, backed by a deterministic tactical fallback engine for zero-downtime resilience.\n\nTo achieve sub-10ms response times and eliminate redundant API calls, GameSense AI normalizes incoming game telemetry into a deterministic SHA-256 hash (CHAR(64) UNIQUE index in MySQL). Cache hits return instantaneously while incrementing hit counters, whereas cache misses dispatch asynchronous Laravel Database Queue jobs (HTTP 202 Accepted) with real-time frontend status polling across a relational schema (games, categories, prompts_history, and tactics_logs).",
                'tags' => ['PHP 8.3', 'Laravel 11', 'MySQL 8', 'Gemini AI API', 'CSS3 Grid', 'Queues & Caching'],
                'color' => 'cyan',
                'role' => 'Creator & Full-Stack Dev',
                'year' => '2026',
                'image_url' => null,
                'repo_url' => 'https://github.com/randbendhum/GameSense',
                'live_url' => 'https://gsense.humbertorandon.com',
                'is_featured' => true,
                'sort_order' => 2,
            ],
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
                'sort_order' => 3,
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
