<?php
declare(strict_types=1);

namespace App\Domain\Review;


interface ReviewRepository
{
    /**
     * @param string $user_id
     * @return Review[]
     */
    public function list(string $user_id): array;

    /**
     * @param string $review_id
     * @param string $user_id
     * @return Review
     */
    public function detail(string $review_id, string $user_id): Review;

    /**
     * @param string $order_id
     * @return string
     */
    public function exist(string $order_id): string;

    /**
     * @param string $review_id
     * @param string $order_id
     * @param float $star
     * @param string $content
     * @param string $datetime
     */
    public function add(string $review_id, string $order_id, float $star, string $content, string $datetime);
}