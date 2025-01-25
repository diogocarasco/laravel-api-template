<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MessageService;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageServiceTest extends TestCase
{
    use RefreshDatabase;

    protected MessageService $messageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->messageService = new MessageService();
    }

    public function test_can_create_message(): void
    {
        $data = [
            'title' => 'Test Title',
            'text1' => 'Text 1 content',
            'text2' => 'Text 2 content',
            'text3' => 'Text 3 content',
            'date'  => now()->toDateString(),
        ];

        $message = $this->messageService->create($data);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertDatabaseHas('messages', $data);
    }

    public function test_can_update_message(): void
    {
        $message = Message::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'text1' => 'Updated Text 1',
        ];

        $updatedMessage = $this->messageService->update($message->id, $updatedData);

        $this->assertEquals('Updated Title', $updatedMessage->title);
        $this->assertDatabaseHas('messages', $updatedData);
    }

    public function test_can_delete_message(): void
    {
        $message = Message::factory()->create();

        $this->messageService->delete($message->id);

        $this->assertDatabaseMissing('messages', ['id' => $message->id]);
    }
}
