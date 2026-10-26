@extends('layouts.app')

@section('title', 'Admin Login — Portfolio')

@section('content')
    <div style="max-width: 520px; margin-inline: auto;">
        <div class="brutal-card bg-yellow">
            <div class="tile-header">
                <span class="tile-index bg-pink">RESTRICTED // ADMIN</span>
                <span class="mono-label">.ENV CREDENTIALS</span>
            </div>

            <h1 class="display-md" style="margin-bottom: 0.5rem;">PORTFOLIO CONTROL CENTER</h1>
            <p style="margin-bottom: 1.35rem; font-size: 0.95rem;">
                Sign in with your <code>ADMIN_USERNAME</code> and <code>ADMIN_PASSWORD</code> from <code>.env</code> to manage projects and read contact messages.
            </p>

            <form action="{{ route('admin.login.submit') }}" method="POST" class="brutal-form">
                @csrf

                <div class="brutal-field">
                    <label for="username" class="brutal-label">USERNAME</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username', 'admin') }}"
                        class="brutal-input @error('username') is-invalid @enderror"
                        required
                        autofocus
                    >
                    @error('username')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="brutal-field">
                    <label for="password" class="brutal-label">PASSWORD</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="brutal-input @error('password') is-invalid @enderror"
                        required
                    >
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="brutal-btn brutal-btn--lg brutal-btn--cyan brutal-btn--block">
                    UNLOCK ADMIN PANEL →
                </button>
            </form>
        </div>
    </div>
@endsection

