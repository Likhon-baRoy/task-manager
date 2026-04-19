<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_tasks()
    {
        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_create_task()
    {
        $response = $this->post('/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'pending'
        ]);

        $response->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task'
        ]);
    }

    /** @test */
    public function user_can_update_task()
    {
        $task = Task::create([
            'title' => 'Old Task',
            'status' => 'pending'
        ]);

        $response = $this->put("/tasks/{$task->id}", [
            'title' => 'Updated Task',
            'status' => 'completed'
        ]);

        $response->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', [
            'title' => 'Updated Task',
            'status' => 'completed'
        ]);
    }

    /** @test */
    public function user_can_delete_task()
    {
        $task = Task::create([
            'title' => 'Delete Me',
            'status' => 'pending'
        ]);

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }
}