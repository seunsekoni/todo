<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Todo;

class TodoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_if_todo_can_be_created()
    {
        $response = $this->post('/api/todos', [
            'todo' => 'Testing Todo'
        ]);

        $response->assertStatus(200);
        
        $this->assertTrue(count(Todo::all()) > 0);
        $this->assertDatabaseHas('todos', [
            'todo' => 'Testing Todo'
        ]);
    }

    public function test_validation_while_creating_todo()
    {
        $response = $this->postJson('/api/todos');

        $response->assertJsonValidationErrors(['todo']);
    }

    public function test_if_a_todo_can_be_marked_completed()
    {
        $todo = Todo::factory()->completed(0)->create();

        $response = $this->patchJson('/api/todos/completed/'.$todo->id, [$todo->toArray()]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'completed' => 1
        ]);
    }

    public function test_if_a_todo_can_be_marked_incomplete()
    {
        $todo = Todo::factory()->completed(1)->create();

        $response = $this->patchJson('/api/todos/incomplete/'.$todo->id, [$todo->toArray()]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'completed' => 0
        ]);
    }

    public function test_if_a_todo_can_be_updated()
    {
        $todo = Todo::factory()->completed(0)->create();
        $response = $this->putJson('/api/todos/'.$todo->id, [
            'todo' => 'updated Testing',
            'completed' => 1
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successfully updated Todo'
        ]);
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'todo' => 'updated Testing'
        ]);
    }

    public function test_if_resource_not_found_message_kicks_in_when_resource_does_not_exist()
    {
        $todo = Todo::factory()->completed(0)->create();
        $todo->delete();
        $this->assertDeleted($todo);
        $response = $this->putJson('/api/todos/'.$todo->id, [
            'todo' => 'updated Testing',
            'completed' => 1
        ]);
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Resource could not be found.'
        ]);
        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
            'todo' => $todo->todo
        ]);

    }

    public function test_if_a_todo_can_be_deleted()
    {
        $todo = Todo::factory()->completed(1)->create();

        $response = $this->deleteJson('/api/todos/'.$todo->id);

        $this->assertDeleted($todo);

        $response->assertJson([
            'message' => 'Successfully deleted Todo'
        ]);
    }

}
