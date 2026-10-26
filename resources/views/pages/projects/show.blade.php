@extends('layouts.app')

@section('title', $project->title . ' — ' . ($portfolio['name'] ?? 'Humberto'))
@section('meta_description', $project->summary)

@section('content')
    <div style="margin-bottom: 1.25rem; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 0.75rem;">
        <a href="{{ route('projects.index') }}" class="brutal-btn brutal-btn--sm brutal-btn--white">
            ← BACK TO ALL PROJECTS
        </a>

        @if (session('is_portfolio_admin'))
            <a href="{{ route('admin.projects.edit', $project) }}" class="brutal-btn brutal-btn--sm brutal-btn--pink">
                ✎ EDIT PROJECT IN ADMIN
            </a>
        @endif
    </div>

    <!-- Project Hero Header -->
    <div class="page-header bg-{{ $project->color ?? 'yellow' }}">
        <div style="max-width: 72ch;">
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.85rem;">
                <span class="tile-index">{{ $project->year ?? '2026' }}</span>
                <span class="tile-index">{{ $project->role ?? 'Full-Stack Developer' }}</span>
                @if ($project->is_featured)
                    <span class="tile-index bg-pink">★ FEATURED</span>
                @endif
            </div>
            <h1 class="display-lg">{{ $project->title }}</h1>
            <p style="margin-top: 0.65rem; font-size: 1.12rem; font-weight: 500;">
                {{ $project->summary }}
            </p>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
            @if (!empty($project->live_url))
                <a
                    href="{{ $project->live_url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="brutal-btn brutal-btn--cyan"
                >
                    LAUNCH LIVE DEMO ↗
                </a>
            @endif
            @if (!empty($project->repo_url))
                <a
                    href="{{ $project->repo_url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="brutal-btn brutal-btn--white"
                >
                    VIEW SOURCE CODE ↗
                </a>
            @endif
        </div>
    </div>

    @if (!empty($project->image_url))
        <div class="brutal-card bg-white" style="padding: 0; overflow: hidden; margin-bottom: 1.75rem;">
            <img
                src="{{ $project->image_url }}"
                alt="{{ $project->title }} preview"
                style="width: 100%; max-height: 520px; object-fit: cover;"
            >
        </div>
    @endif

    <!-- Detail Content + Sidebar -->
    <div class="project-detail-grid">
        <article class="brutal-card bg-white prose-brutal">
            <div>
                <div class="tile-header">
                    <span class="tile-index bg-yellow">OVERVIEW &amp; ARCHITECTURE</span>
                </div>

                @foreach (preg_split('/\R{2,}/', trim($project->description)) as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
        </article>

        <aside class="brutal-card bg-cream">
            <div>
                <div class="tile-header">
                    <span class="tile-index">TECH STACK &amp; LINKS</span>
                </div>

                <h2 class="display-md" style="margin-bottom: 0.75rem;">BUILT WITH</h2>
                <div class="tag-list" style="margin-bottom: 1.5rem;">
                    @foreach ($project->tagsList() as $tag)
                        <a href="{{ route('projects.index', ['tag' => $tag]) }}" class="brutal-tag">
                            {{ $tag }}
                        </a>
                    @endforeach
                </div>

                <h3 class="mono-label" style="margin-bottom: 0.65rem;">PROJECT LINKS</h3>
                <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                    @if (!empty($project->live_url))
                        <a
                            href="{{ $project->live_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="brutal-btn brutal-btn--cyan brutal-btn--block"
                        >
                            LIVE APPLICATION ↗
                        </a>
                    @endif
                    @if (!empty($project->repo_url))
                        <a
                            href="{{ $project->repo_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="brutal-btn brutal-btn--white brutal-btn--block"
                        >
                            GITHUB REPOSITORY ↗
                        </a>
                    @endif
                    <a href="{{ route('contact.show') }}" class="brutal-btn brutal-btn--pink brutal-btn--block">
                        ASK ABOUT THIS PROJECT →
                    </a>
                </div>
            </div>
        </aside>
    </div>

    <!-- Related Projects -->
    @if ($relatedProjects->isNotEmpty())
        <section style="margin-top: 2.5rem;">
            <h2 class="display-md" style="margin-bottom: 1rem;">MORE PROJECTS</h2>
            <div class="projects-grid">
                @foreach ($relatedProjects as $related)
                    <article class="brutal-card bg-{{ $related->color ?? 'yellow' }}">
                        <div>
                            <div class="tile-header">
                                <span class="tile-index">{{ $related->year ?? '2026' }}</span>
                                <span class="mono-label">{{ $related->role ?? '' }}</span>
                            </div>
                            <h3 class="display-md" style="margin-bottom: 0.5rem;">{{ $related->title }}</h3>
                            <p style="margin-bottom: 1rem;">{{ $related->summary }}</p>
                        </div>
                        <a href="{{ route('projects.show', $related) }}" class="brutal-btn brutal-btn--white">
                            INSPECT PROJECT →
                        </a>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection

