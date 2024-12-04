<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class UpdateUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $requestBody = $this->request->getParsedBody();
        $username = $requestBody['username'] ?? null;
        $firstName = $requestBody['firstName'] ?? null;
        $lastName = $requestBody['lastName'] ?? null;

        $users = $this->userRepository->Update($userId, $username, $firstName, $lastName);

        $this->logger->info("Users updated with id {$userId}.");

        return $this->respondWithData($users);
    }
}