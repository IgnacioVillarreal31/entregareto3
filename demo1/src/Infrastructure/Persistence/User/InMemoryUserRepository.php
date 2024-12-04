<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private array $users;
    private array $usersTest;
    private string $storageFile;

    /**
     * @param User[]|null $users
     */
    public function __construct()
    {
        $this->storageFile = __DIR__ . '/users.json';
        $this->loadUsers();
    }

    private function loadUsers(): void
    {
        if (file_exists($this->storageFile)) {
            $data = json_decode(file_get_contents($this->storageFile), true);
            $this->users = array_map(function ($userData) {
                return new User(
                    $userData['id'],
                    $userData['username'],
                    $userData['firstName'],
                    $userData['lastName']
                );
            }, $data ?? []);
        } else {
            $this->users = array(
                new User(1, 'bill.gates', 'Bill', 'Gates'),
                new User(2, 'steve.jobs', 'Steve', 'Jobs'),
                new User(3, 'mark.zuckerberg', 'Mark', 'Zuckerberg'),
                new User(4, 'evan.spiegel', 'Evan', 'Spiegel'),
                new User(5, 'jack.dorsey', 'Jack', 'Dorsey'),
            );
        }
    }


    public function create(int $id, string $username, string $firstName, string $lastName): User
    {
        $newUser = new User($id, $username, $firstName, $lastName);
        $this->users[] = $newUser;
        $this->saveUsers();
        return $newUser;
    }

    private function saveUsers(): void
    {
        $data = array_map(function(User $user) {
            return [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName()
            ];
        }, $this->users);

        file_put_contents($this->storageFile, json_encode($data));
    }

    public function findAll(): array
    {
        $this->loadUsers();
        return array_values($this->users);
    }

    public function findUserOfId(int $id): User
    {
        return $this->users[$id];
    }

    public function delete(int $id): User
    {
        $newUser = $this->users[$id];
        unset($this->users[$id]);
        $this->saveUsers();
        return $newUser;
    }

    public function update(int $id, string $username, string $firstName, string $lastName): User
    {
        foreach ($this->users as &$existingUser) {
            if ($existingUser->getId() === $id) {
                $existingUser = new User($id, $username, $firstName, $lastName);
                $this->saveUsers();
                return $existingUser;
            }
        }
        return new User($id, $username, $firstName, $lastName);
    }
}
