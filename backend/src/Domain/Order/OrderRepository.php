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
     * @param string $user_id
     * @return string
     */
    public function getOpenId(string $user_id): string;

    /**
     * @param string $order_id
     * @param string $user_id
     * @param float $amount
     * @param int $credit
     * @param string $remark
     * @param string $datetime
     * @param int $status
     * @param int $dine_way
     * @param array $dishes
     */
    public function add(string $order_id, string $user_id, float $amount, int $credit, string $remark, string $datetime, int $status, int $dine_way, array $dishes);

    /**
     * @param string $order_id
     * @param string $user_id
     * @param int $status
     */
    public function update(string $order_id, string $user_id, int $status);

    /**
     * @param string $order_id
     * @param string $user_id
     */
    public function deduct_credit(string $order_id, string $user_id);

    /**
     * @param string $order_id
     */
    public function gen_order_num(string $order_id);

    /**
     * @param string $order_id
     * @param string $user_id
     * @return Order
     */
    public function detail(string $order_id, string $user_id): Order;
}