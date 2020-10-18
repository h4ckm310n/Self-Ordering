<?php
declare(strict_types=1);

namespace App\Domain\Dish;

use JsonSerializable;

class DishSpec implements JsonSerializable
{
    /**
     * @var string
     */
    private $spec_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $dish_id;

    /**
     * @var float
     */
    private $addition;

    /**
     * DishSpec constructor.
     * @param string $spec_id
     * @param string $name
     * @param string $dish_id
     * @param float $addition
     */
    public function __construct(string $spec_id, string $name, string $dish_id, float $addition)
    {
        $this->spec_id = $spec_id;
        $this->name = $name;
        $this->dish_id = $dish_id;
        $this->addition = $addition;
    }

    /**
     * @return string
     */
    public function getSpecId(): string
    {
        return $this->spec_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDishId(): string
    {
        return $this->dish_id;
    }

    /**
     * @return float
     */
    public function getAddition(): float
    {
        return $this->addition;
    }


    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'spec_id' => $this->spec_id,
            'name' => $this->name,
            'dish_id' => $this->dish_id,
            'addition' => $this->addition
        ];
    }
}