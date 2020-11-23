<?php
declare(strict_types=1);

namespace App\Application\Actions\Order;

use Psr\Http\Message\ResponseInterface as Response;

class CancelOrderAction extends OrderAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $form = $this->getFormData();
        $user_id = $form->user_id;
        $order_id = $form->order_id;
        $status = 2;
        $this->orderRepository->update($order_id, $user_id, $status);
        return $this->respondWithData();
    }
}