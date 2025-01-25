<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\FavoriteService;
use App\Models\User;
use App\Models\Message;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteServiceTest extends TestCase
{
    use RefreshDatabase;

    protected FavoriteService $favoriteService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->favoriteService = new FavoriteService();
    }

    public function test_can_create_favorite(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();

        $favorite = $this->favoriteService->create($user->id, $message->id);

        $this->assertInstanceOf(Favorite::class, $favorite);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);
    }

    public function test_can_check_if_favorite_exists(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();

        $this->favoriteService->create($user->id, $message->id);

        $exists = $this->favoriteService->exists($user->id, $message->id);

        $this->assertTrue($exists);
    }

    public function test_can_delete_favorite(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();

        $this->favoriteService->create($user->id, $message->id);
        $this->favoriteService->delete($user->id, $message->id);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);
    }
}
