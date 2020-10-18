<?php
declare(strict_types=1);

namespace App\Domain\Dish;

use JsonSerializable;

class Dish implements JsonSerializable
{
    /**
     * @var string
     */
    private $dish_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $category;

    /**
     * @var string
     */
    private $image;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $discount;

    /**
     * @var int
     */
    private $sales;

    /**
     * Dish constructor.
     * @param string $dish_id
     * @param string $name
     * @param int $category
     * @param string $image
     * @param float $price
     * @param float $discount
     * @param int $sales
     */
    public function __construct(string $dish_id, string $name, int $category, string $image, float $price, float $discount, int $sales)
    {
        $this->dish_id = $dish_id;
        $this->name = $name;
        $this->category = $category;
        $this->image = $image;
        $this->price = $price;
        $this->discount = $discount;
        $this->sales = $sales;
    }

    /**
     * @return string
     */
    public function getDishId(): string
    {
        return $this->dish_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @return int
     */
    public function getSales(): int
    {
        return $this->sales;
    }


    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'dish_id' => $this->dish_id,
            'name' => $this->name,
            'category' => $this->category,
            'image' => $this->image,
            'price' => $this->price,
            'discount' => $this->discount,
            'sales' => $this->sales
        ];
    }

}