<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User;

    /**
     */
    public function create(int $id, string $username, string $firstName, string $lastName): User;

    public function delete(int $id): User;

    public function update(int $id, string $username, string $firstName, string $lastName): User;
}
