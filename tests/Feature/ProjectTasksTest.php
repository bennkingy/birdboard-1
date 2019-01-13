<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function guests_cannot_add_taks_to_projects()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('/login');
    }

    /** @test */
    public function a_project_can_has_tasks()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
        
    }
    
    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }
}
