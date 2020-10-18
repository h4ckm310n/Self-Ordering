<?php
declare(strict_types=1);

namespace App\Application\Actions\Dish;

use App\Application\Actions\Action;
use App\Domain\Dish\DishRepository;
use Psr\Log\LoggerInterface;


abstract class DishAction extends Action
{
    /**
     * @var DishRepository
     */
    protected $dishRepository;

    /**
     * @param LoggerInterface $logger
     * @param DishRepository  $dishRepository
     */
    public function __construct(LoggerInterface $logger, DishRepository $dishRepository)
    {
        parent::__construct($logger);
        $this->dishRepository = $dishRepository;
    }
}