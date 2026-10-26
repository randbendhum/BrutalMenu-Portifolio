@extends('layouts.app')

@section('title', '02 // Projects — ' . ($portfolio['name'] ?? 'Humberto'))

@section('content')
    <!-- Page Header -->
    <div class="page-header bg-yellow">
        <div>
            <span class="tile-index" style="margin-bottom: 0.75rem;">02 // PROJECTS ARCHIVE</span>
            <h1 class="display-lg">SELECTED WORK &amp; BUILDS</h1>
            <p style="margin-top: 0.45rem; font-weight: 500;">
                Full-stack applications, front-end interfaces, and containerized tools.
            </p>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 0.65rem;">
            <a href="{{ route('admin.projects.create') }}" class="brutal-btn brutal-btn--pink">
                + ADD PROJECT
            </a>
            <a href="{{ route('home') }}" class="brutal-btn brutal-btn--white">
                ← MAIN MENU
            </a>
        </div>
    </div>

    <!-- Tag Filter Bar -->
    @if ($allTags->isNotEmpty())
        <div class="filter-bar" aria-label="Filter projects by technology tag">
            <span class="mono-label" style="margin-right: 0.35rem;">FILTER BY TAG:</span>
            <a
                href="{{ route('projects.index') }}"
                class="brutal-tag {{ empty($activeTag) ? 'is-active' : '' }}"
            >
                ALL ({{ $projects->count() }})
            </a>
            @foreach ($allTags as $tag)
                <a
                    href="{{ route('projects.index', ['tag' => $tag]) }}"
                    class="brutal-tag {{ $activeTag === $tag ? 'is-active' : '' }}"
                >
                    {{ $tag }}
                </a>
            @endforeach
        </div>
    @endif

    <!-- Projects CSS Grid -->
    @if ($projects->isNotEmpty())
        <div class="projects-grid">
            @foreach ($projects as $index => $project)
                <article class="project-card">
                    <a href="{{ route('projects.show', $project) }}" class="project-thumb bg-{{ $project->color ?? 'yellow' }}">
                        @if (!empty($project->image_url))
                            <img src="{{ $project->image_url }}" alt="{{ $project->title }} screenshot">
                        @endif

                        <div style="position: relative; z-index: 2; display: flex; justify-content: space-between; width: 100%;">
                            <span class="tile-index">
                                #{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }} // {{ $project->year ?? '2026' }}
                            </span>
                            @if ($project->is_featured)
                                <span class="tile-index bg-pink">★ FEATURED</span>
                            @endif
                        </div>

                        <div style="position: relative; z-index: 2;">
                            <span class="brutal-tag">{{ $project->role ?? 'Full-Stack Developer' }}</span>
                        </div>
                    </a>

                    <div class="project-body">
                        <div>
                            <h2 class="display-md" style="margin-bottom: 0.5rem;">
                                <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                            </h2>
                            <p style="color: var(--ink-soft); margin-bottom: 1rem;">
                                {{ $project->summary }}
                            </p>

                            <div class="tag-list">
                                @foreach ($project->tagsList() as $tag)
                                    <a
                                        href="{{ route('projects.index', ['tag' => $tag]) }}"
                                        class="brutal-tag"
                                    >
                                        {{ $tag }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="project-actions">
                            <a href="{{ route('projects.show', $project) }}" class="brutal-btn brutal-btn--sm brutal-btn--yellow">
                                DETAILS →
                            </a>
                            @if (!empty($project->live_url))
                                <a
                                    href="{{ $project->live_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="brutal-btn brutal-btn--sm brutal-btn--cyan"
                                >
                                    LIVE DEMO ↗
                                </a>
                            @endif
                            @if (!empty($project->repo_url))
                                <a
                                    href="{{ $project->repo_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="brutal-btn brutal-btn--sm brutal-btn--white"
                                >
                                    GITHUB ↗
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="brutal-card bg-white" style="text-align: center; padding: 3rem 1.5rem;">
            <h2 class="display-md">NO PROJECTS MATCHING THIS FILTER</h2>
            <p style="margin-top: 0.5rem; margin-bottom: 1.25rem;">
                Try clearing the tag filter or add new projects in the Admin panel.
            </p>
            <div style="display: flex; justify-content: center; gap: 0.75rem;">
                <a href="{{ route('projects.index') }}" class="brutal-btn">SHOW ALL PROJECTS</a>
                <a href="{{ route('admin.projects.create') }}" class="brutal-btn brutal-btn--pink">+ ADD PROJECT</a>
            </div>
        </div>
    @endif
@endsection

