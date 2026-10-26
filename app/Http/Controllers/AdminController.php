<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->session()->get('is_portfolio_admin', false)) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login', [
            'portfolio' => config('portfolio'),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $expectedUser = (string) config('portfolio.admin.username', 'admin');
        $expectedPass = (string) config('portfolio.admin.password', 'changeme123');

        if (
            hash_equals($expectedUser, $credentials['username']) &&
            hash_equals($expectedPass, $credentials['password'])
        ) {
            $request->session()->regenerate();
            $request->session()->put('is_portfolio_admin', true);

            return redirect()
                ->route('admin.dashboard')
                ->with('status', 'WELCOME BACK! Admin session unlocked.');
        }

        return back()
            ->withErrors(['username' => 'Invalid admin username or password.'])
            ->onlyInput('username');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('is_portfolio_admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('status', 'Admin session closed.');
    }

    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'portfolio' => config('portfolio'),
            'projects' => Project::ordered()->get(),
            'messages' => ContactMessage::latest()->get(),
            'unreadCount' => ContactMessage::where('is_read', false)->count(),
        ]);
    }

    public function createProject(): View
    {
        return view('admin.projects.form', [
            'portfolio' => config('portfolio'),
            'project' => new Project([
                'color' => 'yellow',
                'role' => 'Full-Stack Developer',
                'year' => date('Y'),
                'is_featured' => true,
                'sort_order' => Project::count() + 1,
                'tags' => ['Laravel 11', 'PHP 8.3', 'CSS Grid'],
            ]),
            'isEdit' => false,
        ]);
    }

    public function storeProject(Request $request): RedirectResponse
    {
        $data = $this->validateProject($request);
        Project::create($data);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'PROJECT CREATED! It is now live on your portfolio.');
    }

    public function editProject(Project $project): View
    {
        return view('admin.projects.form', [
            'portfolio' => config('portfolio'),
            'project' => $project,
            'isEdit' => true,
        ]);
    }

    public function updateProject(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validateProject($request, $project);
        $project->update($data);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'PROJECT UPDATED! Changes are now live.');
    }

    public function destroyProject(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'PROJECT DELETED.');
    }

    public function toggleMessageRead(ContactMessage $message): RedirectResponse
    {
        $message->update(['is_read' => ! $message->is_read]);

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Message status updated.');
    }

    public function destroyMessage(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'Message deleted.');
    }

    private function validateProject(Request $request, ?Project $project = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => [
                'nullable',
                'string',
                'max:180',
                Rule::unique('projects', 'slug')->ignore($project?->id),
            ],
            'summary' => ['required', 'string', 'max:320'],
            'description' => ['required', 'string', 'max:10000'],
            'tags_input' => ['nullable', 'string', 'max:500'],
            'color' => ['required', Rule::in(['yellow', 'pink', 'cyan', 'white'])],
            'role' => ['nullable', 'string', 'max:100'],
            'year' => ['nullable', 'string', 'max:16'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'repo_url' => ['nullable', 'string', 'max:500'],
            'live_url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $slug = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        $tags = collect(explode(',', (string) ($validated['tags_input'] ?? '')))
            ->map(fn (string $tag) => trim($tag))
            ->filter()
            ->values()
            ->all();

        $imageUrl = $validated['image_url'] ?? $project?->image_url;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('projects', 'public');
            $imageUrl = '/storage/' . $path;
        }

        return [
            'title' => $validated['title'],
            'slug' => $slug,
            'summary' => $validated['summary'],
            'description' => $validated['description'],
            'tags' => $tags,
            'color' => $validated['color'],
            'role' => $validated['role'] ?? 'Full-Stack Developer',
            'year' => $validated['year'] ?? date('Y'),
            'image_url' => $imageUrl,
            'repo_url' => ($validated['repo_url'] ?? null) ?: null,
            'live_url' => ($validated['live_url'] ?? null) ?: null,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ];
    }
}

