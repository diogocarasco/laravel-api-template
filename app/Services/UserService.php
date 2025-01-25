<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Cria um novo usuário.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']); // Criptografa a senha
        return User::create($data);
    }

    /**
     * Atualiza os dados de um usuário.
     *
     * @param int|string $id
     * @param array $data
     * @return User
     */
    public function update($id, array $data): User
    {
        $user = $this->findById($id);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']); // Criptografa a nova senha
        }

        $user->update($data);

        return $user;
    }

    /**
     * Busca um usuário pelo ID.
     *
     * @param int|string $id
     * @return User
     */
    public function findById($id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Busca usuários com base em filtros opcionais.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(array $filters = [])
    {
        $query = User::query();

        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }

        return $query->get();
    }

    /**
     * Altera a senha de um usuário.
     *
     * @param int|string $id
     * @param string $newPassword
     * @return bool
     */
    public function changePassword($id, string $newPassword): bool
    {
        $user = $this->findById($id);

        return $user->update([
            'password' => Hash::make($newPassword),
        ]);
    }

    /**
     * Exclui um usuário.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete($id): bool
    {
        $user = $this->findById($id);
        return $user->delete();
    }

    /**
     * Verifica as credenciais de um usuário.
     *
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function verifyCredentials(string $email, string $password): ?User
    {
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return null;
    }
}
