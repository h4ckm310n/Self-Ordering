<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ViewUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user_id = $this->request->getParsedBody()->user_id;
        $user = $this->userRepository->findUserOfId($user_id);

        $this->logger->info("User of id `${user_id}` was viewed.");

        return $this->respondWithData($user);
    }
}
