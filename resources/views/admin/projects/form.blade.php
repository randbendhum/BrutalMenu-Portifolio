@extends('layouts.app')

@section('title', ($isEdit ? 'Edit Project' : 'New Project') . ' — Admin')

@section('content')
    <div style="margin-bottom: 1.25rem;">
        <a href="{{ route('admin.dashboard') }}" class="brutal-btn brutal-btn--sm brutal-btn--white">
            ← BACK TO ADMIN DASHBOARD
        </a>
    </div>

    <div class="brutal-card bg-white" style="max-width: 860px; margin-inline: auto;">
        <div class="tile-header">
            <span class="tile-index bg-yellow">{{ $isEdit ? 'EDIT PROJECT' : 'NEW PROJECT' }}</span>
            <span class="mono-label">STORED IN MYSQL</span>
        </div>

        <h1 class="display-md" style="margin-bottom: 1.25rem;">
            {{ $isEdit ? 'UPDATE: ' . $project->title : 'ADD A NEW PORTFOLIO PROJECT' }}
        </h1>

        <form
            action="{{ $isEdit ? route('admin.projects.update', $project) : route('admin.projects.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="brutal-form"
        >
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="form-grid-2">
                <div class="brutal-field">
                    <label for="title" class="brutal-label">PROJECT TITLE *</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title', $project->title) }}"
                        placeholder="My Awesome App // v1.0"
                        class="brutal-input @error('title') is-invalid @enderror"
                        required
                    >
                    @error('title')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="brutal-field">
                    <label for="slug" class="brutal-label">URL SLUG (AUTO-GENERATED IF EMPTY)</label>
                    <input
                        type="text"
                        id="slug"
                        name="slug"
                        value="{{ old('slug', $project->slug) }}"
                        placeholder="my-awesome-app"
                        class="brutal-input @error('slug') is-invalid @enderror"
                    >
                    @error('slug')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="brutal-field">
                <label for="summary" class="brutal-label">SHORT SUMMARY (SHOWN ON CARDS &amp; MAIN MENU) *</label>
                <input
                    type="text"
                    id="summary"
                    name="summary"
                    value="{{ old('summary', $project->summary) }}"
                    placeholder="One or two punchy sentences explaining what the project does."
                    class="brutal-input @error('summary') is-invalid @enderror"
                    required
                >
                @error('summary')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="brutal-field">
                <label for="description" class="brutal-label">FULL CASE STUDY / DESCRIPTION *</label>
                <textarea
                    id="description"
                    name="description"
                    placeholder="Explain the problem, architecture, challenges, and results. Separate paragraphs with a blank line."
                    class="brutal-textarea @error('description') is-invalid @enderror"
                    style="min-height: 200px;"
                    required
                >{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-grid-2">
                <div class="brutal-field">
                    <label for="tags_input" class="brutal-label">TECH TAGS (COMMA SEPARATED)</label>
                    <input
                        type="text"
                        id="tags_input"
                        name="tags_input"
                        value="{{ old('tags_input', implode(', ', $project->tagsList())) }}"
                        placeholder="PHP 8.3, Laravel 11, MySQL, CSS Grid, Docker"
                        class="brutal-input"
                    >
                </div>

                <div class="brutal-field">
                    <label for="color" class="brutal-label">NEOBRUTALIST CARD ACCENT COLOR *</label>
                    <select id="color" name="color" class="brutal-select">
                        @foreach (['yellow' => 'Yellow (#FFD23F)', 'pink' => 'Pink (#FF6B9D)', 'cyan' => 'Cyan (#4CC9F0)', 'white' => 'White (#FFFFFF)'] as $val => $label)
                            <option value="{{ $val }}" {{ old('color', $project->color) === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="brutal-field">
                    <label for="role" class="brutal-label">YOUR ROLE</label>
                    <input
                        type="text"
                        id="role"
                        name="role"
                        value="{{ old('role', $project->role) }}"
                        placeholder="Full-Stack Developer"
                        class="brutal-input"
                    >
                </div>

                <div class="brutal-field">
                    <label for="year" class="brutal-label">YEAR</label>
                    <input
                        type="text"
                        id="year"
                        name="year"
                        value="{{ old('year', $project->year) }}"
                        placeholder="2026"
                        class="brutal-input"
                    >
                </div>
            </div>

            <div class="form-grid-2">
                <div class="brutal-field">
                    <label for="live_url" class="brutal-label">LIVE DEMO URL</label>
                    <input
                        type="text"
                        id="live_url"
                        name="live_url"
                        value="{{ old('live_url', $project->live_url) }}"
                        placeholder="https://yourproject.com"
                        class="brutal-input"
                    >
                </div>

                <div class="brutal-field">
                    <label for="repo_url" class="brutal-label">GITHUB REPOSITORY URL</label>
                    <input
                        type="text"
                        id="repo_url"
                        name="repo_url"
                        value="{{ old('repo_url', $project->repo_url) }}"
                        placeholder="https://github.com/yourusername/repo"
                        class="brutal-input"
                    >
                </div>
            </div>

            <div class="form-grid-2">
                <div class="brutal-field">
                    <label for="image_file" class="brutal-label">UPLOAD COVER IMAGE (OPTIONAL, MAX 5MB)</label>
                    <input type="file" id="image_file" name="image_file" accept="image/*" class="brutal-input">
                    @error('image_file')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="brutal-field">
                    <label for="image_url" class="brutal-label">OR EXTERNAL IMAGE URL</label>
                    <input
                        type="text"
                        id="image_url"
                        name="image_url"
                        value="{{ old('image_url', $project->image_url) }}"
                        placeholder="https://..."
                        class="brutal-input"
                    >
                </div>
            </div>

            <div class="form-grid-2" style="align-items: center;">
                <div class="brutal-field">
                    <label for="sort_order" class="brutal-label">DISPLAY ORDER (LOWER SHOWS FIRST)</label>
                    <input
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        value="{{ old('sort_order', $project->sort_order ?? 1) }}"
                        class="brutal-input"
                    >
                </div>

                <div class="brutal-field" style="padding-top: 1.4rem;">
                    <label style="display: inline-flex; align-items: center; gap: 0.65rem; cursor: pointer; font-family: var(--font-mono); font-weight: 700;">
                        <input
                            type="checkbox"
                            name="is_featured"
                            value="1"
                            style="width: 22px; height: 22px; accent-color: var(--ink);"
                            {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}
                        >
                        <span>★ FEATURE ON HOME BENTO MAIN MENU</span>
                    </label>
                </div>
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 0.85rem; margin-top: 0.75rem;">
                <button type="submit" class="brutal-btn brutal-btn--lg brutal-btn--yellow">
                    {{ $isEdit ? 'SAVE CHANGES →' : 'PUBLISH PROJECT →' }}
                </button>
                <a href="{{ route('admin.dashboard') }}" class="brutal-btn brutal-btn--lg brutal-btn--white">
                    CANCEL
                </a>
            </div>
        </form>
    </div>
@endsection

