<?php
declare(strict_types=1);

namespace App\Application\Actions\Review;


use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ReviewDetailAction extends ReviewAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user_id = $this->request->getQueryParams()['user_id'];
        $review_id = $this->resolveArg('review_id');
        $result = $this->reviewRepository->detail($review_id, $user_id);
        return $this->respondWithData($result);
    }
}