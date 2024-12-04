<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');

        $users = $this->userRepository->delete($userId);

        $this->logger->info("Users deleted: {$userId}.");

        return $this->respondWithData($users);
    }
}