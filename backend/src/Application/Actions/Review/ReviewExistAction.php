<?php
declare(strict_types=1);

namespace App\Application\Actions\Review;


use Psr\Http\Message\ResponseInterface as Response;

class ReviewExistAction extends ReviewAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $order_id = $this->resolveArg('order_id');
        $review_id = $this->reviewRepository->exist($order_id);
        return $this->respondWithData($review_id);
    }
}