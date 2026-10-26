<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;
use Throwable;

class HomeController extends Controller
{
    public function index(): View
    {
        try {
            $featuredProjects = Project::featured()->ordered()->take(3)->get();
            $totalProjects = Project::count();
        } catch (Throwable) {
            $featuredProjects = collect();
            $totalProjects = 0;
        }

        return view('pages.home', [
            'portfolio' => config('portfolio'),
            'featuredProjects' => $featuredProjects,
            'totalProjects' => $totalProjects,
        ]);
    }
}

