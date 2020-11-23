<?php
declare(strict_types=1);

namespace App\Application\Actions\Review;


use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ListReviewsAction extends ReviewAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user_id = $this->request->getQueryParams()['user_id'];
        $result = $this->reviewRepository->list($user_id);
        return $this->respondWithData($result);
    }
}