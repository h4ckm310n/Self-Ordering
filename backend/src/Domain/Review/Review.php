<?php
declare(strict_types=1);

namespace App\Domain\Review;

use JsonSerializable;


class Review implements JsonSerializable
{
    /**
     * @var string
     */
    private $review_id;

    /**
     * @var string
     */
    private $order_id;

    /**
     * @var float
     */
    private $star;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $datetime;

    /**
     * Review constructor.
     * @param string $review_id
     * @param string $order_id
     * @param float $star
     * @param string $content
     * @param string $datetime
     */
    public function __construct(string $review_id, string $order_id, float $star, string $content, string $datetime)
    {
        $this->review_id = $review_id;
        $this->order_id = $order_id;
        $this->star = $star;
        $this->content = $content;
        $this->datetime = $datetime;
    }

    /**
     * @return string
     */
    public function getReviewId(): string
    {
        return $this->review_id;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->order_id;
    }

    /**
     * @return float
     */
    public function getStar(): float
    {
        return $this->star;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getDatetime(): string
    {
        return $this->datetime;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'review_id' => $this->review_id,
            'order_id' => $this->order_id,
            'star' => $this->star,
            'content' => $this->content,
            'datetime' => $this->datetime,
        ];
    }
}