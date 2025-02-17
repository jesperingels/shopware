<?php declare(strict_types=1);

namespace Shopware\Core\Content\Sitemap\ConfigHandler;

use Shopware\Core\Framework\Log\Package;

#[Package('discovery')]
interface ConfigHandlerInterface
{
    public function getSitemapConfig(): array;
}
