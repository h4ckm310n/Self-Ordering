<?php
declare(strict_types=1);

namespace App\Application\Actions\Order;

use Psr\Http\Message\ResponseInterface as Response;


class OrderDetailAction extends OrderAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $order_id = $this->resolveArg('order_id');
        $user_id = $this->request->getQueryParams()['user_id'];
        $results = $this->orderRepository->detail($order_id, $user_id);
        return $this->respondWithData($results);
    }
}