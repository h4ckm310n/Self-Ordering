<?php
declare(strict_types=1);

namespace App\Domain\Dish;

interface DishRepository
{
    /**
     * @return array
     */
    public function listCategories(): array;

    /**
     * @param int $cat
     * @return Dish[]
     */
    public function listByCat(int $cat): array;

    /**
     * @param string $dish_id
     * @return array
     */
    public function detail(string $dish_id): array;

}