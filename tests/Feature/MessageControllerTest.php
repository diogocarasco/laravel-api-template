<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_message(): void
    {
        $data = [
            'title' => 'Test Message',
            'text1' => 'This is the first text.',
            'text2' => 'This is the second text.',
            'text3' => 'This is the third text.',
            'date'  => now()->toDateString(),
        ];

        $response = $this->postJson('/api/messages', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('messages', ['title' => 'Test Message']);
    }

    public function test_can_get_message_by_id(): void
    {
        $message = Message::factory()->create();

        $response = $this->getJson("/api/messages/{$message->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $message->title]);
    }

    public function test_can_update_message(): void
    {
        $message = Message::factory()->create();
        $updatedData = [
            'title' => 'Updated Message',
            'text1' => 'Updated text.',
        ];

        $response = $this->putJson("/api/messages/{$message->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('messages', ['title' => 'Updated Message']);
    }

    public function test_can_delete_message(): void
    {
        $message = Message::factory()->create();

        $response = $this->deleteJson("/api/messages/{$message->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('messages', ['id' => $message->id]);
    }
}
