<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TasksTest extends TestCase
{
    use RefreshDatabase;
    protected User $user;
    protected Task $task;
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->task = Task::factory()->create(['user_id' => $this->user->id]);
    }

    public function test_task_created_successfully(): void
    {
        $taskData = [
            'title' => 'Task 1',
            'description' => 'Description for Task 1',
        ];

        $response = $this->actingAs($this->user)->postJson(route('tasks.store'),[
            'title' => $taskData['title'],
            'description' => $taskData['description'],
            'user_id' => $this->user->id,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', [
            'title' => $taskData['title'],
            'description' => $taskData['description'],
            'user_id' => $this->user->id,
        ]);

        $response->assertJsonFragment([
            'title' => $taskData['title'],
            'description' => $taskData['description'],
            'user_id' => $this->user->id,
        ]);
    }

    public function test_tasks_retrieved_successfully(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('tasks.index'));

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'title' => $this->task->title,
            'description' => $this->task->description,
            'user_id' => $this->task->user_id,
        ]);
    }

    public function test_task_retrieved_successfully(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('tasks.show',$this->task->id));

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'title' => $this->task->title,
            'description' => $this->task->description,
            'user_id' => $this->task->user_id,
        ]);
    }

    public function test_task_updated_successfully(): void
    {
        $newTaskData = [
            'title' => 'Task 2'
        ];

        $response = $this->actingAs($this->user)->patchJson(route('tasks.update',$this->task->id),$newTaskData);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'title' => 'Task 2',
            'description' => $this->task->description,
            'user_id' => $this->task->user_id,
        ]);

        $this->assertDatabaseHas('tasks',[
            'id' => $this->task->id,
            'title' => 'Task 2',
        ]);
    }

    public function test_task_deleted_successfully(): void
    {
        $response = $this->actingAs($this->user)->deleteJson(route('tasks.delete',$this->task->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', [
            'id' => $this->task->id,
        ]);
    }
}
