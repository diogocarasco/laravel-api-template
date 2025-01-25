<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
        ];

        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_can_get_user_by_id(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $user->name]);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
