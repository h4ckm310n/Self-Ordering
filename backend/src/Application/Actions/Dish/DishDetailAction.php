<?php


namespace App\Application\Actions\Dish;


use Psr\Http\Message\ResponseInterface as Response;

class DishDetailAction extends DishAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $dish_id = $this->resolveArg('dish_id');
        $result = $this->dishRepository->detail($dish_id);
        return $this->respondWithData($result);
    }
}