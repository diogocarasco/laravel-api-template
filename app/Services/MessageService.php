<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Str;

class MessageService
{
    /**
     * Cria uma nova mensagem.
     *
     * @param array $data
     * @return Message
     */
    public function create(array $data): Message
    {
        $data['id'] = Str::uuid(); // Gera um UUID para o campo ID
        return Message::create($data);
    }

    /**
     * Atualiza uma mensagem existente.
     *
     * @param string $id
     * @param array $data
     * @return Message
     */
    public function update(string $id, array $data): Message
    {
        $message = $this->findById($id);
        $message->update($data);
        return $message;
    }

    /**
     * Busca uma mensagem pelo ID.
     *
     * @param string $id
     * @return Message
     */
    public function findById(string $id): Message
    {
        return Message::findOrFail($id);
    }

    /**
     * Retorna todas as mensagens com filtros opcionais.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(array $filters = [])
    {
        return Message::where($filters)->get();
    }

    /**
     * Exclui uma mensagem pelo ID.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $message = $this->findById($id);
        return $message->delete();
    }
}
