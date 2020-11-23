<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class UserDetailAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user_id = $this->request->getParsedBody()->user_id;
        $user = $this->userRepository->detail($user_id);

        return $this->respondWithData($user);
    }
}
