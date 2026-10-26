@extends('layouts.app')

@section('title', 'Admin Dashboard — Portfolio')

@section('content')
    <div class="page-header bg-cyan">
        <div>
            <span class="tile-index" style="margin-bottom: 0.75rem;">ADMIN // CONTROL CENTER</span>
            <h1 class="display-lg">PROJECTS &amp; INBOX MANAGER</h1>
            <p style="margin-top: 0.35rem; font-weight: 500;">
                Add or edit projects live in MySQL. To edit your name, bio, or skills, update <code>.env</code> or <code>config/portfolio.php</code>.
            </p>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 0.65rem;">
            <a href="{{ route('admin.projects.create') }}" class="brutal-btn brutal-btn--yellow">
                + ADD NEW PROJECT
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="brutal-btn brutal-btn--white">
                    LOGOUT [X]
                </button>
            </form>
        </div>
    </div>

    <div class="admin-grid">
        <!-- ==================================================================
             PROJECTS SECTION
             ================================================================== -->
        <section class="brutal-card bg-white">
            <div class="tile-header">
                <span class="tile-index bg-yellow">PROJECTS ({{ $projects->count() }})</span>
                <a href="{{ route('admin.projects.create') }}" class="brutal-btn brutal-btn--sm brutal-btn--pink">
                    + CREATE PROJECT
                </a>
            </div>

            @if ($projects->isNotEmpty())
                <div class="admin-list">
                    @foreach ($projects as $project)
                        <div class="admin-item">
                            <div>
                                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                                    <span class="brutal-tag bg-{{ $project->color }}">#{{ $project->sort_order }}</span>
                                    @if ($project->is_featured)
                                        <span class="brutal-tag bg-pink">★ HOME MENU</span>
                                    @endif
                                    <strong style="font-size: 1.1rem;">{{ $project->title }}</strong>
                                    <span class="mono-label">({{ $project->year }})</span>
                                </div>
                                <p style="font-size: 0.9rem; color: var(--ink-muted);">
                                    {{ $project->summary }}
                                </p>
                            </div>

                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <a href="{{ route('projects.show', $project) }}" class="brutal-btn brutal-btn--sm brutal-btn--white">
                                    VIEW
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="brutal-btn brutal-btn--sm brutal-btn--yellow">
                                    EDIT
                                </a>
                                <form
                                    action="{{ route('admin.projects.destroy', $project) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this project?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="brutal-btn brutal-btn--sm brutal-btn--danger">
                                        DELETE
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mono-label">No projects yet. Click "+ CREATE PROJECT" to add your first one!</p>
            @endif
        </section>

        <!-- ==================================================================
             CONTACT MESSAGES INBOX SECTION
             ================================================================== -->
        <section class="brutal-card bg-white">
            <div class="tile-header">
                <span class="tile-index bg-pink">
                    CONTACT INBOX ({{ $messages->count() }} TOTAL // {{ $unreadCount }} UNREAD)
                </span>
            </div>

            @if ($messages->isNotEmpty())
                <div class="admin-list">
                    @foreach ($messages as $msg)
                        <div class="admin-item" style="background: {{ $msg->is_read ? 'var(--bg-paper)' : 'var(--bg-cream)' }};">
                            <div style="max-width: 72ch;">
                                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; margin-bottom: 0.4rem;">
                                    @if (!$msg->is_read)
                                        <span class="brutal-tag bg-yellow">NEW</span>
                                    @else
                                        <span class="brutal-tag">READ</span>
                                    @endif
                                    <strong>{{ $msg->name }}</strong>
                                    <span class="mono-label">&lt;{{ $msg->email }}&gt;</span>
                                    <span class="mono-label">· {{ $msg->created_at?->diffForHumans() }}</span>
                                </div>

                                @if (!empty($msg->subject))
                                    <p style="font-weight: 700; margin-bottom: 0.3rem;">
                                        Subject: {{ $msg->subject }}
                                    </p>
                                @endif

                                <p style="white-space: pre-line;">{{ $msg->message }}</p>
                            </div>

                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <a href="mailto:{{ $msg->email }}?subject=Re: {{ urlencode($msg->subject ?? 'Your message') }}" class="brutal-btn brutal-btn--sm brutal-btn--cyan">
                                    REPLY ↗
                                </a>

                                <form action="{{ route('admin.messages.toggle', $msg) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="brutal-btn brutal-btn--sm brutal-btn--white">
                                        {{ $msg->is_read ? 'MARK UNREAD' : 'MARK READ' }}
                                    </button>
                                </form>

                                <form
                                    action="{{ route('admin.messages.destroy', $msg) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this message?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="brutal-btn brutal-btn--sm brutal-btn--danger">
                                        DELETE
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mono-label">No contact messages received yet.</p>
            @endif
        </section>
    </div>
@endsection

