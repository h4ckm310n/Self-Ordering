<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Review;

use App\Domain\Review\Review;
use App\Domain\Review\ReviewRepository;
use PDO;

class InMemoryReviewRepository implements ReviewRepository
{
    /**
     * @var PDO
     */
    private $conn;

    /**
     * InMemoryReviewRepository constructor.
     *
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
        $sql = "SELECT R.review_id, R.order_id, R.star, R.content, R.datetime FROM Review AS R
                JOIN `Order` AS O ON R.order_id=O.order_id
                JOIN User AS U ON O.user_id=U.user_id
                WHERE U.user_id=?";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $user_id);
        $q->execute();
        $results = $q->fetchAll();
        $reviews = [];
        foreach ($results as $r)
        {
            array_push($reviews, new Review($r['review_id'], $r['order_id'], (float) $r['star'], $r['content'], $r['datetime']));
        }
        return $reviews;
    }

    /**
     * {@inheritdoc}
     */
    public function detail(string $review_id, string $user_id): Review
    {
        $sql = "SELECT R.review_id, R.order_id, R.star, R.content, R.datetime FROM Review AS R
                JOIN `Order` AS O ON R.order_id=O.order_id
                JOIN User AS U ON O.user_id=U.user_id
                WHERE R.review_id=? AND U.user_id=?";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $review_id);
        $q->bindParam(2, $user_id);
        $q->execute();
        $result = $q->fetch();
        return new Review($result['review_id'], $result['order_id'], (float) $result['star'], $result['content'], $result['datetime']);
    }

    /**
     * {@inheritdoc}
     */
    public function exist(string $order_id): string
    {
        $sql = "SELECT review_id FROM Review WHERE order_id=?";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $order_id);
        $q->execute();
        $result = $q->fetch();
        if ($result == null)
            $review_id = 'null';
        else
            $review_id = $result['review_id'];
        return $review_id;
    }

    /**
     * {@inheritdoc}
     */
    public function add(string $review_id, string $order_id, float $star, string $content, string $datetime)
    {
        $sql = "INSERT INTO Review (review_id, order_id, star, content, datetime)
                VALUES (?, ?, ?, ?, ?)";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $review_id);
        $q->bindParam(2, $order_id);
        $q->bindParam(3, $star);
        $q->bindParam(4, $content);
        $q->bindParam(5, $datetime);
        $q->execute();
    }
}