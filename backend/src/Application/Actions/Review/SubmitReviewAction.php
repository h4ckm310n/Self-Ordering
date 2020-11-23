<?php
namespace App\Application\Actions\Review;


use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class SubmitReviewAction extends ReviewAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $form = $this->getFormData();
        $order_id = $form->order_id;
        $star = $form->star;
        $content = $form->content;
        $datetime = date('Y-m-d H:i:s');
        $review_id = md5($order_id.strval($star).$content.$datetime);
        $this->reviewRepository->add($review_id, $order_id, $star, $content, $datetime);
        return $this->respondWithData();
    }
}