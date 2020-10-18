<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Dish;


use App\Domain\Dish\Dish;
use App\Domain\Dish\DishRepository;
use PDO;

class InMemoryDishRepository implements DishRepository
{
    /**
     * @var PDO
     */
    private $conn;

    /**
     * InMemoryDishRepository constructor.
     * @param PDO $conn
     */
    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * {@inheritdoc}
     */
    public function listCategories(): array
    {
        $sql = "SELECT * FROM DishCat ORDER BY cat_id";
        $q = $this->conn->prepare($sql);
        $q->execute();
        $results = $q->fetchAll();
        return $results;
    }

    /**
     * {@inheritdoc}
     */
    public function listByCat(int $cat): array
    {
        $dishes = [];
        $sql = "SELECT D.dish_id, D.name, D.category,
                D.image, D.price, D.discount, D.sales
                FROM Dish AS D JOIN DishCat AS DC ON D.category=DC.cat_id
                WHERE DC.cat_id=?
                ORDER BY D.dish_id";
        $q = $this->conn->prepare($sql);
        $q->bindParam(1, $cat);
        $q->execute();
        $results = $q->fetchAll();
        foreach ($results as $result)
            array_push($dishes, new Dish($result['dish_id'], $result['name'], (int) $result['category'], $result['image'], (float) $result['price'], (float) $result['discount'], (int) $result['sales']));
        return $dishes;
    }

    /**
     * {@inheritdoc}
     */
    public function detail(string $dish_id): array
    {
        $sql1 = "SELECT dish_id, name, description, image, price, discount
                 FROM Dish WHERE dish_id=?";
        $q1 = $this->conn->prepare($sql1);
        $q1->bindParam(1, $dish_id);
        $results = $q1->fetch();

        $sql2 = "SELECT spec_id, name, addition
                 FROM DishSpec WHERE dish_id=?";
        $q2 = $this->conn->prepare($sql2);
        $q2->bindParam(1, $dish_id);
        $q2->execute();
        $specs = $q2->fetchAll();
        $results['specs'] = $specs;
        return $results;
    }

}