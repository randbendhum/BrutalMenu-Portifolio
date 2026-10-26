@extends('layouts.app')

@section('title', ($portfolio['name'] ?? 'Humberto') . ' — Full-Stack & Front-End Portfolio')

@section('content')
    <section class="bento-grid" aria-label="Portfolio Main Menu">

        <!-- ==================================================================
             HERO TILE (Pink, 8 columns)
             ================================================================== -->
        <article class="brutal-card bg-pink tile-hero">
            <div>
                <div class="tile-header">
                    @if (!empty($portfolio['available']))
                        <div class="status-pill">
                            <span class="status-dot" aria-hidden="true"></span>
                            <span>{{ $portfolio['availability_text'] ?? 'AVAILABLE FOR WORK' }}</span>
                        </div>
                    @endif
                    <span class="tile-index">MAIN MENU // v1.0</span>
                </div>

                <h1 class="display-xl" style="margin-top: 0.75rem;">
                    HI, I'M {{ strtoupper($portfolio['name'] ?? 'HUMBERTO') }}.
                </h1>

                <p class="display-md" style="margin-top: 0.65rem; background: var(--accent-yellow); display: inline-block; padding: 0.2rem 0.65rem; border: 2.5px solid var(--ink); box-shadow: 3px 3px 0 var(--ink);">
                    {{ $portfolio['role'] ?? 'Full-Stack & Front-End Developer' }}
                </p>

                <p style="margin-top: 1.15rem; font-size: 1.1rem; max-width: 62ch; font-weight: 500;">
                    {{ $portfolio['tagline'] ?? '' }}
                </p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('projects.index') }}" class="brutal-btn brutal-btn--lg">
                    02 // EXPLORE PROJECTS ({{ $totalProjects }}) →
                </a>
                <a href="{{ route('contact.show') }}" class="brutal-btn brutal-btn--lg brutal-btn--cyan">
                    03 // START A CONVERSATION →
                </a>
                <a href="{{ route('about') }}" class="brutal-btn brutal-btn--lg brutal-btn--white">
                    01 // ABOUT ME
                </a>
            </div>
        </article>

        <!-- ==================================================================
             AVATAR & QUICK SHORTCUTS TILE (Yellow, 4 columns)
             ================================================================== -->
        <aside class="brutal-card bg-yellow tile-avatar">
            <div class="tile-header">
                <span class="tile-index">PROFILE // ID</span>
                <span class="mono-label">{{ $portfolio['location'] ?? 'Remote' }}</span>
            </div>

            <div class="avatar-stage">
                <div class="avatar-box">
                    @if (!empty($portfolio['avatar_url']))
                        <img src="{{ $portfolio['avatar_url'] }}" alt="{{ $portfolio['name'] ?? 'Developer' }} avatar">
                    @else
                        <div class="avatar-monogram" aria-hidden="true">
                            {{ strtoupper(substr($portfolio['name'] ?? 'H', 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div>
                    <p class="mono-label" style="margin-bottom: 0.35rem;">KEYBOARD NAVIGATION</p>
                    <div class="shortcut-bar">
                        <a href="{{ route('about') }}" class="kbd-chip">[1] ABOUT</a>
                        <a href="{{ route('projects.index') }}" class="kbd-chip">[2] PROJECTS</a>
                        <a href="{{ route('contact.show') }}" class="kbd-chip">[3] CONTACT</a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ==================================================================
             01 // ABOUT ME TILE (Cyan, 4 columns)
             ================================================================== -->
        <article class="brutal-card brutal-card--interactive bg-cyan tile-about" data-href="{{ route('about') }}">
            <div>
                <div class="tile-header">
                    <span class="tile-index">01 // ABOUT ME</span>
                    <a href="{{ route('about') }}" class="tile-arrow" aria-label="Go to About Me">↗</a>
                </div>

                <h2 class="display-md" style="margin-bottom: 0.75rem;">
                    WHO I AM &amp; HOW I ENGINEER SOFTWARE
                </h2>

                <p style="font-size: 0.98rem; margin-bottom: 1.15rem;">
                    {{ $portfolio['about']['intro'] ?? '' }}
                </p>
            </div>

            <div>
                <div class="tag-list" style="margin-bottom: 1.15rem;">
                    <span class="brutal-tag">PHP 8.3</span>
                    <span class="brutal-tag">LARAVEL 11</span>
                    <span class="brutal-tag">CSS GRID</span>
                    <span class="brutal-tag">MYSQL 8</span>
                    <span class="brutal-tag">DOCKER</span>
                </div>

                <a href="{{ route('about') }}" class="brutal-btn brutal-btn--white brutal-btn--block">
                    OPEN BIO &amp; FULL STACK →
                </a>
            </div>
        </article>

        <!-- ==================================================================
             02 // PROJECTS TILE (White/Yellow Accent, 8 columns)
             ================================================================== -->
        <article class="brutal-card brutal-card--interactive bg-white tile-projects" data-href="{{ route('projects.index') }}">
            <div>
                <div class="tile-header">
                    <span class="tile-index" style="background: var(--accent-yellow);">02 // PROJECTS ({{ $totalProjects }})</span>
                    <a href="{{ route('projects.index') }}" class="tile-arrow" aria-label="Go to Projects">↗</a>
                </div>

                <div style="display: flex; flex-wrap: wrap; align-items: baseline; justify-content: space-between; gap: 0.5rem;">
                    <h2 class="display-md">SELECTED BUILDS &amp; CASE STUDIES</h2>
                    <span class="mono-label">CLICK ANY PROJECT TO INSPECT</span>
                </div>

                @if ($featuredProjects->isNotEmpty())
                    <div class="featured-mini-list">
                        @foreach ($featuredProjects as $project)
                            <a href="{{ route('projects.show', $project) }}" class="featured-mini-item">
                                <div>
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; margin-bottom: 0.45rem;">
                                        <span class="brutal-tag bg-{{ $project->color ?? 'yellow' }}">
                                            {{ $project->year ?? '2026' }}
                                        </span>
                                        <span class="mono-label">VIEW →</span>
                                    </div>
                                    <h3 style="font-size: 1.05rem; margin-bottom: 0.35rem;">
                                        {{ $project->title }}
                                    </h3>
                                    <p style="font-size: 0.86rem; color: var(--ink-muted);">
                                        {{ \Illuminate\Support\Str::limit($project->summary, 90) }}
                                    </p>
                                </div>

                                <div class="tag-list">
                                    @foreach (array_slice($project->tagsList(), 0, 3) as $tag)
                                        <span class="brutal-tag" style="font-size: 0.68rem; padding: 0.15rem 0.45rem;">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 1.25rem; margin-top: 1rem; border: var(--border); background: var(--bg-cream);">
                        <p class="mono-label">No projects seeded yet — add your first project in <a href="{{ route('admin.dashboard') }}" style="text-decoration: underline;">/admin</a>!</p>
                    </div>
                @endif
            </div>

            <div style="margin-top: 1.25rem; display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: space-between; align-items: center;">
                <a href="{{ route('projects.index') }}" class="brutal-btn brutal-btn--yellow">
                    BROWSE ALL {{ $totalProjects }} PROJECTS →
                </a>
                <a href="{{ route('admin.projects.create') }}" class="brutal-btn brutal-btn--sm brutal-btn--white">
                    + ADD PROJECT IN ADMIN
                </a>
            </div>
        </article>

        <!-- ==================================================================
             03 // CONTACT TILE (Black w/ White Text, 7 columns)
             ================================================================== -->
        <article class="brutal-card brutal-card--interactive bg-black tile-contact" data-href="{{ route('contact.show') }}">
            <div>
                <div class="tile-header">
                    <span class="tile-index" style="background: var(--accent-pink); color: var(--ink);">03 // CONTACT</span>
                    <a href="{{ route('contact.show') }}" class="tile-arrow" aria-label="Go to Contact">↗</a>
                </div>

                <h2 class="display-lg" style="margin-bottom: 0.65rem; color: var(--bg-paper);">
                    GOT A PROJECT, ROLE, OR WILD IDEA? LET'S TALK.
                </h2>

                <p style="color: #E2E2E2; font-size: 1rem; max-width: 52ch;">
                    Drop a message directly into my MySQL inbox via the contact form or reach out by email. Fast replies guaranteed.
                </p>
            </div>

            <div style="margin-top: 1.35rem; display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center;">
                <a href="{{ route('contact.show') }}" class="brutal-btn brutal-btn--lg">
                    OPEN CONTACT FORM →
                </a>
                <a href="mailto:{{ $portfolio['email'] ?? 'hello@yourdomain.com' }}" class="brutal-btn brutal-btn--white">
                    {{ $portfolio['email'] ?? 'hello@yourdomain.com' }}
                </a>
            </div>
        </article>

        <!-- ==================================================================
             04 // LINKS & INFRASTRUCTURE TILE (Mint/White, 5 columns)
             ================================================================== -->
        <aside class="brutal-card bg-mint tile-socials">
            <div>
                <div class="tile-header">
                    <span class="tile-index">04 // NETWORK &amp; HOSTING</span>
                    <span class="mono-label">ARM64 READY</span>
                </div>

                <h2 class="display-md" style="margin-bottom: 0.65rem;">
                    CONNECT ELSEWHERE
                </h2>

                <div style="display: flex; flex-wrap: wrap; gap: 0.65rem; margin-bottom: 1.25rem;">
                    @foreach ($portfolio['socials'] ?? [] as $social)
                        <a
                            href="{{ $social['url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="brutal-btn brutal-btn--{{ $social['color'] ?? 'yellow' }}"
                        >
                            {{ $social['label'] }} ↗
                        </a>
                    @endforeach
                </div>
            </div>

            <div style="padding: 0.9rem 1rem; background: var(--bg-paper); border: var(--border); box-shadow: var(--shadow-xs);">
                <p class="mono-label">INFRASTRUCTURE SPEC</p>
                <p style="font-size: 0.85rem; margin-top: 0.25rem;">
                    PHP 8.3 · Laravel 11 · MySQL 8 · Pure CSS Grid/Flexbox · Docker on Oracle Cloud ARM
                </p>
            </div>
        </aside>

    </section>
@endsection

