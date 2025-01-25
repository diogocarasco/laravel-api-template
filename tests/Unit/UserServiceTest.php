<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    public function test_can_create_user(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
        ];

        $user = $this->userService->create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->create();

        $updatedData = [
            'name' => 'Updated Name',
        ];

        $updatedUser = $this->userService->update($user->id, $updatedData);

        $this->assertEquals('Updated Name', $updatedUser->name);
        $this->assertDatabaseHas('users', $updatedData);
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();

        $this->userService->delete($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
