<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_main_menu_loads_and_displays_featured_projects(): void
    {
        $project = Project::factory()->create([
            'title' => 'Neobrutal Launchpad',
            'slug' => 'neobrutal-launchpad',
            'is_featured' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('01 // ABOUT ME');
        $response->assertSee('02 // PROJECTS');
        $response->assertSee('03 // CONTACT');
        $response->assertSee($project->title);
    }

    public function test_about_page_loads(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('01 // ABOUT ME');
        $response->assertSee('TECHNICAL ARSENAL');
    }

    public function test_projects_index_and_tag_filter_work(): void
    {
        Project::factory()->create([
            'title' => 'Laravel App',
            'slug' => 'laravel-app',
            'tags' => ['Laravel 11', 'MySQL'],
        ]);

        Project::factory()->create([
            'title' => 'Docker Tool',
            'slug' => 'docker-tool',
            'tags' => ['Docker', 'ARM64'],
        ]);

        $this->get('/projects')
            ->assertStatus(200)
            ->assertSee('Laravel App')
            ->assertSee('Docker Tool');

        $this->get('/projects?tag=Docker')
            ->assertStatus(200)
            ->assertSee('Docker Tool')
            ->assertDontSee('Laravel App');
    }

    public function test_project_detail_page_loads_by_slug(): void
    {
        $project = Project::factory()->create([
            'title' => 'Oracle Cloud Deployer',
            'slug' => 'oracle-cloud-deployer',
        ]);

        $this->get('/projects/oracle-cloud-deployer')
            ->assertStatus(200)
            ->assertSee('Oracle Cloud Deployer');
    }

    public function test_contact_form_validates_and_stores_message(): void
    {
        $this->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => 'short',
        ])->assertSessionHasErrors(['name', 'email', 'message']);

        $response = $this->post('/contact', [
            'name' => 'Grace Hopper',
            'email' => 'grace@navy.mil',
            'subject' => 'Compiler Project',
            'message' => 'Hello! I would love to collaborate on a new full-stack system.',
        ]);

        $response->assertRedirect(route('contact.show'));
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Grace Hopper',
            'email' => 'grace@navy.mil',
            'subject' => 'Compiler Project',
        ]);
    }

    public function test_admin_panel_requires_login_and_can_create_project(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));

        config([
            'portfolio.admin.username' => 'admin',
            'portfolio.admin.password' => 'secret123',
        ]);

        $this->post('/admin/login', [
            'username' => 'admin',
            'password' => 'secret123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->post('/admin/projects', [
            'title' => 'New Admin Project',
            'summary' => 'Created right from the browser admin dashboard.',
            'description' => 'Detailed case study paragraph.',
            'tags_input' => 'PHP 8.3, Laravel 11, CSS Grid',
            'color' => 'pink',
            'role' => 'Creator',
            'year' => '2026',
            'is_featured' => '1',
            'sort_order' => 1,
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('projects', [
            'title' => 'New Admin Project',
            'slug' => 'new-admin-project',
            'color' => 'pink',
        ]);
    }
}

