<?php

declare(strict_types=1);

namespace Pyz\Zed\Oms\Communication\Plugin\Command;

use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\AbstractCommand;
use Spryker\Zed\Oms\Dependency\Plugin\Command\CommandByOrderInterface;

class ShipOrderCommand extends AbstractCommand implements CommandByOrderInterface
{
    public function run(
        array $orderItems,
        SpySalesOrder $orderEntity,
        ReadOnlyArrayObject $data
    ): array {
        return [];
    }
}