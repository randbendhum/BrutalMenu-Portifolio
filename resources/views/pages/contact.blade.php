@extends('layouts.app')

@section('title', '03 // Contact — ' . ($portfolio['name'] ?? 'Humberto'))

@section('content')
    <!-- Page Header -->
    <div class="page-header bg-pink">
        <div>
            <span class="tile-index" style="margin-bottom: 0.75rem;">03 // DIRECT CHANNEL</span>
            <h1 class="display-lg">LET'S BUILD SOMETHING BOLD</h1>
            <p style="margin-top: 0.45rem; font-weight: 500;">
                Send a message below — it saves directly to MySQL and notifies my admin dashboard.
            </p>
        </div>
        <a href="{{ route('home') }}" class="brutal-btn brutal-btn--white">
            ← MAIN MENU
        </a>
    </div>

    <div class="contact-grid">
        <!-- Left Sidebar: Direct Channels -->
        <aside class="brutal-card bg-yellow">
            <div>
                <div class="tile-header">
                    <span class="tile-index">CHANNELS</span>
                    <span class="mono-label">{{ $portfolio['location'] ?? 'Remote' }}</span>
                </div>

                <h2 class="display-md" style="margin-bottom: 0.65rem;">DIRECT INFO</h2>
                <p style="margin-bottom: 1.35rem;">
                    Available for full-stack roles, front-end engineering, freelance builds, or technical collaborations.
                </p>

                <div class="skill-check-list" style="margin-bottom: 1.5rem;">
                    <div class="skill-check-item">
                        <strong>EMAIL:</strong>
                        <a href="mailto:{{ $portfolio['email'] ?? '' }}" style="text-decoration: underline;">
                            {{ $portfolio['email'] ?? '' }}
                        </a>
                    </div>
                    <div class="skill-check-item">
                        <strong>STATUS:</strong>
                        <span>{{ $portfolio['availability_text'] ?? 'Available' }}</span>
                    </div>
                </div>

                <h3 class="mono-label" style="margin-bottom: 0.65rem;">SOCIAL NETWORKS</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 0.65rem;">
                    @foreach ($portfolio['socials'] ?? [] as $social)
                        <a
                            href="{{ $social['url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="brutal-btn brutal-btn--sm brutal-btn--white"
                        >
                            {{ $social['label'] }} ↗
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- Right Card: Neobrutalist Contact Form -->
        <section class="brutal-card bg-white">
            <div class="tile-header">
                <span class="tile-index bg-cyan">SEND MESSAGE</span>
                <span class="mono-label">ALL FIELDS MARKED * REQUIRED</span>
            </div>

            <form action="{{ route('contact.store') }}" method="POST" class="brutal-form" novalidate>
                @csrf

                <div class="form-grid-2">
                    <div class="brutal-field">
                        <label for="name" class="brutal-label">YOUR NAME *</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ada Lovelace"
                            class="brutal-input @error('name') is-invalid @enderror"
                            required
                        >
                        @error('name')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="brutal-field">
                        <label for="email" class="brutal-label">YOUR EMAIL *</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="ada@analyticalengine.org"
                            class="brutal-input @error('email') is-invalid @enderror"
                            required
                        >
                        @error('email')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="brutal-field">
                    <label for="subject" class="brutal-label">SUBJECT / PROJECT TYPE</label>
                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        value="{{ old('subject') }}"
                        placeholder="Full-Stack Project / Job Opportunity / Say Hi"
                        class="brutal-input @error('subject') is-invalid @enderror"
                    >
                    @error('subject')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="brutal-field">
                    <label for="message" class="brutal-label">YOUR MESSAGE *</label>
                    <textarea
                        id="message"
                        name="message"
                        placeholder="Tell me about your timeline, goals, or role..."
                        class="brutal-textarea @error('message') is-invalid @enderror"
                        required
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="brutal-btn brutal-btn--lg brutal-btn--yellow">
                        SEND MESSAGE NOW →
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection

