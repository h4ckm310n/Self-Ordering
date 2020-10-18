<?php
declare(strict_types=1);

namespace App\Application\Actions\Order;

use Psr\Http\Message\ResponseInterface as Response;

class ListOrdersAction extends OrderAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user_id = $this->request->getParsedBody()->user_id;
        $results = $this->orderRepository->list($user_id);
        return $this->respondWithData($results);
    }
}