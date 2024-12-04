<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class CreateUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $requestBody = $this->request->getParsedBody();

        $id = (int)$requestBody['id'] ?? null;
        $username = $requestBody['username'] ?? null;
        $firstName = $requestBody['firstName'] ?? null;
        $lastName = $requestBody['lastName'] ?? null;

        $newUser = $this->userRepository->create($id, $username, $firstName, $lastName);

        return $this->respondWithData($newUser);
    }
}
