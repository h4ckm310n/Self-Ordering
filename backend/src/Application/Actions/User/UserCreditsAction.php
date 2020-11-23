<?php


namespace App\Application\Actions\User;


use Psr\Http\Message\ResponseInterface as Response;

class UserCreditsAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user_id = $this->request->getQueryParams()['user_id'];
        $credit = $this->userRepository->credits($user_id);
        return $this->respondWithData(['credit' => $credit]);
    }
}