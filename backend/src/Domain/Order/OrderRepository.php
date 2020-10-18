<?php
declare(strict_types=1);

namespace App\Domain\Order;

interface OrderRepository
{
    /**
     * @param string $user_id
     * @return Order[]
     */
    public function list(string $user_id): array;

    /**
     * @param string $order_id
     * @param string $user_id
     * @param float $amount
     * @param string $remark
     * @param string $datetime
     * @param int $status
     * @param array $dishes
     * @return Order
     */
    public function add(string $order_id, string $user_id, float $amount, string $remark, string $datetime, int $status, array $dishes): Order;

    /**
     * @param string $order_id
     * @param string $user_id
     * @param int $status
     * @return Order
     */
    public function update(string $order_id, string $user_id, int $status): Order;
}