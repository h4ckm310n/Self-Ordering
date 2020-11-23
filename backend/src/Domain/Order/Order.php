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
     * @var int
     */
    private $credit;

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
     * @var int
     */
    private $order_num;

    /**
     * @var int
     */
    private $dine_way;

    /**
     * @var array
     */
    private $dishes;

    /**
     * Order constructor.
     * @param string $order_id
     * @param string $user_id
     * @param float $amount
     * @param int $credit
     * @param string $remark
     * @param string $datetime
     * @param int $status
     * @param int $order_num
     * @param int $dine_way
     * @param array $dishes
     */
    public function __construct(string $order_id, string $user_id, float $amount, int $credit, string $remark, string $datetime, int $status, int $order_num, int $dine_way, array $dishes)
    {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
        $this->amount = $amount;
        $this->credit = $credit;
        $this->remark = $remark;
        $this->datetime = $datetime;
        $this->status = $status;
        $this->order_num = $order_num;
        $this->dine_way = $dine_way;
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
     * @return int
     */
    public function getCredit(): int
    {
        return $this->credit;
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
     * @return int
     */
    public function getOrderNum(): int
    {
        return $this->order_num;
    }

    /**
     * @return int
     */
    public function getDineWay(): int
    {
        return $this->dine_way;
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
            'credit' => $this->credit,
            'remark' => $this->remark,
            'datetime' => $this->datetime,
            'status' => $this->status,
            'order_num' => $this->order_num,
            'dine_way' => $this->dine_way,
            'dishes' => $this->dishes
        ];
    }
}