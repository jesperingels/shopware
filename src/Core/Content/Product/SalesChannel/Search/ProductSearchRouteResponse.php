<?php declare(strict_types=1);

namespace Shopware\Core\Content\Product\SalesChannel\Search;

use Shopware\Core\Content\Product\SalesChannel\Listing\ProductListingResult;
use Shopware\Core\Framework\Log\Package;
use Shopware\Core\System\SalesChannel\StoreApiResponse;

#[Package('inventory')]
class ProductSearchRouteResponse extends StoreApiResponse
{
    /**
     * @var ProductListingResult
     *
     * @deprecated tag:v6.7.0 - Will be natively typed
     */
    protected $object;

    public function getListingResult(): ProductListingResult
    {
        return $this->object;
    }
}
