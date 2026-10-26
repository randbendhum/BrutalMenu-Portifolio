<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Personal Profile & Hero Configuration
    |--------------------------------------------------------------------------
    | Edit these values directly or override the main ones via your .env file.
    */

    'name' => env('PORTFOLIO_NAME', 'Humberto'),
    'handle' => env('PORTFOLIO_HANDLE', 'HUMBERTO.DEV'),
    'role' => env('PORTFOLIO_ROLE', 'Full-Stack & Front-End Developer'),
    'tagline' => env(
        'PORTFOLIO_TAGLINE',
        'I build fast, bold, resilient web applications — from high-contrast interactive interfaces to rock-solid APIs & cloud infrastructure.'
    ),
    'location' => env('PORTFOLIO_LOCATION', 'Brazil // Remote Worldwide'),
    'available' => (bool) env('PORTFOLIO_AVAILABLE', true),
    'availability_text' => env('PORTFOLIO_AVAILABILITY_TEXT', 'AVAILABLE FOR NEW PROJECTS & ROLES'),
    'email' => env('PORTFOLIO_EMAIL', 'contact@humbertorandon.com'),
    'resume_url' => env('PORTFOLIO_RESUME_URL', '#'),

    // Optional path or URL to your photo (leave null to use the built-in Neobrutalist geometric avatar)
    'avatar_url' => env('PORTFOLIO_AVATAR_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Social Links
    |--------------------------------------------------------------------------
    */

    'socials' => [
        [
            'label' => 'GitHub',
            'short' => 'GH',
            'url' => env('PORTFOLIO_GITHUB', 'https://github.com/randbendhum'),
            'color' => 'yellow',
        ],
        [
            'label' => 'LinkedIn',
            'short' => 'IN',
            'url' => env('PORTFOLIO_LINKEDIN', 'https://www.linkedin.com/in/humberto-randon-17a065428'),
            'color' => 'cyan',
        ],
        [
            'label' => 'Email',
            'short' => 'MAIL',
            'url' => 'mailto:' . env('PORTFOLIO_EMAIL', 'contact@humbertorandon.com'),
            'color' => 'pink',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Scrolling Marquee Strip Keywords
    |--------------------------------------------------------------------------
    */

    'marquee' => [
        'PHP 8.3',
        'LARAVEL 11',
        'JAVASCRIPT / TYPESCRIPT',
        'CSS GRID & FLEXBOX',
        'REACT / NEXT.JS',
        'MYSQL 8',
        'REST & GRAPHQL APIS',
        'DOCKER & LINUX ARM64',
        'ORACLE CLOUD',
        'CLEAN ARCHITECTURE',
    ],

    /*
    |--------------------------------------------------------------------------
    | "About Me" Page Content
    |--------------------------------------------------------------------------
    */

    'about' => [
        'headline' => 'Engineering with personality, speed, and zero bloat.',
        'intro' => 'I am a Full-Stack and Front-End Developer who loves turning complex problems into tactile, responsive web software. Whether crafting semantic CSS Grid layouts from scratch or architecting containerized Laravel + MySQL backends on ARM Linux servers, I care deeply about clarity, performance, and developer experience.',
        'paragraphs' => [
            'On the front-end, I focus on crisp typography, intentional layout systems with CSS Grid & Flexbox, accessible interactions, and zero-lag responsiveness across every screen size.',
            'On the back-end, I build maintainable domain models, well-tested REST APIs, relational schemas in MySQL/PostgreSQL, and automated Docker deployments that run reliably in production.',
        ],
        'stats' => [
            ['value' => '100%', 'label' => 'Custom CSS Grid & Flexbox', 'color' => 'yellow'],
            ['value' => '24/7', 'label' => 'Self-Hosted on Oracle ARM', 'color' => 'cyan'],
            ['value' => '<50ms', 'label' => 'Server Response Target', 'color' => 'pink'],
        ],
        'skills' => [
            'Front-End' => [
                'HTML5 Semantic Markup',
                'CSS3 / Grid / Flexbox',
                'JavaScript (ES2024+) / TypeScript',
                'React / Vue / Alpine.js',
                'Responsive & Accessible UI',
                'Web Performance & Core Web Vitals',
            ],
            'Back-End' => [
                'PHP 8.3 & Laravel 11',
                'Node.js',
                'MySQL 8 & PostgreSQL',
                'RESTful APIs & Auth',
                'Automated Testing (PHPUnit)',
                'Queues, Caching & Jobs',
            ],
            'DevOps & Tools' => [
                'Docker & Docker Compose',
                'Oracle Cloud ARM64 (Linux)',
                'Nginx & Caddy Reverse Proxy',
                'Git & GitHub Actions CI/CD',
                'SSH & Linux Administration',
            ],
        ],
        'timeline' => [
            [
                'period' => 'PRESENT',
                'title' => 'Full-Stack Developer',
                'company' => 'Independent & Open Source Projects',
                'description' => 'Designing and shipping full-stack web products with PHP 8, Laravel 11, modern JavaScript, custom CSS systems, and Dockerized cloud deployments.',
                'color' => 'yellow',
            ],
            [
                'period' => 'PREVIOUS',
                'title' => 'Front-End & Web Developer',
                'company' => 'Web Applications & UI Engineering',
                'description' => 'Built responsive user interfaces, component libraries, and API integrations focused on usability, accessibility, and clean code.',
                'color' => 'cyan',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Credentials (/admin)
    |--------------------------------------------------------------------------
    | Used to add/edit/delete projects and read contact messages via the web UI.
    */

    'admin' => [
        'username' => env('ADMIN_USERNAME', 'admin'),
        'password' => env('ADMIN_PASSWORD', 'changeme123'),
    ],

];

