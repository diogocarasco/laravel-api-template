<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_favorite(): void
    {
        // Criando um usuário e uma mensagem
        $user = User::factory()->create();
        $message = Message::factory()->create();

        // Fazendo a requisição POST para criar um favorito
        $response = $this->actingAs($user)
                         ->postJson('/api/favorites', [
                             'user_id' => $user->id,
                             'message_id' => $message->id,
                         ]);

        // Verificando se a resposta é bem-sucedida (201 Created)
        $response->assertStatus(201);

        // Verificando se o favorito foi criado no banco de dados
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);
    }

    public function test_user_cannot_create_duplicate_favorite(): void
    {
        // Criando um usuário e uma mensagem
        $user = User::factory()->create();
        $message = Message::factory()->create();

        // Criando o primeiro favorito
        $this->actingAs($user)->postJson('/api/favorites', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);

        // Tentando criar um favorito duplicado
        $response = $this->actingAs($user)
                         ->postJson('/api/favorites', [
                             'user_id' => $user->id,
                             'message_id' => $message->id,
                         ]);

        // Verificando se a resposta é um erro (409 Conflict ou 422 Unprocessable Entity)
        $response->assertStatus(422);
    }

    public function test_user_can_get_all_favorites(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();

        // Criando favoritos
        $this->actingAs($user)->postJson('/api/favorites', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);

        // Fazendo a requisição GET para obter os favoritos
        $response = $this->actingAs($user)->getJson('/api/favorites');

        // Verificando se a resposta é bem-sucedida
        $response->assertStatus(200);

        // Verificando se o favorito está na resposta
        $response->assertJsonFragment([
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);
    }

    public function test_user_can_delete_favorite(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();

        // Criando um favorito
        $favorite = $this->actingAs($user)->postJson('/api/favorites', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ])->json('data');

        // Fazendo a requisição DELETE para excluir o favorito
        $response = $this->actingAs($user)->deleteJson('/api/favorites', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);

        // Verificando se a resposta é bem-sucedida
        $response->assertStatus(200);

        // Verificando se o favorito foi excluído
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'message_id' => $message->id,
        ]);
    }
}
