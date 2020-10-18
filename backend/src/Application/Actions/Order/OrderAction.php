<?php
declare(strict_types=1);

namespace App\Application\Actions\Order;

use App\Application\Actions\Action;
use App\Domain\Order\OrderRepository;
use Psr\Log\LoggerInterface;

abstract class OrderAction extends Action
{
    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @param LoggerInterface
     * @param OrderRepository
     */
    public function __construct(LoggerInterface $logger, OrderRepository $orderRepository)
    {
        parent::__construct($logger);
        $this->orderRepository = $orderRepository;
    }
}