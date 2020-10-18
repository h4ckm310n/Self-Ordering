<?php


namespace App\Application\Actions\Dish;


use Psr\Http\Message\ResponseInterface as Response;

class ListCategoriesAction extends DishAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $result = $this->dishRepository->listCategories();
        return $this->respondWithData($result);
    }
}