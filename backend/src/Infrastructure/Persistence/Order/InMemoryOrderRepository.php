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
        $sql1 = "SELECT * FROM Order WHERE user_id=?";
        $q1 = $this->conn->prepare($sql1);
        $q1->bindParam(1, $user_id);
        $q1->execute();
        $r1 = $q1->fetchAll();
        $orders = [];
        foreach ($r1 as $order)
        {
            $sql2 = "SELECT OD.dish_id, OD.count, OD.price, D.name FROM Order_Dish AS OD
                     JOIN Dish AS D ON D.dish_id=OD.dish_id WHERE OD.order_id=?";
            $q2 = $this->conn->prepare($sql2);
            $q2->bindParam(1, $order['order_id']);
            $q2->execute();
            $r2 = $q2->fetchAll();
            for ($i=0; $i<count($r2); ++$i)
            {
                $r2[$i]['count'] = (int) $r2[$i]['count'];
                $r2[$i]['price'] = (float) $r2[$i]['price'];
            }
            array_push($orders, new Order($order['order_id'], $user_id, (float) $order['amount'], $order['remark'], $order['datetime'], $order['status'], $r2));
        }
        return $orders;
    }

    /**
     * {@inheritdoc}
     */
    public function add(string $order_id, string $user_id, float $amount, string $remark, string $datetime, int $status, array $dishes): Order
    {
        $sql1 = "INSERT INTO Order (order_id, user_id, amount, remark, datetime, status)
                 VALUES (?, ?, ?, ?, ?, ?)";
        $q1 = $this->conn->prepare($sql1);
        $q1->bindParam(1, $order_id);
        $q1->bindParam(2, $user_id);
        $q1->bindParam(3, $amount);
        $q1->bindParam(4, $remark);
        $q1->bindParam(5, $datetime);
        $q1->bindParam(1, $status);
        $q1->execute();
        foreach ($dishes as $dish)
        {
            $sql2 = "INSERT INTO Order_Dish (order_id, dish_id, price, count)
                     VALUES (?, ?, ?, ?)";
            $q2 = $this->conn->prepare($sql2);
            $q2->bindParam(1, $order_id);
            $q2->bindParam(2, $dish['dish_id']);
            $q2->bindParam(3, $dish['price']);
            $q2->bindParam(4, $dish['count']);
            $q2->execute();
        }
        return new Order($order_id, $user_id, $amount, $remark, $datetime, $status, $dishes);
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $order_id, string $user_id, int $status): Order
    {
        $sql = "UPDATE Order SET status=? WHERE order_id=? AND user_id=?";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $status);
        $q->bindParam(2, $order_id);
        $q->bindParam(3, $user_id);
        $q->execute();
        return null;
    }
}