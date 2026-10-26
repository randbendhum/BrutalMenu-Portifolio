<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', ($portfolio['name'] ?? 'Portfolio') . ' — ' . ($portfolio['role'] ?? 'Full-Stack Developer'))</title>
    <meta name="description" content="@yield('meta_description', $portfolio['tagline'] ?? 'Full-Stack & Front-End Developer Portfolio')">

    <!-- Google Fonts: Space Grotesk + IBM Plex Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500;600;700&family=Space+Grotesk:wght@500;700;800&display=swap" rel="stylesheet">

    <!-- Pure CSS Neobrutalist Design System (Grid & Flexbox) -->
    <link rel="stylesheet" href="{{ asset('css/tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>
<body>

    <!-- Top Sticky Neobrutalist Navbar -->
    <header class="brutal-nav">
        <div class="container nav-inner">
            <a href="{{ route('home') }}" class="nav-brand" title="Back to Main Menu (Shortcut: H)">
                <span class="nav-brand-dot" aria-hidden="true"></span>
                <span>{{ $portfolio['handle'] ?? 'PORTFOLIO.DEV' }}</span>
            </a>

            <button type="button" class="nav-toggle" data-nav-toggle aria-expanded="false" aria-label="Toggle navigation">
                [MENU =]
            </button>

            <nav class="nav-links" data-nav-links aria-label="Main Menu Navigation">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'is-active' : '' }}">
                    <span>00 // MENU</span>
                </a>
                <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'is-active' : '' }}">
                    <span>01 // ABOUT</span>
                </a>
                <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.*') ? 'is-active' : '' }}">
                    <span>02 // PROJECTS</span>
                </a>
                <a href="{{ route('contact.show') }}" class="nav-link nav-link--cta {{ request()->routeIs('contact.*') ? 'is-active' : '' }}">
                    <span>03 // CONTACT →</span>
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main>
        <div class="container page-section">
            @if (session('status'))
                <div class="brutal-toast" role="status">
                    <span>★ {{ session('status') }}</span>
                    <button type="button" class="brutal-btn brutal-btn--sm brutal-btn--white" data-toast-close>
                        OK [X]
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Scrolling Tech Stack Marquee Strip -->
    @if (!empty($portfolio['marquee']))
        <div class="marquee-bar" aria-label="Tech Stack Ticker">
            <div class="marquee-track">
                @for ($loopIndex = 0; $loopIndex < 2; $loopIndex++)
                    @foreach ($portfolio['marquee'] as $item)
                        <span class="marquee-item">
                            <span class="marquee-sep" aria-hidden="true"></span>
                            {{ $item }}
                        </span>
                    @endforeach
                @endfor
            </div>
        </div>
    @endif

    <!-- Neobrutalist Footer -->
    <footer class="brutal-footer">
        <div class="container footer-inner">
            <div>
                <p class="mono-label">
                    © {{ date('Y') }} {{ $portfolio['name'] ?? 'Developer' }} // BUILT WITH PHP 8.3, LARAVEL 11, MYSQL &amp; PURE CSS GRID
                </p>
                <p style="font-size: 0.85rem; margin-top: 0.25rem; color: var(--ink-muted);">
                    Press <strong>[1]</strong> About · <strong>[2]</strong> Projects · <strong>[3]</strong> Contact · <strong>[H]</strong> Main Menu
                </p>
            </div>

            <div class="footer-socials">
                @foreach ($portfolio['socials'] ?? [] as $social)
                    <a
                        href="{{ $social['url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="brutal-btn brutal-btn--sm brutal-btn--{{ $social['color'] ?? 'yellow' }}"
                    >
                        {{ $social['label'] }} ↗
                    </a>
                @endforeach
                <a href="{{ route('admin.dashboard') }}" class="brutal-btn brutal-btn--sm brutal-btn--white" title="Manage Projects & Messages">
                    [ADMIN]
                </a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>

