<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_create_projects()
    {

        $attrs = factory('App\Project')->raw();

        $this->post('projects', $attrs)->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_projects()
    {
        $this->get('projects')->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_a_single_project()
    {
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->be(factory('App\User')->create());

        $attrs = factory('App\Project')->raw(['owner_id' => auth()->id()]);

        $this->post('projects', $attrs)->assertRedirect('projects');

        $this->assertDatabaseHas('projects', $attrs);

        $this->get('projects')->assertSee($attrs['title']);
    }
    
    /** @test */
    public function a_user_can_view_their_project()
    {

        $this->be(factory('App\User')->create());

        $this->withoutExceptionHandling();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->be(factory('App\User')->create());

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }
    
    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());

        $attrs = factory('App\Project')->raw(['title' => '']);

        $this->post('projects', $attrs)->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());

        $attrs = factory('App\Project')->raw(['description' => '']);

        $this->post('projects', $attrs)->assertSessionHasErrors(['description']);
    }

}
