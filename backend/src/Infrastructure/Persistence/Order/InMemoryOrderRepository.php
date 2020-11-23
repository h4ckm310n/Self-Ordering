<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Order;

use App\Domain\Order\Order;
use App\Domain\Order\OrderRepository;
use PDO;

class InMemoryOrderRepository implements OrderRepository
{
    /**
     * @var PDO
     */
    private $conn;

    /**
     * InMemoryOrderRepository constructor.
     * @param PDO $conn
     */
    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * {@inheritdoc}
     */
    public function list(string $user_id): array
    {
        $sql1 = "SELECT * FROM `Order` WHERE user_id=? ORDER BY datetime";
        $q1 = $this->conn->prepare($sql1);
        $q1->bindParam(1, $user_id);
        $q1->execute();
        $r1 = $q1->fetchAll();
        $orders = [];
        foreach ($r1 as $order)
        {
            array_push($orders, new Order($order['order_id'], $user_id, (float) $order['amount'], (int) $order['credit'], $order['remark'], $order['datetime'], (int) $order['status'], (int) $order['order_num'], (int) $order['dine_way'], []));
        }
        return $orders;
    }

    /**
     * {@inheritdoc}
     */
    public function getOpenId(string $user_id): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function add(string $order_id, string $user_id, float $amount, int $credit, string $remark, string $datetime, int $status, int $dine_way, array $dishes): Order
    {
        $sql1 = "INSERT INTO `Order` (order_id, user_id, amount, credit, remark, datetime, status, order_num, dine_way)
                 VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?)";
        $q1 = $this->conn->prepare($sql1);
        $q1->bindParam(1, $order_id);
        $q1->bindParam(2, $user_id);
        $q1->bindParam(3, $amount);
        $q1->bindParam(4, $credit);
        $q1->bindParam(5, $remark);
        $q1->bindParam(6, $datetime);
        $q1->bindParam(7, $status);
        $q1->bindParam(8, $dine_way);
        $q1->execute();
        foreach ($dishes as $dish)
        {
            $sql2 = "INSERT INTO Order_Dish (order_id, dish_id, price, count)
                     VALUES (?, ?, ?, ?)";
            $q2 = $this->conn->prepare($sql2);
            $q2->bindParam(1, $order_id);
            $q2->bindParam(2, $dish->dish_id);
            $q2->bindParam(3, $dish->price);
            $q2->bindParam(4, $dish->count);
            $q2->execute();
        }
        return new Order($order_id, $user_id, (float) $amount, (int) $credit, $remark, $datetime, (int) $status, 0, (int) $dine_way, $dishes);
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $order_id, string $user_id, int $status)
    {
        $sql = "UPDATE `Order` SET status=? WHERE order_id=? AND user_id=?";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $status);
        $q->bindParam(2, $order_id);
        $q->bindParam(3, $user_id);
        $q->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function deduct_credit(string $order_id, string $user_id)
    {
        $sql = "UPDATE User AS U JOIN `Order` AS O
                ON U.user_id=O.user_id
                SET U.credit=U.credit-O.credit
                WHERE U.user_id=?
                AND O.credit=
                (SELECT O.credit FROM `Order` AS O WHERE order_id=?)";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $user_id);
        $q->bindParam(2, $order_id);
        $q->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function gen_order_num(string $order_id)
    {
        $today = date('Y-m-d');
        $sql = "UPDATE `Order` SET order_num=
                (SELECT COUNT(*)+1 AS N FROM (SELECT * FROM `Order`) AS O WHERE datetime LIKE '$today%' AND order_id!=?)
                WHERE order_id=?";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $order_id);
        $q->bindParam(2, $order_id);
        $q->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function detail(string $order_id, string $user_id): Order
    {
        $sql1 = "SELECT * FROM `Order` WHERE order_id=? AND user_id=?";
        $q1 = $this->conn->prepare($sql1);
        $q1->bindParam(1, $order_id);
        $q1->bindParam(2, $user_id);
        $q1->execute();
        $r1 = $q1->fetch();
        $sql2 = "SELECT OD.dish_id, OD.count, OD.price, D.name FROM Order_Dish AS OD
                 JOIN Dish AS D ON D.dish_id=OD.dish_id WHERE OD.order_id=?";
        $q2 = $this->conn->prepare($sql2);
        $q2->bindParam(1, $order_id);
        $q2->execute();
        $r2 = $q2->fetchAll();
        for ($i=0; $i<count($r2); ++$i)
        {
            $r2[$i]['count'] = (int) $r2[$i]['count'];
            $r2[$i]['price'] = (float) $r2[$i]['price'];
        }
        return new Order($order_id, $user_id, (float) $r1['amount'], (int) $r1['credit'], $r1['remark'], $r1['datetime'], (int) $r1['status'], (int) $r1['order_num'], (int) $r1['dine_way'], $r2);
    }
}