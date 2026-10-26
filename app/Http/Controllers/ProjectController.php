<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $activeTag = $request->query('tag');

        try {
            $allProjects = Project::ordered()->get();
        } catch (Throwable) {
            $allProjects = collect();
        }

        // Collect all unique tags across projects
        $allTags = $allProjects
            ->flatMap(fn (Project $p) => $p->tagsList())
            ->unique()
            ->values();

        $projects = $activeTag
            ? $allProjects->filter(fn (Project $p) => in_array($activeTag, $p->tagsList(), true))->values()
            : $allProjects;

        return view('pages.projects.index', [
            'portfolio' => config('portfolio'),
            'projects' => $projects,
            'allTags' => $allTags,
            'activeTag' => $activeTag,
        ]);
    }

    public function show(Project $project): View
    {
        $relatedProjects = Project::ordered()
            ->where('id', '!=', $project->id)
            ->take(2)
            ->get();

        return view('pages.projects.show', [
            'portfolio' => config('portfolio'),
            'project' => $project,
            'relatedProjects' => $relatedProjects,
        ]);
    }
}

