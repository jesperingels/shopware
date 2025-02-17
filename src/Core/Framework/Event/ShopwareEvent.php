<?php declare(strict_types=1);

namespace Shopware\Core\Framework\Event;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Log\Package;

#[Package('framework')]
interface ShopwareEvent
{
    public function getContext(): Context;
}
