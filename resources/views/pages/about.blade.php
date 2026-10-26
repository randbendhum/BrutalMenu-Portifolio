@extends('layouts.app')

@section('title', '01 // About Me — ' . ($portfolio['name'] ?? 'Humberto'))

@section('content')
    <!-- Page Header -->
    <div class="page-header bg-cyan">
        <div>
            <span class="tile-index" style="margin-bottom: 0.75rem;">01 // ABOUT ME</span>
            <h1 class="display-lg">{{ $portfolio['about']['headline'] ?? 'Full-Stack & Front-End Developer' }}</h1>
        </div>
        <a href="{{ route('home') }}" class="brutal-btn brutal-btn--white">
            ← BACK TO MAIN MENU
        </a>
    </div>

    <!-- Bio + Quick Profile Sidebar -->
    <div class="about-grid">
        <article class="brutal-card bg-white prose-brutal">
            <div>
                <div class="tile-header">
                    <span class="tile-index bg-yellow">BIO // STORY</span>
                    <span class="mono-label">{{ $portfolio['location'] ?? '' }}</span>
                </div>

                <p style="font-size: 1.2rem; font-weight: 700;">
                    {{ $portfolio['about']['intro'] ?? '' }}
                </p>

                @foreach ($portfolio['about']['paragraphs'] ?? [] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1rem;">
                <a href="{{ route('projects.index') }}" class="brutal-btn brutal-btn--yellow">
                    SEE MY PROJECTS →
                </a>
                <a href="{{ route('contact.show') }}" class="brutal-btn brutal-btn--pink">
                    WORK WITH ME →
                </a>
            </div>
        </article>

        <aside class="brutal-card bg-yellow">
            <div>
                <div class="tile-header">
                    <span class="tile-index">QUICK FACTS</span>
                    <span class="mono-label">ID CARD</span>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                    <div class="avatar-box" style="width: 84px; height: 84px; flex-shrink: 0;">
                        @if (!empty($portfolio['avatar_url']))
                            <img src="{{ $portfolio['avatar_url'] }}" alt="{{ $portfolio['name'] ?? 'Developer' }}">
                        @else
                            <div class="avatar-monogram" style="font-size: 2rem;">
                                {{ strtoupper(substr($portfolio['name'] ?? 'H', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 style="font-size: 1.45rem;">{{ $portfolio['name'] ?? 'Humberto' }}</h2>
                        <p class="mono-label">{{ $portfolio['role'] ?? 'Full-Stack Developer' }}</p>
                    </div>
                </div>

                <div class="skill-check-list">
                    <div class="skill-check-item">
                        <strong>STATUS:</strong>
                        <span>{{ $portfolio['availability_text'] ?? 'Available' }}</span>
                    </div>
                    <div class="skill-check-item">
                        <strong>BASE:</strong>
                        <span>{{ $portfolio['location'] ?? 'Brazil // Remote' }}</span>
                    </div>
                    <div class="skill-check-item">
                        <strong>CORE STACK:</strong>
                        <span>PHP 8, Laravel 11, JS, CSS Grid, MySQL, Docker</span>
                    </div>
                    <div class="skill-check-item">
                        <strong>EMAIL:</strong>
                        <a href="mailto:{{ $portfolio['email'] ?? '' }}" style="text-decoration: underline;">
                            {{ $portfolio['email'] ?? '' }}
                        </a>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <!-- Key Stats Row -->
    @if (!empty($portfolio['about']['stats']))
        <div class="stats-grid">
            @foreach ($portfolio['about']['stats'] as $stat)
                <div class="brutal-card bg-{{ $stat['color'] ?? 'yellow' }}">
                    <span class="display-lg">{{ $stat['value'] }}</span>
                    <span class="mono-label" style="margin-top: 0.4rem;">{{ $stat['label'] }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Categorized Skills & Stack -->
    <section style="margin-bottom: 2.25rem;">
        <h2 class="display-md" style="margin-bottom: 1rem;">TECHNICAL ARSENAL &amp; STACK</h2>
        <div class="skills-grid">
            @php
                $skillColors = ['yellow', 'pink', 'cyan'];
                $colIdx = 0;
            @endphp
            @foreach ($portfolio['about']['skills'] ?? [] as $category => $items)
                <div class="brutal-card bg-{{ $skillColors[$colIdx % count($skillColors)] }}">
                    <div>
                        <div class="tile-header">
                            <span class="tile-index">0{{ $colIdx + 1 }} // STACK</span>
                        </div>
                        <h3 class="display-md">{{ $category }}</h3>
                        <ul class="skill-check-list">
                            @foreach ($items as $skill)
                                <li class="skill-check-item">
                                    <span>■</span>
                                    <span>{{ $skill }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @php $colIdx++; @endphp
            @endforeach
        </div>
    </section>

    <!-- Experience / Background Timeline -->
    @if (!empty($portfolio['about']['timeline']))
        <section>
            <h2 class="display-md" style="margin-bottom: 1rem;">EXPERIENCE &amp; JOURNEY</h2>
            <div class="timeline-stack">
                @foreach ($portfolio['about']['timeline'] as $entry)
                    <article class="brutal-card bg-white">
                        <div class="tile-header">
                            <span class="tile-index bg-{{ $entry['color'] ?? 'yellow' }}">{{ $entry['period'] }}</span>
                            <span class="mono-label">{{ $entry['company'] }}</span>
                        </div>
                        <h3 class="display-md" style="margin-bottom: 0.45rem;">{{ $entry['title'] }}</h3>
                        <p>{{ $entry['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection

