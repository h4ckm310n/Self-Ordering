<?php
declare(strict_types=1);

namespace App\Domain\Order;

use JsonSerializable;

class Order implements JsonSerializable
{
    /**
     * @var string
     */
    private $order_id;

    /**
     * @var string
     */
    private $user_id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $remark;

    /**
     * @var string
     */
    private $datetime;

    /**
     * @var int
     */
    private $status;

    /**
     * @var array
     */
    private $dishes;

    /**
     * Order constructor.
     * @param string $order_id
     * @param string $user_id
     * @param float $amount
     * @param string $remark
     * @param string $datetime
     * @param int $status
     * @param array $dishes
     */
    public function __construct(string $order_id, string $user_id, float $amount, string $remark, string $datetime, int $status, array $dishes)
    {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
        $this->amount = $amount;
        $this->remark = $remark;
        $this->datetime = $datetime;
        $this->status = $status;
        $this->dishes = $dishes;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->order_id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark;
    }

    /**
     * @return string
     */
    public function getDatetime(): string
    {
        return $this->datetime;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getDishes(): array
    {
        return $this->dishes;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'remark' => $this->remark,
            'datetime' => $this->datetime,
            'status' => $this->status,
            'dishes' => $this->dishes
        ];
    }
}