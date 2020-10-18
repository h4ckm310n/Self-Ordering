<?php


namespace App\Application\Actions\Dish;


use Psr\Http\Message\ResponseInterface as Response;

class ListDishesByCatAction extends DishAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $cat_id = $this->resolveArg('cat_id');
        $dishes = $this->dishRepository->listByCat($cat_id);
        return $this->respondWithData($dishes);
    }
}